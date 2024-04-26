<?php

namespace App\Http\Controllers;

use illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    function index()
    {
        if (Auth::check()) {
            return redirect('home');
        } else {
            return view('welcome');
        }
    }
}
