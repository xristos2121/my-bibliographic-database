<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function index()
    {
        return view('front.advanced-search');
    }

    public function search(Request $request)
    {
        $query = Publication::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('abstract')) {
            $query->where('abstract', 'like', '%' . $request->abstract . '%');
        }

        if ($request->filled('publication_date')) {
            $query->whereDate('publication_date', '=', Carbon::parse($request->publication_date));
        }

        if ($request->filled('keyword_id')) {
            $query->whereHas('keywords', function ($q) use ($request) {
                $q->where('keywords.id', $request->keyword_id);
            });
        }

        if ($request->has('author_ids')) {
            $query->whereHas('authors', function ($q) use ($request) {
                $q->whereIn('authors.id', $request->author_ids);
            });
        }

        if ($request->has('category_ids')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('categories.id', $request->category_ids);
            });
        }

        $results = $query->get();

        return view('search-results', compact('results')); // Ensure you have a 'search-results.blade.php' to display the results
    }
}
