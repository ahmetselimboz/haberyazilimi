<?php

use App\Models\Ads;
use App\Models\User;
use \App\Models\Menus;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

if (!function_exists('hasUser')) {
    function hasUser($id)
    {
        $result = User::select('name')->find($id);

        if ($result == null) {

            $name = 'Detay Kontrol->';
        } else {
            $name = $result->name;
        }
        return $name;
    }
}

if (!function_exists('firstImage')) {
    function firstImage($id)
    {
        $image = \App\Models\ProductImages::select('image')->where(['product_id' => $id])->orderBy('sortby', 'desc')->first();
        if ($image != null) {
            return $image->image;
        } else {
            $di = \App\Models\Settings::select('defaultimage')->first();
            return $di->defaultimage;
        }
        // ilk görsel çekimi yoksa default resim
    }
}

// if (!function_exists('adsCheck')) {
//     function adsCheck($id)
//     {
//         $ads = Ads::where('id', $id)->first();

//         if($ads!=null){
//             if($ads->type==1){ // kod reklamdır
//                 $ads = Ads::where('id', $id)->select('id','code','type','publish')->first();
//             }else{ // resim reklamdır
//                 $ads = Ads::where('id', $id)->select('url','width','height','type','images','publish')->first();
//             }
//             return $ads;
//         }else{
//             return "Reklam Bulunamadı";
//         }
//     }
// }
if (!function_exists('adsCheck')) {
    function adsCheck($id)
    {
        $allAds = Cache::remember('all_ads', 60, function () {
            return Ads::where('publish', false)
                ->select('id', 'url', 'width', 'height', 'type', 'images', 'publish', 'code')
                ->get();
        });


        if (blank($allAds)) {
            return false;
        }

        return $allAds->firstWhere('id', $id) ?? false;
    }
}


if (!function_exists('menuCheck')) { ####### BUNU HAZIRLADIM ANCAK ŞİMDİLİK KULLANMIYORUM HER YERİ JSON YAPTIĞIM İÇİN
    function menuCheck($id)
    {
        $menu = Menus::where('id', $id)->first();
        if ($menu != null) {
            if ($menu->jsonmenu != null) {
                return $menu->jsonmenu;
            } else {
                return $id . " Numaralı Menü Bulunamadı";
            }
        } else {
            return $id . " Numaralı Menü Bulunamadı";
        }
    }
}

if (!function_exists('categoryCheck')) {
    function categoryCheck($id)
    {

        $category = Cache::remember('all_categories', 60, function () {
            return Category::select('id', 'title', 'slug', 'color')
                ->get()
                ->keyBy('id')
                ->toArray();
        });

        return isset($category[$id]) ? (object) $category[$id] : false;
    }
}

if (!function_exists('relatedPostCheck')) {
    function relatedPostCheck($id)
    {
        $releated_post = \App\Models\Post::where('id', $id)->select('id', 'title', 'slug', 'category_id', 'images')->first();
        if ($releated_post != null) {
            return $releated_post;
        } else {
            return false;
        }
    }
}

if (!function_exists('imageCheck')) {
    function imageCheck($imagefile)
    {
        // $domain = $_SERVER['SERVER_NAME']; // blabla.com
        // // sunucuda sıkıntı olması durumunda 93. satır silinebilir
        // array_key_exists('HTTPS', $_SERVER) ? $_SERVER['HTTPS'] : $_SERVER['HTTPS'] = "";

        // if ($_SERVER['HTTPS'] == "on") {
        //     $ht = "https://";
        // } else {
        //     $ht = "http://";
        // }


        $settings = json_decode(Storage::disk('public')->get("settings.json"), TRUE);


        $defaultimage = asset('uploads/' . $settings['defaultimage']);

        if (blank($defaultimage)) {
            $defaultimage = asset('frontend/assets/defaultimagestatic.jpeg');
            // $defaultimage = $ht . $domain . '/frontend/assets/defaultimagestatic.jpeg';
        }

        $fullPath = public_path('uploads/' . $imagefile);

        return !blank($imagefile) && file_exists($fullPath) ? asset('uploads/' . $imagefile) : $defaultimage;
    }
}

if (!function_exists('imageSave')) {
    function imageSave($imagefile)
    {

        //..................

        if (is_file('../uploads/' . $imagefile)) {
            return asset('/uploads/' . $imagefile);
        } else {
            return $imagefile;
        }
    }
}

if (!function_exists('updateAuthor')) {
    function updateAuthor()
    {

        // $article = User::where('status', 3)
        // ->whereHas('latestArticle', function ($query) {
        //     $query->where('publish', 0);
        // })
        // ->with(['latestArticle' => function ($query) {
        //     $query->where('publish', 0)
        //           ->select('article.id', 'article.title', 'article.slug', 'article.detail', 'article.created_at', 'article.author_id');
        // }])

        // ->select('users.id', 'users.name', 'users.avatar', 'latest_articles.latest_date')
        // ->orderByDesc('latest_articles.latest_date')
        // ->get() ?? [];

        $article = User::select('id', 'name', 'status', 'avatar', 'created_at')
            ->whereHas('latestArticle', function ($query) {
                $query->where('publish', 0);
            })
            ->with([
                'latestArticle' => function ($query) {
                    $query->select('article.id', 'article.author_id', 'title', 'slug', 'images', 'created_at')
                        ->where('publish', 0);
                }
            ])
            ->joinSub(
                DB::table('article')
                    ->select('author_id', DB::raw('MAX(created_at) as latest_article_created_at'))
                    ->where('publish', 0)
                    ->where('created_at', '<=', now())
                    ->groupBy('author_id'),
                'latest_articles',
                'users.id',
                '=',
                'latest_articles.author_id'
            )
            ->orderByDesc('latest_articles.latest_article_created_at')
            ->get();

        Storage::disk('public')->put('main/authors.json', $article);
    }
}


