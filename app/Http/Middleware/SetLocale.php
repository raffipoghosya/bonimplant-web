<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected array $supported = ['hy', 'ru', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale', 'hy'));

        if (! in_array($locale, $this->supported)) {
            $locale = 'hy';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
