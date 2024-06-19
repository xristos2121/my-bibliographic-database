<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdvancedSearchRequest;
use App\Models\Publication;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(): View
    {
        $types = Type::all();
        return view('front.advanced-search', compact('types'));
    }

    public function advanced_search(AdvancedSearchRequest $request): View
    {
        $query = Publication::query();
        $types = Type::all();

        if($request->type) {
            foreach ($request->type as $key => $type) {
                $lookfor = $request->lookfor[$key];
                if (!empty($lookfor)) {
                    $this->applyFilter($query, $type, $lookfor);
                }
            }
        }

        if ($request->filled('fromYear')) {
            $query->where('publication_date', '>=', $request->fromYear);
        }

        if ($request->filled('untilYear')) {

            $query->where('publication_date', '<=', $request->untilYear);
        }

        if ($request->document_type !== 'all') { // Check if document_type is not 'all'
            $query->where('type_id', $request->document_type);
        }

        $results = $query->get();

        // Pass the search parameters to the view
        return view('front.results', [
            'results' => $results,
            'searchParameters' => $request->all(),
            'types' => $types
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

        $types = Type::all();
        $searchTerm = $request->search;
        $this->applySearchFilters($query, $searchTerm);

        $results = $query->get();

        $searchParameters = [
            'type' => ['entire_document'],
            'lookfor' => [$searchTerm]
        ];


        return view('front.results', [
            'results' => $results,
            'searchParameters' => $searchParameters,
            'types' => $types
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
