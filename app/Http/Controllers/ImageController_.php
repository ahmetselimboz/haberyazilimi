<?php

namespace App\Http\Controllers;

use Detection\MobileDetect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function resizeImage(Request $request)
    {
        // Validate request
        // $validator = Validator::make($request->all(), [
        //     'i_url' => 'required|url',
        //     'w' => 'integer|min:1|max:2000',
        //     'h' => 'integer|min:1|max:2000',
        // ]);

        // if ($validator->fails()) {
        //     return $this->getPlaceholderImage(100, 100);
        // }

        $imageUrl = $request->input('i_url');
        $baseWidth = $request->input('w', 100);
        $baseHeight = $request->input('h', 100);
        $deviceType = $this->detectDeviceType();
        
        list($targetWidth, $targetHeight) = $this->calculateDimensions($baseWidth, $baseHeight, $deviceType);

        $cacheKey = md5($imageUrl . $targetWidth . $targetHeight . $deviceType);
        $cachePath = public_path('cache/images/' . $cacheKey . '.jpg');
        
        // Return cached image if exists
        if (file_exists($cachePath) && filesize($cachePath) > 0) {
            return response()->file($cachePath, [
                'Cache-Control' => 'public, max-age=2592000', // 30 days cache
                'Expires' => gmdate('D, d M Y H:i:s', time() + 2592000) . ' GMT',
            ]);
        }
        // Create cache directory if not exists
        $cacheDir = public_path('cache/images');
        if (!file_exists($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }


        try {

            // $imageContents = $this->fetchImageFromUrl($imageUrl);
            // if (!$imageContents) {
            //     throw new \Exception("Resim alınamadı: $imageUrl");
            // }
            // $image = Image::make($imageContents);
            // $image->fit($targetWidth, $targetHeight);
            // $image->save($cachePath, 80);

            $image = Image::make($imageUrl);
            $image->fit($targetWidth, $targetHeight);
            $image->save($cachePath, 85); // Kalite artırıldı

            return response()->file($cachePath, [
                'Cache-Control' => 'public, max-age=2592000',
                'Expires' => gmdate('D, d M Y H:i:s', time() + 2592000) . ' GMT',
            ]);
            
        } catch (\Exception $e) {
            Log::error('Resim yeniden boyutlandırma hatası: ' . $e->getMessage(), [
                'url' => $imageUrl,
                'target_size' => $targetWidth . 'x' . $targetHeight,
                'device_type' => $deviceType
            ]);

            // dd($imageUrl);

            return $this->getPlaceholderImage($targetWidth, $targetHeight);
        }
    }

    /**
     * Resim URL'den güvenli şekilde yükleme
     */
    private function fetchImageFromUrl($url)
    {
        // URL format kontrolü
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Gerekirse true yapın
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; LaravelBot/1.0)');

        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $error = curl_error($ch);
        
        curl_close($ch);

        // CURL hatası kontrolü
        if ($error) {
            Log::error('CURL Hatası: ' . $error);
            return false;
        }

        // HTTP status kontrolü
        if ($httpCode !== 200) {
            Log::warning('HTTP Hatası: ' . $httpCode . ' for URL: ' . $url);
            return false;
        }

        // Content type kontrolü (PHP 7 uyumlu)
        if (!$contentType || strpos($contentType, 'image/') === false) {
            Log::warning('Geçersiz content type: ' . $contentType . ' for URL: ' . $url);
            // İçerik türü kontrolünü gevşetelim, bazı siteler doğru header göndermeyebilir
            // return false;
        }

        // Data kontrolü
        if (!$data) {
            Log::warning('Boş veri alındı for URL: ' . $url);
            return false;
        }
        
        $dataSize = strlen($data);
        Log::info('Veri boyutu: ' . $dataSize . ' bytes, Content-Type: ' . $contentType);
        
        if ($dataSize < 50) { // Minimum boyutu düşürdük
            Log::warning('Çok küçük veri boyutu: ' . $dataSize . ' bytes');
            return false;
        }

        return $data;
    }

    /**
     * Detect device type
     *
     * @return string
     */
    private function detectDeviceType() {
        $detect = new MobileDetect();

        if ($detect->isMobile() && !$detect->isTablet()) {
            return 'mobile';
        } elseif ($detect->isTablet()) {
            return 'tablet';
        }
        return 'desktop';
    }

    /**
     * Calculate dimensions based on device type
     *
     * @param int $baseWidth
     * @param int $baseHeight
     * @param string $deviceType
     * @return array
     */
    private function calculateDimensions($baseWidth, $baseHeight, $deviceType) {
        switch ($deviceType) {
            case 'mobile':
                return [(int)($baseWidth * 3.5), (int)($baseHeight * 3.5)];
            case 'tablet':
                return [(int)($baseWidth * 2.25), (int)($baseHeight * 2.25)];
            default:
                return [(int)$baseWidth, (int)$baseHeight];
        }
    }


    /**
     * Get placeholder image - İyileştirilmiş
     */
    private function getPlaceholderImage($width, $height) {
        try {
            // Settings dosyasından placeholder resmi al
            if (Storage::disk('public')->exists('settings.json')) {
                $settings = json_decode(Storage::disk('public')->get("settings.json"), true);
                if (isset($settings['defaultimage'])) {
                    $placeholderPath = public_path('uploads/' . $settings['defaultimage']);
                    if (file_exists($placeholderPath)) {
                        $image = Image::make($placeholderPath);
                        $image->fit($width, $height);
                        return $image->response('jpg', 80);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Placeholder resim hatası: ' . $e->getMessage());
        }

        // Fallback: Basit placeholder oluştur
        $img = Image::canvas($width, $height, '#f0f0f0');
        $img->text('No Image', $width/2, $height/2, function($font) use ($width, $height) {
            $font->size(min($width, $height) * 0.1);
            $font->color('#999999');
            $font->align('center');
            $font->valign('center');
        });
        
        return $img->response('jpg', 80);
    }
}
