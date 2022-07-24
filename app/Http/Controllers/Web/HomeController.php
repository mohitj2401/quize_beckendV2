<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }
    public function privacy()
    {
        return view('home.privacy-policy');
    }
    public function terms()
    {
        return view('home.terms');
    }
}
