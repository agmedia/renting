<?php

namespace App\Http\Middleware;

use App\Helpers\LanguageHelper;
use Closure;
use Illuminate\Support\Facades\Log;

class CheckLocaleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::info('public function handle($request, Closure $next)');
        Log::info(session('locale'));

        $locale = session('locale', false);

        if (empty($locale)) {
            Log::info('else');
            $main = LanguageHelper::getMain();
            $locale = $main->code;

            session(['locale' => $locale]);
            Log::info('else-over');
        }

        app()->setLocale($locale);

        Log::info(app()->getLocale());

        return $next($request);
    }
}
