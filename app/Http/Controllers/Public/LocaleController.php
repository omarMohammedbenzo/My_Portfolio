<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        if (in_array($locale, ['en', 'ar'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }
}