if (!function_exists('generateOgImage')) {

    function generateOgImage(string $imageUrl): ?string
    {
        // Site base URL'sini al
        $baseUrl = config('app.url'); // .env APP_URL
        $baseUrl = rtrim($baseUrl, '/');

        // public yolunu oluştur
        $relativeUrl = parse_url($imageUrl, PHP_URL_PATH); // sadece path kısmını alır
        $relativePath = ltrim($relativeUrl, '/'); // baştaki / işaretini kaldır
        $originalPath = public_path($relativePath);

        // Yeni dosya ismini belirle
        $filename = 'og_' . basename($relativePath);
        $outputRelative = 'uploads/og_images/' . $filename;
        $outputPath = public_path($outputRelative);

        // Daha önce oluşturulmuşsa yeniden yapma
        if (!file_exists($outputPath)) {

            try {
                $image = Image::make($originalPath)->resize(1200, 630, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $image = Image::canvas(1200, 540, '#ffffff')->insert($image, 'center');

                if (!file_exists(dirname($outputPath))) {
                    mkdir(dirname($outputPath), 0755, true);
                }

                $image->save($outputPath, 85);
            } catch (\Exception $e) {
                \Log::error("OG görseli oluşturulamadı: " . $e->getMessage());
                return null;
            }
        }


        return $baseUrl . '/' . $outputRelative;
    }
}


// if (!function_exists('makeOgImage')) {
//     function makeOgImage($relativePath)
//     {
//         // Default image
//         $getDefaultImage = function() {
//             $settings = json_decode(Storage::disk('public')->get("settings.json"), TRUE);
//             return asset('uploads/' . $settings['defaultimage']);
//         };

//         try {
//             if (empty($relativePath)) return $getDefaultImage();

//             $originalPath = public_path('uploads/' . $relativePath);
//             if (!file_exists($originalPath) || !@getimagesize($originalPath)) {
//                 return $getDefaultImage();
//             }

//             $hash = md5($relativePath . filemtime($originalPath));
//             $ogPath = public_path("uploads/facebook_og/{$hash}.jpg");
//             $ogUrl = asset("uploads/facebook_og/{$hash}.jpg");

//             // Cache kontrol
//             if (file_exists($ogPath) && filesize($ogPath) > 1024) {
//                 return $ogUrl;
//             }

//             // Klasör oluştur
//             if (!file_exists(public_path('uploads/facebook_og'))) {
//                 mkdir(public_path('uploads/facebook_og'), 0755, true);
//             }

//             // Görsel işleme
//             $img = Image::make($originalPath)->resize(1200, 630, function ($c) {
//                 $c->aspectRatio();
//                 $c->upsize();
//             });

//             $canvas = Image::canvas(1200, 630, '#ffffff');
//             $canvas->insert($img, 'center');
//             $canvas->save($ogPath, 90, 'jpg');

//             return file_exists($ogPath) ? $ogUrl : $getDefaultImage();

//         } catch (\Exception $e) {
//             return $getDefaultImage();
//         }
//     }
// }

if (!function_exists('makeOgImage')) {
    function makeOgImage($relativePath)
    {

        $settings = json_decode(Storage::disk('public')->get("settings.json"), TRUE);
        $defaultimage = asset('uploads/' . $settings['defaultimage']);


        $originalPath = public_path('uploads/' . $relativePath);
        if (!file_exists($originalPath)) {
            return asset($defaultimage);
        }

        $hash = md5($relativePath);
        $ogPath = public_path("uploads/facebook_og/{$hash}.jpg");
        $ogUrl  = asset("uploads/facebook_og/{$hash}.jpg");

        if (!file_exists($ogPath)) {
            // Orijinal resmi oku
            $img = Image::make($originalPath)->resize(900, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });

            // 1200x628 canvas oluştur, ortaya yerleştir
            $canvas = Image::canvas(1200, 500, '#ffffff');
            $canvas->insert($img, 'center');

            // Klasör varsa oluştur
            if (!file_exists(public_path('uploads/facebook_og'))) {
                mkdir(public_path('uploads/facebook_og'), 0755, true);
            }

            $canvas->save($ogPath, 90, 'jpg');
        }

        return $ogUrl;
    }
}
    /*
    *
    * Prepare a Slug for a given string
    * Laravel default str_slug does not work for Unicode
    *
    * ------------------------------------------------------------------------
    */
    if (!function_exists('slug_format')) {

        /**
         * Format a string to Slug.
         */
        function slug_format($string, $sparator = '-')
        {
            $string = preg_replace('/\s+/u', $sparator, trim($string));
            $string = str_replace('/', $sparator, $string);
            $string = str_replace('\\', $sparator, $string);
            $turkish = ['ş', 'Ş', 'ı', 'I', 'İ', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö', 'ç', 'Ç'];
            $english = ['s', 'S', 'i', 'I', 'I', 'g', 'G', 'u', 'U', 'o', 'O', 'c', 'C'];
            $string = str_replace($turkish, $english, $string);

            return Str::slug($string, $sparator);
        }
    }

