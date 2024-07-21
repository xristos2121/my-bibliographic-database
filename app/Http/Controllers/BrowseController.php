<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Keyword;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Type;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class BrowseController extends Controller
{
    public function index(): View
    {
        $results = Publication::with(['customFields.definition', 'authors', 'types', 'publisher', 'keywords', 'categories'])
            ->orderBy('publication_date', 'desc')
            ->paginate(10);
        $totalResults = Publication::count();
        return view('front.browse.index', compact('results', 'totalResults'));
    }

    public function keywords(): View
    {
        $keywords = Keyword::paginate(20);
        $totalKeywords = $keywords->count();
        return view('front.browse.keywords', compact('keywords', 'totalKeywords'));
    }

    public function publicationsByKeyword($slug): View
    {
        $keyword = Keyword::where('slug', $slug)->firstOrFail();
        $results = Publication::whereHas('keywords', function($query) use ($keyword) {
            $query->where('keywords.id', $keyword->id);
        })
            ->orderBy('publication_date', 'desc')
            ->paginate(10);

        return view('front.browse.publications_by_keyword', compact('results', 'keyword'));
    }

    public function authors(): View
    {
        $authors = Author::paginate(20);
        $totalAuthors = $authors->count();
        return view('front.browse.authors', compact('authors', 'totalAuthors'));
    }

    public function publicationsByAuthor($id): View
    {
        $author = Author::findOrFail($id);
        $results = Publication::whereHas('authors', function($query) use ($author) {
            $query->where('authors.id', $author->id);
        })
            ->orderBy('publication_date', 'desc')
            ->paginate(10);

        return view('front.browse.publications_by_author', compact('results', 'author'));
    }

    public function publishers(): View
    {
        $publishers = Publisher::paginate(20);
        $totalPublishers = $publishers->count();
        return view('front.browse.publishers', compact('publishers', 'totalPublishers'));
    }

    public function publicationsByPublisher($id): View
    {
        $publisher = Publisher::findOrFail($id);
        $results = Publication::where('publisher_id', $publisher->id)
            ->orderBy('publication_date', 'desc')
            ->paginate(10);

        return view('front.browse.publications_by_publisher', compact('results', 'publisher'));
    }

    public function categories()
    {
        $categories = Category::with('children')->whereNull('parent_id')->paginate(20);
        $totalCategories = $categories->count();
        return view('front.browse.categories', compact('categories', 'totalCategories'));
    }

    public function childCategories($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $subcategories = $category->children()->paginate(10);

        if ($subcategories->count() == 0) {
            $publications = $category->publications()
                ->orderBy('publication_date', 'desc')
                ->paginate(10);
            return view('front.browse.publications_by_category', compact('category', 'publications'));
        }

        return view('front.browse.child_categories', compact('category', 'subcategories'));
    }

    public function publicationsByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $results = Publication::whereHas('categories', function($query) use ($category) {
            $query->where('categories.id', $category->id);
        })
            ->orderBy('publication_date', 'desc')
            ->paginate(10);

        return view('front.browse.publications_by_category', compact('results', 'category'));
    }

    public function years(): View
    {
        $years = Publication::select(DB::raw('YEAR(publication_date) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->paginate(20);

        return view('front.browse.years', compact('years'));
    }

    public function publicationsByYear($year): View
    {
        $results = Publication::whereYear('publication_date', $year)
            ->orderBy('publication_date', 'desc')
            ->paginate(10);
        $totalResults = $results->total();

        return view('front.browse.publications_by_year', compact('results', 'year', 'totalResults'));
    }

    public function types(): View
    {
        $types = Type::paginate(10);

        return view('front.browse.types', compact('types'));
    }

    public function publicationsByType($id): View
    {
        $type = Type::findOrFail($id);
        $results = Publication::where('type_id', $id)
            ->orderBy('publication_date', 'desc')
            ->paginate(10);

        return view('front.browse.publications_by_type', compact('results', 'type'));
    }
}
