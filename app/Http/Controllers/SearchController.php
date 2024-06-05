<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdvancedSearchRequest;
use App\Models\Publication;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(): View
    {
        return view('front.advanced-search');
    }

    public function advanced_search(AdvancedSearchRequest $request): View
    {
        $query = Publication::query();

        foreach ($request->type as $key => $type) {
            $lookfor = $request->lookfor[$key];
            if (!empty($lookfor)) {
                $this->applyFilter($query, $type, $lookfor);
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

        // Pass the search parameters to the view
        return view('front.results', [
            'results' => $results,
            'searchParameters' => $request->all()
        ]);
    }



    private function applyFilter($query, $type, $lookfor)
    {
        switch ($type) {
            case 'title':
                $query->where('title', 'like', "%$lookfor%");
                break;
            case 'author':
                $query->whereHas('authors', function ($query) use ($lookfor) {
                    $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%$lookfor%");
                });
                break;
            case 'abstract':
                $query->where('abstract', 'like', "%$lookfor%");
                break;
            case 'keyword':
                $query->whereHas('keywords', function ($query) use ($lookfor) {
                    $query->where('keyword', 'like', "%$lookfor%");
                });
                break;
            case 'publisher':
                $query->whereHas('publisher', function ($query) use ($lookfor) {
                    $query->where('name', 'like', "%$lookfor%");
                });
                break;
            case 'entire_document':
                $query->where(function ($subQuery) use ($lookfor) {
                    $subQuery->where('title', 'like', "%$lookfor%")
                        ->orWhere('abstract', 'like', "%$lookfor%")
                        ->orWhereHas('authors', function ($query) use ($lookfor) {
                            $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%$lookfor%");
                        })
                        ->orWhereHas('keywords', function ($query) use ($lookfor) {
                            $query->where('keyword', 'like', "%$lookfor%");
                        })
                        ->orWhereHas('publisher', function ($query) use ($lookfor) {
                            $query->where('name', 'like', "%$lookfor%");
                        });
                });
                break;
        }
    }


    public function search(Request $request): View
    {
        $query = Publication::query();

        $searchTerm = $request->search;
        $this->applySearchFilters($query, $searchTerm);

        $results = $query->get();

        $searchParameters = [
            'type' => ['entire_document'],
            'lookfor' => [$searchTerm]
        ];


        return view('front.results', [
            'results' => $results,
            'searchParameters' => $searchParameters
        ]);

    }

    private function applySearchFilters($query, $searchTerm)
    {
        $query->where('title', 'like', "%$searchTerm%")
            ->orWhere('abstract', 'like', "%$searchTerm%")
            ->orWhereHas('authors', function ($query) use ($searchTerm) {
                $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%$searchTerm%");
            })
            ->orWhereHas('keywords', function ($query) use ($searchTerm) {
                $query->where('keyword', 'like', "%$searchTerm%");
            })
            ->orWhereHas('publisher', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%");
            });
    }
}
