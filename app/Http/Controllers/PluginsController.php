<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PluginsController extends Controller
{
    public function marketRequest(){
        
        $response = Http::get('https://plugin.medyayazilimlari.com/get-plugins');
 
         if ($response->json() !== null) {
             $plugins = $response->json();
     
             Storage::disk('public')->put('plugins_market.json', json_encode($plugins, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
     
             return response()->json([
                 'message' => 'Plugin verileri başarıyla kaydedildi.',
                 // 'count' => $plugins->count()
             ]);
         }
     
         return response()->json([
             'message' => 'API isteği başarısız.',
             'status' => $response->status()
         ], 500);
     }
     
     
     
     public function index(){
         
         $plugins = [];
         Storage::disk('public')->put('installed_plugins.json', json_encode($plugins, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
       
         
         // if($response->getStatusCode() == 500){
         //     toastr()->error('Bir hata meydana geldi.','BAŞARISIZ', ['timeOut' => 5000]);
         //     return redirect()->route('secure.index');
         // }
         
         return view("backend.plugins.index");
     }
     
    public function market(){
        
         $response = $this->marketRequest();
         
         if($response->getStatusCode() == 500){
             toastr()->error('Bir hata meydana geldi.','BAŞARISIZ', ['timeOut' => 5000]);
             return redirect()->route('secure.index');
         }
        
         return view("backend.plugins.market");
     }
}
