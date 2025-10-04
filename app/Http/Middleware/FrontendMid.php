<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class FrontendMid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $availLocale = ['tr' => 'tr','en' => 'en','chn' => 'chn'];
        if (array_key_exists(session()->get('lang'), $availLocale)) {
            App::setLocale(session()->get('lang'));
        } else {         
            App::setLocale(config('app.locale'));
            session()->put('lang', App::getLocale());
        }


        $settings = json_decode(Storage::disk('public')->get("settings.json"), TRUE);
        $magicbox = json_decode($settings["magicbox"], TRUE);

        $routename = Route::currentRouteName();


        View::share([
            'settings' => $settings,
            'magicbox' => $magicbox,
            'routename' => $routename
        ]);

        return $next($request);
    }
}



















