<?php

namespace App\Http\Controllers;

use Detection\MobileDetect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    private static $cacheDir;
    private static $mobileDetect;
    private static $imageManager;
    private static $placeholderSettings = null;
    private static $fileCache = [];

public function resizeImage(Request $request)
    {

        $this->initializeStatics();

        $imageUrl = $request->input('i_url');
        $baseWidth = (int) $request->input('w', 100);
        $baseHeight = (int) $request->input('h', 100);
        if (!preg_match('/^https?:\/\//', $imageUrl)) {
            // Başa / ekliyse kaldır (public_path ile birleşecek)
            $cleanPath = ltrim($imageUrl, '/');
        
            // Tam dosya yolunu oluştur
            $imageUrl = public_path($cleanPath);
        }        // Fast device detection with memory cache
        $deviceType = $this->getCachedDeviceType($request);
        list($targetWidth, $targetHeight) = $this->calculateDimensions($baseWidth, $baseHeight, $deviceType);

        // Optimized cache key and path
        $cacheKey = hash('xxh3', $imageUrl . $targetWidth . $targetHeight . $deviceType);
        $cachePath = self::$cacheDir . '/' . $cacheKey . '.jpg';

        // Super fast file existence check with memory cache
        if ($this->isCachedFileValid($cachePath)) {
            return $this->sendCachedFile($cachePath, $cacheKey);
        }

        try {
            // Optimized image processing
            $image = self::$imageManager->make($imageUrl);
            
            // Fast resize with specific algorithm
            $image->fit($targetWidth, $targetHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            }, 'center');
            
            // Optimized quality based on size and device
            $quality = $this->getOptimalQuality($targetWidth, $targetHeight, $deviceType);
            
            // Save with optimal settings
            $image->save($cachePath, $quality, 'jpg');
            $image->destroy(); // Free memory immediately

            // Cache the file info
            self::$fileCache[$cachePath] = filemtime($cachePath);

            return $this->sendCachedFile($cachePath, $cacheKey);
            
        } catch (\Exception $e) {
            Log::error('Image resize error: ' . $e->getMessage());
            return $this->getPlaceholderImage($targetWidth, $targetHeight);
        }
    }

    private function initializeStatics()
    {
        if (!self::$cacheDir) {
            self::$cacheDir = public_path('cache/images');
            if (!is_dir(self::$cacheDir)) {
                mkdir(self::$cacheDir, 0755, true);
            }
        }

        if (!self::$mobileDetect) {
            self::$mobileDetect = new MobileDetect();
        }

        if (!self::$imageManager) {
            self::$imageManager = new ImageManager(['driver' => 'gd']);
        }
    }

    private function getCachedDeviceType(Request $request)
    {
        static $deviceCache = [];
        
        $userAgent = $request->header('User-Agent', '');
        $agentHash = hash('xxh3', $userAgent);
        
        if (!isset($deviceCache[$agentHash])) {
            self::$mobileDetect->setUserAgent($userAgent);
            
            if (self::$mobileDetect->isMobile() && !self::$mobileDetect->isTablet()) {
                $deviceCache[$agentHash] = 'mobile';
            } elseif (self::$mobileDetect->isTablet()) {
                $deviceCache[$agentHash] = 'tablet';
            } else {
                $deviceCache[$agentHash] = 'desktop';
            }
            
            // Limit cache size
            if (count($deviceCache) > 100) {
                $deviceCache = array_slice($deviceCache, -50, null, true);
            }
        }
        
        return $deviceCache[$agentHash];
    }

    private function isCachedFileValid($cachePath)
    {
        // Check memory cache first
        if (isset(self::$fileCache[$cachePath])) {
            return true;
        }

        // Fast file check
        if (is_file($cachePath) && filesize($cachePath) > 100) {
            self::$fileCache[$cachePath] = filemtime($cachePath);
            return true;
        }

        return false;
    }

    private function sendCachedFile($cachePath, $cacheKey)
    {
        $lastModified = self::$fileCache[$cachePath] ?? filemtime($cachePath);
        
        return response()->file($cachePath, [
            'Cache-Control' => 'public, max-age=31536000, immutable', // 1 year cache
            'Expires' => gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT',
            'Last-Modified' => gmdate('D, d M Y H:i:s', $lastModified) . ' GMT',
            'ETag' => '"' . $cacheKey . '"',
            'Vary' => 'Accept-Encoding'
        ]);
    }

    private function getOptimalQuality($width, $height, $deviceType)
    {
        $pixelCount = $width * $height;
        
        if ($deviceType === 'mobile') {
            return $pixelCount > 50000 ? 80 : 85;
        } elseif ($pixelCount > 100000) {
            return 85;
        } else {
            return 90;
        }
    }

    private function calculateDimensions($baseWidth, $baseHeight, $deviceType)
    {
        // Precomputed multipliers for speed
        static $multipliers = [
            'mobile' => 3.5,
            'tablet' => 2.25,
            'desktop' => 1.0
        ];
        
        $multiplier = $multipliers[$deviceType] ?? 1.0;
        return [(int)($baseWidth * $multiplier), (int)($baseHeight * $multiplier)];
    }

    private function getPlaceholderImage($width, $height)
    {
        // Initialize settings cache once
        if (self::$placeholderSettings === null) {
            try {
                if (Storage::disk('public')->exists('settings.json')) {
                    $settings = json_decode(Storage::disk('public')->get("settings.json"), true);
                    self::$placeholderSettings = isset($settings['defaultimage']) ? 
                        public_path('uploads/' . $settings['defaultimage']) : false;
                } else {
                    self::$placeholderSettings = false;
                }
            } catch (\Exception $e) {
                self::$placeholderSettings = false;
            }
        }

        if (self::$placeholderSettings && is_file(self::$placeholderSettings)) {
            $image = self::$imageManager->make(self::$placeholderSettings);
            $image->fit($width, $height);
            $response = $image->response('jpg', 75);
            $image->destroy();
            return $response;
        }

        // Minimal fallback placeholder
        $img = self::$imageManager->canvas($width, $height, '#f5f5f5');
        $response = $img->response('jpg', 70);
        $img->destroy();
        return $response;
    }
}
