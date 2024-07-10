<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrowseController extends Controller
{
    public function index()
    {
        return view('front.browse.index');
    }
}
