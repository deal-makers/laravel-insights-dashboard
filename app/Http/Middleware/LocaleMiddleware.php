<?php

namespace App\Http\Middleware;

use Closure;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      // available language in template array
      $availLocale=['en'=>'en', 'fr'=>'fr', 'de'=>'de', 'pt'=>'pt', 'es'=>'es', 'cn'=>'cn'];
      
      // Locale is enabled and allowed to be change
      if(session()->has('cur_lang') && array_key_exists(session()->get('cur_lang'),$availLocale)){
        // Set the Laravel locale
        app()->setLocale(session()->get('cur_lang'));
      }
        return $next($request);
    }
}
