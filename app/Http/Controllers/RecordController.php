<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class RecordController extends Controller
{
    public function viewResult($slug)
    {
        // Fetch the individual result by its slug
        $result = Publication::where('slug', $slug)->firstOrFail();
        return view('front.record', compact('result'));
    }
}
