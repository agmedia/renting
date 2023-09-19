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
        $locale = session('locale', false);

        if (empty($locale)) {
            $main = LanguageHelper::getMain();
            $locale = $main->code;

            session(['locale' => $locale]);
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
