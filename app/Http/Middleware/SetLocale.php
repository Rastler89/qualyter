<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale', Config::get('app.locale'));
        } else {
            $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

            if ($locale != 'fr' && $locale != 'en' && $locale != 'es' && $locale != 'pt' && $locale != 'it' && $locale != 'de') {
                $locale = 'en';
            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}
