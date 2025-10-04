<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Article;
use App\Models\Category;
use App\Models\Settings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SitemapGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate {news?} {year?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Günlük olarak sitemap oluşturur ve günceller. Yıl parametresi ile belirli yıl için sitemap oluşturabilir.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $settings = Settings::select('magicbox')->find(1);
        $magicboxAarray = json_decode($settings->magicbox, true);

        $this->info('Sitemap İşlemleri başlıyor...');

        $type = $this->argument('news');


        if ($type == 'news') {

            $message = $this->newsSitemapGenerate();
        } else if ($type == 'article') {
            $message = $this->articleSitemapGenerate();
        } else if ($type == 'category') {

            $message = $this->categorySitemapGenerate();
        } else {
            $this->error('Sadece "news,article,category" tipleri  destekleniyor. type => ' . $type);
            return Command::FAILURE;
            if ($message === false) {
                $this->error('Sitemap oluşturma işlemi başarısız oldu.');
                return Command::FAILURE;
            }
        }


        $this->info($message);
        Log::info('Sitemap İşlemleri tamamlandı - ' . $message);
        return Command::SUCCESS;
    }


    private function newsSitemapGenerate()
    {
        $year = $this->argument('year');

        $months = [];

        if ($year !== null && $year !== 'all') {

            $year = (int) $year;
            for ($month = 1; $month <= 12; $month++) {
                $months[] = [
                    'start' => Carbon::create($year, $month, 1)->startOfMonth(),
                    'end' => Carbon::create($year, $month, 1)->endOfMonth(),
                    'name' => Carbon::create($year, $month, 1)->format('Y-m')
                ];
            }
        } elseif ($year === 'all') {
            // Tüm yılları işle
            $years = Post::withoutGlobalScopes()->where(['publish' => 0, 'deleted_at' => NULL])
                ->where('created_at', '<=', now())->where('deleted_at', NULL)
                ->selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'asc')
                ->pluck('year')
                ->toArray();

            foreach ($years as $yearValue) {
                for ($month = 1; $month <= 12; $month++) {
                    $months[] = [
                        'start' => Carbon::create($yearValue, $month, 1)->startOfMonth(),
                        'end' => Carbon::create($yearValue, $month, 1)->endOfMonth(),
                        'name' => Carbon::create($yearValue, $month, 1)->format('Y-m')
                    ];
                }
            }
        } else {
            // Yıl verilmediyse, SADECE geçerli ayı işle
            $months[] = [
                'start' => now()->startOfMonth(),
                'end' => now()->endOfMonth(),
                'name' => now()->format('Y-m')
            ];
        }

        $totalFiles = 0;

        foreach ($months as $month) {
            $posts = Post::withoutGlobalScopes()->where(['publish' => 0, 'deleted_at' => NULL])
                ->where('created_at', '<=', now())
                ->whereBetween('created_at', [$month['start'], $month['end']])
                ->with('category')->with('author')
                ->select(['id', 'title', 'slug', 'keywords', 'category_id', 'created_at', 'author_id'])
                ->orderBy('id', 'desc');

            $chunkIndex = 1;

            $posts->chunk(1000, function ($countPosts) use (&$chunkIndex, $month, &$totalFiles, ) {
                if (blank($countPosts)) {
                    return;
                }

                $xmlDeclaration = '<?xml version="1.0" encoding="UTF-8"?>';
                $xmlStylesheet = '';



                $content = $this->generateSitemapXmlForPosts($countPosts, $xmlDeclaration, $xmlStylesheet, "news");
                // XML dosyasını kaydet
                $fileIndex = $chunkIndex > 1 ? '-' . $chunkIndex : '';
                $filename = 'sitemap-news-' . $month['name'] . $fileIndex . '.xml';
                $path = public_path('sitemaps/' . $filename);

                $directory = dirname($path);


                if (!file_exists($directory)) {
                    try {
                        if (!mkdir($directory, 0755, true) && !is_dir($directory)) {
                            throw new \RuntimeException("Failed to create directory: {$directory}");
                        }
                    } catch (\Exception $e) {
                        // Log the error and try with broader permissions (development only)
                        error_log($e->getMessage());
                        mkdir($directory, 0755, true);
                    }
                }
                file_put_contents($path, $content);

                // Son haberin created_at tarihini dosya ekleme tarihi olarak ayarla
                $latestCreatedAt = $countPosts->max('created_at');
                if ($latestCreatedAt) {
                    $timestamp = Carbon::parse($latestCreatedAt)->timestamp;

                    if (file_exists($path) && is_writable($path)) {
                        touch($path, $timestamp);
                    } elseif (is_writable(dirname($path))) {
                        // Dosya yoksa ve dizin yazılabilirse oluştur
                        touch($path, $timestamp);
                    } else {
                        Log::warning("Cannot touch file due to permissions: " . $path);
                        return false;
                    }
                }

                $chunkIndex++;
                $totalFiles++;

                $this->info("Dosya oluşturuldu: {$filename}");
            });
        }

        // Sonuç mesajları
        if ($year === 'all') {
            $message = "Tüm yılların sitemap'leri oluşturuldu! Toplam {$totalFiles} dosya oluşturuldu. 1";
        } elseif ($year !== null) {
            $message = "{$year} yılına ait tüm ayların sitemap'leri oluşturuldu! Toplam {$totalFiles} dosya oluşturuldu. 2";
        } else {
            $message = "Geçerli ayın sitemap'i oluşturuldu! Toplam {$totalFiles} dosya oluşturuldu. 3";
        }


        return $message;
    }



    /**
     * Sitemap XML içeriği oluştur (Laravel Blade template'ini taklit eder)
     */
    private function generateSitemapXmlForPosts($posts, $xmlDeclaration, $xmlStylesheet, $type)
    {
        $xml = $xmlDeclaration . "\n" . $xmlStylesheet . "\n\n";

        if ($type == "news") {
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" ';
            $xml .= 'xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">' . "\n";
        } else {
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        }

        foreach ($posts as $post) {
            // Eğer kategori yoksa bu postu atla
            if (!$post->category) {
                continue;
            }

            $routeUrl = route('post', [
                'categoryslug' => $post->category->slug,
                'slug' => $post->slug,
                'id' => $post->id
            ]);

            if ($type == "news") {
                $xml .= "  <url>\n";
                $xml .= "    <loc>{$routeUrl}</loc>\n";
                $xml .= "    <news:news>\n";
                $xml .= "      <news:publication>\n";
                $xml .= "        <news:name><![CDATA[" . config('app.name') . "]]></news:name>\n";
                $xml .= "        <news:language>tr</news:language>\n";
                $xml .= "      </news:publication>\n";
                $xml .= "      <news:publication_date>" . Carbon::parse($post->created_at)->toIso8601String() . "</news:publication_date>\n";
                $xml .= "      <news:title><![CDATA[" . $post->title . "]]></news:title>\n";
                $authorName = $post->author?->name ?? 'Admin';
                $xml .= "      <news:authors><![CDATA[" . $authorName . " - EDİTÖR]]></news:authors>\n";
                $xml .= "      <news:category><![CDATA[" . $post->category->title . "]]></news:category>\n";
                if (!empty($post->keywords)) {
                    $xml .= "      <news:keywords><![CDATA[" . $post->keywords . "]]></news:keywords>\n";
                }
                $xml .= "    </news:news>\n";
                $xml .= "  </url>\n";
            } else {
                // article & category sitemap mantığına dokunmuyoruz
                $xml .= "  <url>\n";
                $xml .= "    <loc>{$routeUrl}</loc>\n";
                $xml .= "    <lastmod>" . Carbon::parse($post->created_at)->toIso8601String() . "</lastmod>\n";
                $xml .= "  </url>\n";
            }
        }

        $xml .= "</urlset>";
        return $xml;
    }






    private function articleSitemapGenerate()
    {

        $year = $this->argument('year');

        $months = [];

        if ($year !== null && $year !== 'all') {
            // Belirli bir yıl verildiyse, o yılın TÜM aylarını işle
            for ($month = 1; $month <= 12; $month++) {
                $months[] = [
                    'start' => Carbon::create($year, $month, 1)->startOfMonth(),
                    'end' => Carbon::create($year, $month, 1)->endOfMonth(),
                    'name' => Carbon::create($year, $month, 1)->format('Y-m')
                ];
            }
        } elseif ($year === 'all') {
            // Tüm yılları işle
            $years = Article::withoutGlobalScopes()->where('publish', 0)
                ->where('created_at', '<=', now())
                ->with(['author:id,name']) // Eğer kategori ilişkisi varsa
                ->selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'asc')
                ->pluck('year')
                ->toArray();

            foreach ($years as $yearValue) {
                for ($month = 1; $month <= 12; $month++) {
                    $months[] = [
                        'start' => Carbon::create($yearValue, $month, 1)->startOfMonth(),
                        'end' => Carbon::create($yearValue, $month, 1)->endOfMonth(),
                        'name' => Carbon::create($yearValue, $month, 1)->format('Y-m')
                    ];
                }
            }
        } else {
            // Yıl verilmediyse, SADECE geçerli ayı işle
            $months[] = [
                'start' => now()->startOfMonth(),
                'end' => now()->endOfMonth(),
                'name' => now()->format('Y-m')
            ];
        }

        // Her ay için XML oluştur
        $totalFiles = 0;

        foreach ($months as $month) {
            $posts = Article::where('created_at', '<=', now())
                ->where('title', '!=', '')
                ->whereBetween('created_at', [$month['start'], $month['end']])
                ->where('deleted_at', NULL)

                ->with(['author:id,name']) // Eğer kategori ilişkisi varsa
                ->select(['id', 'title', 'slug', 'created_at', 'author_id']) // Dizi şeklinde yazılmalı
                ->orderBy('id', 'desc');

            $chunkIndex = 1;

            $posts->chunk(1000, function ($countPosts) use (&$chunkIndex, $month, &$totalFiles, ) {
                if (blank($countPosts)) {
                    return;
                }

                $xmlDeclaration = '<?xml version="1.0" encoding="UTF-8"?>';
                $xmlStylesheet = '';

                $content = $this->generateSitemapXmlForArticles($countPosts, $xmlDeclaration, $xmlStylesheet, "article");

                // XML dosyasını kaydet
                $fileIndex = $chunkIndex > 1 ? '-' . $chunkIndex : '';
                $filename = 'sitemap-article-' . $month['name'] . $fileIndex . '.xml';
                $path = public_path('sitemaps/' . $filename);

                if (!file_exists(dirname($path))) {
                    mkdir(dirname($path), 0755, true);
                }

                file_put_contents($path, $content);

                $latestCreatedAt = $countPosts->max('created_at');
                if ($latestCreatedAt) {
                    $timestamp = Carbon::parse($latestCreatedAt)->timestamp;
                    if (file_exists($path) && is_writable($path)) {
                        touch($path, $timestamp);
                    } elseif (is_writable(dirname($path))) {
                        // Dosya yoksa ve dizin yazılabilirse oluştur
                        touch($path, $timestamp);
                    } else {
                        Log::warning("Cannot touch file due to permissions: " . $path);
                        return false;
                    }
                }


                $chunkIndex++;
                $totalFiles++;

                $this->info("Dosya oluşturuldu: {$filename}");
            });
        }

        // Sonuç mesajları
        if ($year === 'all') {
            $message = "Tüm yılların sitemap'leri oluşturuldu! Toplam {$totalFiles} dosya oluşturuldu. 1";
        } elseif ($year !== null) {
            $message = "{$year} yılına ait tüm ayların sitemap'leri oluşturuldu! Toplam {$totalFiles} dosya oluşturuldu. 2";
        } else {
            $message = "Geçerli ayın sitemap'i oluşturuldu! Toplam {$totalFiles} dosya oluşturuldu. 3";
        }


        return $message;
    }

    private function generateSitemapXmlForArticles($articles, $xmlDeclaration, $xmlStylesheet, $type)
    {
        $xml = $xmlDeclaration . "\n" . $xmlStylesheet . "\n\n";

        if ($type == "news") {
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" ';
            $xml .= 'xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">' . "\n";
        } else {
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        }

        foreach ($articles as $article) {
            // Article için route: /makale/{slug}/{id}
            $routeUrl = route('article', [
                'slug' => $article->slug,
                'id' => $article->id
            ]);

              // article sitemap
              $xml .= "  <url>\n";
              $xml .= "    <loc>{$routeUrl}</loc>\n";
              $xml .= "    <lastmod>" . Carbon::parse($article->created_at)->toIso8601String() . "</lastmod>\n";
              $xml .= "  </url>\n";
        }

        $xml .= "</urlset>";
        return $xml;
    }
    private function categorySitemapGenerate()
    {


        $categories = Category::all();

        $xmlDeclaration = '<?xml version="1.0" encoding="UTF-8"?>';
        $xmlStylesheet = '';

        // Kategorileri view'a gönderiyoruz
        $content = $this->generateSitemapXmlForCategories($categories, $xmlDeclaration, $xmlStylesheet, "category");




        // XML dosyasını kaydet
        $path = public_path('sitemaps/sitemap-category.xml');
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        file_put_contents($path, $content);

        $latestCreatedAt = $categories->max('created_at');
        if ($latestCreatedAt) {
            $timestamp = Carbon::parse($latestCreatedAt)->timestamp;
            if (file_exists($path) && is_writable($path)) {
                touch($path, $timestamp);
            } elseif (is_writable(dirname($path))) {
                // Dosya yoksa ve dizin yazılabilirse oluştur
                touch($path, $timestamp);
            } else {
                Log::warning("Cannot touch file due to permissions: " . $path);
                return false;
            }
        }

        return 'Kategori sitemap dosyası oluşturuldu!';
    }



    private function generateSitemapXmlForCategories($categories, $xmlDeclaration, $xmlStylesheet, $type)
    {
        $xml = $xmlDeclaration . "\n" . $xmlStylesheet . "\n\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($categories as $category) {
            // slug boşsa kategori atla
            if (empty($category->slug)) {
                continue;
            }

            $routeUrl = route('category', ['slug' => $category->slug]);

            $xml .= "  <url>\n";
            $xml .= "    <loc>{$routeUrl}</loc>\n";
            $xml .= "    <lastmod>" . Carbon::parse($category->updated_at ?? now())->toIso8601String() . "</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.6</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= "</urlset>";

        return $xml;
    }

}
