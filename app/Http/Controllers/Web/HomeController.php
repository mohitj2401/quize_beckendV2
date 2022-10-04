<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
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

    public function contact()
    {
        $contact = request()->only(['name', 'email', 'subject', 'message', "number"]);

        Contact::create($contact);
        alert()->success('We will look into in this.');
        return redirect()->back();
    }
}
