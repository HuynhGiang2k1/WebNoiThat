<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('front.pages.home');
    }

    public function intro()
    {
        return view('front.pages.intro');
    }

    public function blog()
    {
        return view('front.pages.blog');
    }

    public function feedback()
    {
        return view('front.pages.feedback');
    }

    public function concept()
    {
        return view('front.pages.concept');
    }

    public function design()
    {
        return view('front.pages.design');
    }
}
