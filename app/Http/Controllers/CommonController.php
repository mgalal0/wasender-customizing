<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class CommonController extends Controller
{
    public function switchLang($locale)
    {
        Session::put('locale', $locale);

        return redirect()->back();
    }
}
