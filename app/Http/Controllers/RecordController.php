<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class RecordController extends Controller
{
    public function viewResult($slug)
    {
        // Fetch the individual result by its slug along with custom fields
        $result = Publication::with(['customFields.definition', 'authors', 'types', 'publisher', 'keywords', 'categories'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('front.record', compact('result'));
    }

}
