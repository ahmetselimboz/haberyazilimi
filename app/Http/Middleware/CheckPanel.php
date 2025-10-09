<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckPanel
{
    public function handle(Request $request, Closure $next)
    {

        if (env('APP_ENV') === 'local') {
            return $next($request);
        }
        
        $path = $request->path();
        
         if (!str_starts_with($path, 'secure')) {
              return $next($request);
         }
       
        Log::info('CheckPanel middleware tetiklendi');

        $host = $request->getHost(); // örn: www.haberrize.com.tr
        $parts = explode('.', $host);
        
        // Eğer son parça "tr" ve ondan önceki "com/net/org" gibi bir şeyse, son 3 parçayı al
        if (count($parts) >= 3 && in_array($parts[count($parts) - 2], ['com', 'net', 'org']) && $parts[count($parts) - 1] === 'tr') {
            $domain = implode('.', array_slice($parts, -3)); // haberrize.com.tr
        } else {
            $domain = implode('.', array_slice($parts, -2)); // example.com
        }

        // API URL’si
        $url = "https://plugin.medyayazilimlari.com/get-panel-info/{$domain}";

        try {
            // or development mode
           
            $response = Http::get($url);
            if ($response->successful() ) {
                $data = $response->json();
                 
                if (isset($data['status']) && $data['status'] === true) {
                    return $next($request); // Devam et
                }
                else{
                 
                    return redirect()->route('panel.disabled');
                }
            }
         
        } catch (\Exception $e) {
            Log::error($e); // Hataları istersen logla  
            
        }

        // Durum false ise yönlendir
        return $next($request); // Devam et
    }
}
