<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Message;
use App\Models\Category;
use App\Models\Settings;
use App\Models\Sortable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\Console\Output\BufferedOutput;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class SecureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $count_post = DB::table('post')->count();
        $todayNewsCount = Post::whereDate('created_at', today())->count();
        $count_photo_gallery = DB::table('photogallery')->count();
        $count_video_gallery = DB::table('video')->count();
        $count_user = DB::table('users')->count();
        $seocheck = DB::table('seocheck')->count();

        $activitylogs = Activity::orderBy('id', 'desc')->with('causer:id,name')->limit(10)->get();

        $settings = Settings::first();
        $jsondata = json_decode($settings->magicbox);
        $posts = Post::select('id', 'title', 'category_id', 'meta_title', 'meta_description', 'hit', 'publish', 'created_at','extra')
            ->with('category')->orderBy('id', 'desc')->whereDate('created_at', today())->paginate(10);
        ## ÖNCEKİ KATEGORİ CHART YAPISI BÜYÜK HABER RAKAMLARINDA KASIYOR FARKLI BİR YAPI KURMAK İÇİN KAPATIYORUM
        ## $category = Category::where('category_type', 0)->select('id','title')->get();
        ## foreach ($category as $value){ $serie[] = "'".(count(Post::where('category_id', $value->id)->get()))."'"; $label[] = "'".$value->title."'"; }
        ## $labels = implode(",",$label);
        ## $series = implode(",",$serie);

        $category = Category::where('category_type', 0)->select('id', 'title', 'countnews')->get();
        foreach ($category as $value) {
            $serie[] = "'" . $value->countnews . "'";
            $label[] = "'" . $value->title . "'";
        }
        if (isset($label)) {
            $labels = implode(",", $label);
            $series = implode(",", $serie);
        } else {
            $labels = "no";
            $series = "no";
        }


        $notifications = $this->notificationRequest($request);
        $information = $this->informationRequest($request);

        $trends = [];


        // $seocheck = DB::table('seocheck')->count();

        return view('backend.index', compact('category', 'posts', 'count_post', 'count_user', 'count_video_gallery','todayNewsCount',
         'count_photo_gallery', 'activitylogs', 'labels', 'series', 'settings', 'jsondata', 'seocheck', "trends"));
    }

    public function optimize()
    {
        if (!Auth::check() || Auth::user()->status != 1) {
            return back();
             
        }
        Artisan::call('down');
        Artisan::call('optimize:clear');
        cache()->forget('posts');
        cache()->forget('count_data');
        cache()->forget('post_position_json');
        cache()->forget('all_ads');
        cache()->forget('all_categories');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        Artisan::call('up');



        // saat 22:00 dan sabah 09:00 arası çalışsın
        $now = now()->format('H:i');
        if ($now >= '22:00' || $now < '09:00') {
            Artisan::call('cache:clear-images');
        }
        toastr()->success('OPTİMİZE İŞLEMİ TAMAMLANDI', 'BAŞARILI', ['timeOut' => 5000]);

        return back();
    }

    public function jsonsystemcreate()
    {
        $sortable = Sortable::select('id', 'type', 'title', 'category', 'ads', 'menu', 'limit', 'file', 'design', 'color', 'sortby')
        ->orderBy('sortby', 'asc')->get();
        Storage::disk('public')->put('main/sortable_list.json', $sortable);
        $hit_news = Post::where('publish', 0)->whereHas('category')
            ->where('created_at', '<=', now())
            ->where('created_at', '>=', now()->subMonth())
            ->select('id', 'title', 'slug', 'category_id', 'images', 'publish', 'created_at','hit', 'extra')
            ->orderBy('hit', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(50)->latest()->get();

        Storage::disk('public')->put('main/hit_news.json', $hit_news);

        // Artisan::call('optimize:clear');
        toastr()->success('ANASAYFA YAPILANDIRMA TAMAMLANDI', 'BAŞARILI', ['timeOut' => 5000]);

        return back();
    }

    public function activitylogs()
    {
        $activitylogs = Activity::orderBy('id', 'desc')->simplePaginate(30);

        return view('backend.activitylogs', compact('activitylogs'));
    }

    public function message()
    {
        $messages = Message::orderBy('id', 'desc')->simplePaginate(30);

        return view('backend.message', compact('messages'));
    }

    public function seocheck(Request $request, $type)
    {
        if ($type == 1) {
            $query = "meta_title";
            $count_text = 58;
        } elseif ($type == 2) {
            $query = "meta_description";
            $count_text = 150;
        } elseif ($type == 3) {
            $query = "keywords";
            $count_text = 20;
        }

        foreach (Post::select("$query","id")->where('publish',0)->limit(1000)->get() as $meta){
            if($meta->$query==null or strlen($meta->$query)<$count_text){
                if(count(DB::table('seocheck')->where('post_id', $meta->id)->get())==0){
                    DB::table('seocheck')->insert([ 'post_id' => $meta->id ]);
                }
            }else{
                DB::table('seocheck')->where([ 'post_id' => $meta->id ])->delete();
            }
        }

        $seochecks =  DB::table('seocheck')->join("post","seocheck.post_id","post.id")->get();

        // tüm seodaki tablodakileri silip kontrolü manuelde sagla
        return view('backend.seocheck', compact('seochecks', 'type'));
    }


    public function migrate()
    {
        $message = "";
        if(Auth::check() && Auth::user()->status == 1){
            if (App::isProduction()) {
                abort(404);
            }
            $output = new BufferedOutput();
            try {
                Artisan::call('migrate', [], $output);
                $result = $output->fetch();
                $status = 'success';
                $message = 'Migration işlemi başarıyla tamamlandı.';
            } catch (\Exception $e) {
                $result = $output->fetch();
                $status = 'error';
                $message = 'Hata oluştu: ' . $e->getMessage();
            }

            return $result. PHP_EOL . $message;
        }
        // toastr()->success($message, 'BAŞARILI', ['timeOut' => 5000]);
        // return redirect()->back();
    }

    public function notificationRequest(Request $request)
    {
        try {
            $host = $request->getHost(); // örn: www.haberrize.com.tr
            $parts = explode('.', $host);
            
            // Eğer son parça "tr" ve ondan önceki "com/net/org" gibi bir şeyse, son 3 parçayı al
            if (count($parts) >= 3 && in_array($parts[count($parts) - 2], ['com', 'net', 'org']) && $parts[count($parts) - 1] === 'tr') {
                $domain = implode('.', array_slice($parts, -3)); // haberrize.com.tr
            } else {
                $domain = implode('.', array_slice($parts, -2)); // example.com
            }
        
            $response = Http::timeout(10)->get('https://plugin.medyayazilimlari.com/get-notifications/' . $domain);
            
            if (!$response->successful()) {
                Log::warning('Notification API request failed', [
                    'domain' => $domain,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return null;
            }
            
            $data = $response->json();
        
            if (is_array($data) && !empty($data)) {
                // JSON dosyasını düzgün bir şekilde yaz
                Storage::disk('public')->put('notifications.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
                return response()->json([
                    'message' => 'Bildirim verileri başarıyla kaydedildi.',
                    'count' => count($data),
                ]);
            }
        
       
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('Notification request failed with exception', [
                'domain' => $domain ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return null;
        }
    }

    public function informationRequest(Request $request)
    {
        $response = Http::get('https://plugin.medyayazilimlari.com/get-information');
        $data = $response->json();
    
        if (is_array($data) && !empty($data)) {
            // JSON dosyasını düzgün bir şekilde yaz
            Storage::disk('public')->put('information.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
            return response()->json([
                'message' => 'Bilgilendirme verileri başarıyla kaydedildi.',
                'count' => count($data),
            ]);
        }
    
        return response()->json([
            'message' => 'API isteği başarısız veya boş veri döndü.',
            'status' => $response->status(),
          
        ], 500);
    }

    public function logs()
    {
        // Sadece ID'si 1 olan kullanıcı erişebilsin
        if (!Auth::check() || Auth::user()->status != 1) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $logDirectory = storage_path('logs');
        $logFiles = glob($logDirectory . '/laravel*.log');
        
        // Dosyaları tarihe göre sırala (en yeni önce)
        usort($logFiles, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        
        $logFileInfo = [];
        foreach ($logFiles as $logFile) {
            if (file_exists($logFile) && is_readable($logFile)) {
                $filename = basename($logFile);
                $fileSize = filesize($logFile);
                $lastModified = filemtime($logFile);
                
                // Dosyadaki log sayısını hızlı hesapla
                $logCount = $this->getLogCount($logFile);
                
                $logFileInfo[] = [
                    'filename' => $filename,
                    'filepath' => $logFile,
                    'size' => $fileSize,
                    'size_human' => $this->formatBytes($fileSize),
                    'last_modified' => $lastModified,
                    'last_modified_human' => date('d.m.Y H:i', $lastModified),
                    'log_count' => $logCount
                ];
            }
        }
        
        return view('backend.logs', compact('logFileInfo'));
    }

    public function logDetail($filename)
    {
        // Sadece ID'si 1 olan kullanıcı erişebilsin
        if (!Auth::check() || Auth::user()->status != 1) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $logDirectory = storage_path('logs');
        $logFile = $logDirectory . '/' . $filename;
        
        // Güvenlik kontrolü - sadece laravel log dosyalarına erişim
        if (!str_starts_with($filename, 'laravel') || !str_ends_with($filename, '.log')) {
            abort(404, 'Log dosyası bulunamadı.');
        }
        
        if (!file_exists($logFile) || !is_readable($logFile)) {
            abort(404, 'Log dosyası bulunamadı veya okunamıyor.');
        }

        $content = $this->getLogFileContent($logFile);
        $logs = [];
        
        if ($content) {
            $logs = $this->parseLogContent($content, $filename);
            
            // Tarihe göre sırala (en yeni önce)
            usort($logs, function($a, $b) {
                return strtotime($b['timestamp']) - strtotime($a['timestamp']);
            });
        }
        
        // Laravel paginate ile pagination yap
        $perPage = 50;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedItems = array_slice($logs, $offset, $perPage);
        
        $paginatedLogs = new LengthAwarePaginator(
            $paginatedItems,
            count($logs),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'page'
            ]
        );
        
        return view('backend.log-detail', compact('paginatedLogs', 'filename'));
    }

    private function getLogFileContent($logFile)
    {
        $fileSize = filesize($logFile);
        
        // Dosya 10MB'den büyükse sadece son 1MB'ı oku
        if ($fileSize > 10 * 1024 * 1024) {
            $handle = fopen($logFile, 'r');
            fseek($handle, $fileSize - (1024 * 1024)); // Son 1MB
            $content = fread($handle, 1024 * 1024);
            fclose($handle);
            
            // İlk satırı kaldır (büyük ihtimalle kesik)
            $lines = explode("\n", $content);
            array_shift($lines);
            return implode("\n", $lines);
        } else {
            return file_get_contents($logFile);
        }
    }

    private function parseLogContent($content, $filename)
    {
        $logs = [];
        $lines = explode("\n", $content);
        $currentLog = '';
        
        foreach ($lines as $line) {
            // Yeni log başlangıcını kontrol et (tarih formatı ile başlıyor)
            if (preg_match('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]/', $line)) {
                if ($currentLog) {
                    $parsedLog = $this->parseLogEntry($currentLog);
                    $parsedLog['filename'] = $filename;
                    $logs[] = $parsedLog;
                }
                $currentLog = $line;
            } else {
                $currentLog .= "\n" . $line;
            }
        }
        
        // Son log'u da ekle
        if ($currentLog) {
            $parsedLog = $this->parseLogEntry($currentLog);
            $parsedLog['filename'] = $filename;
            $logs[] = $parsedLog;
        }
        
        return $logs;
    }



    private function parseLogEntry($logEntry)
    {
        // Log seviyesini ve mesajını ayıkla
        preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] \w+\.(\w+): (.+)/', $logEntry, $matches);
        
        if (count($matches) >= 4) {
            return [
                'timestamp' => $matches[1],
                'level' => strtoupper($matches[2]),
                'message' => $matches[3],
                'full_content' => $logEntry
            ];
        }
        
        return [
            'timestamp' => 'N/A',
            'level' => 'UNKNOWN',
            'message' => $logEntry,
            'full_content' => $logEntry
        ];
    }

    public function disabled(){
        return view('backend.disabled');
    }

    private function getLogCount($logFile)
    {
        $fileSize = filesize($logFile);
        
        // Küçük dosyalar için tam sayım
        if ($fileSize < 1024 * 1024) { // 1MB
            $content = file_get_contents($logFile);
            return substr_count($content, '[20'); // Log başlangıcı [2025-...
        }
        
        // Büyük dosyalar için sampling
        $handle = fopen($logFile, 'r');
        $sampleSize = min(100 * 1024, $fileSize); // 100KB sample
        $sample = fread($handle, $sampleSize);
        fclose($handle);
        
        $sampleCount = substr_count($sample, '[20');
        return round(($sampleCount / $sampleSize) * $fileSize);
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
