<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $locale = Session::get('locale', config('app.locale', 'ar'));
            
            if (in_array($locale, ['ar', 'en'])) {
                App::setLocale($locale);
            } else {
                App::setLocale('ar');
            }
        } catch (\Exception $e) {
            App::setLocale('ar');
        }
        
        return $next($request);
    }
}

