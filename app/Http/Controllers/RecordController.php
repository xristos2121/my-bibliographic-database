<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class RecordController extends Controller
{
    public function viewResult($slug)
    {
        $result = Publication::with(['customFields.definition', 'authors', 'types', 'publisher', 'keywords', 'collections'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('front.record', compact('result'));
    }

}
