<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): \Illuminate\Http\RedirectResponse
    {
        $supported = ['hy', 'ru', 'en'];

        if (in_array($locale, $supported)) {
            session(['locale' => $locale]);
        }

        return redirect()->back()->withHeaders(['Vary' => 'Accept-Language']);
    }
}
