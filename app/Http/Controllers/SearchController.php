<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdvancedSearchRequest;
use App\Models\Publication;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index()
    {
        return view('front.advanced-search');
    }

    public function search(AdvancedSearchRequest $request)
    {

        $query = Publication::query();

        foreach ($request->type as $key => $type) {
            $lookfor = $request->lookfor[$key];

            if (!empty($lookfor)) {
                switch ($type) {
                    case 'title':
                        $query->orWhere('title', 'like', "%$lookfor%");
                        break;
                    case 'author':
                        $query->orWhereHas('authors', function ($query) use ($lookfor) {
                            $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%$lookfor%");
                        });
                        break;
                    case 'abstract':
                        $query->orWhere('abstract', 'like', "%$lookfor%");
                        break;
                        case 'keyword':
                        $query->orWhereHas('keywords', function ($query) use ($lookfor) {
                            $query->where('keyword', 'like', "%$lookfor%");
                        });
                        case 'publisher':
                        $query->orWhereHas('publisher', function ($query) use ($lookfor) {
                            $query->where('name', 'like', "%$lookfor%");
                        });
                    case 'entire_document':
                        // Handle 'entire_document' if needed
                        break;
                    // Handle other types if needed
                }
            }
        }


        if ($request->filled('fromMonthYear')) {
            $fromDate = Carbon::parse($request->fromMonthYear)->startOfMonth();
            $query->where('publication_date', '>=', $fromDate);
        }

        if ($request->filled('untilMonthYear')) {
            $untilDate = Carbon::parse($request->untilMonthYear)->endOfMonth();
            $query->where('publication_date', '<=', $untilDate);
        }


        $results = $query->get();


        foreach ($results as $result) {
            echo $result->title . '<br>';
        }
exit;
        return view('search-results', compact('results'));
    }


}
