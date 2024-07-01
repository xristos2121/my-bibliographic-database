<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdvancedSearchRequest;
use App\Models\Publication;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
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


        $this->applyAdvancedSearchFilters($query, $request);

        $hitsPerPage = $request->input('hits_per_page', 10);
        $results = $query->paginate($hitsPerPage);

        foreach ($results as $result) {
            $cacheKey = 'publication_' . $result->id . '_pdf_text';
            $pdfText = Cache::remember($cacheKey, now()->addDays(30), function () use ($result) {
                return $result->pdf_text;
            });

            if ($request->type && in_array('entire_document', $request->type)) {
                foreach ($request->lookfor as $searchTerm) {
                    if ($this->containsSearchTerm($pdfText, $searchTerm)) {
                        $result->highlighted_text = $this->getHighlightedSnippets($pdfText, $searchTerm);
                    } else {
                        $result->highlighted_text = null;
                    }
                }
            } else {
                $result->highlighted_text = null;
            }
        }

        return view('front.results', [
            'results' => $results,
            'searchParameters' => $request->all(),
            'types' => $types,
            'hits_per_page' => $hitsPerPage
        ]);
    }

    private function applyAdvancedSearchFilters($query, $request)
    {
        if ($request->type) {
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

        if ($request->document_type !== 'all') {
            $query->where('type_id', $request->document_type);
        }

        if ($request->type && in_array('title', $request->type)) {
            $this->applyExactMatchOrder($query, $request->lookfor[array_search('title', $request->type)]);
        }
    }

    private function applyFilter($query, $type, $lookfor)
    {
        $terms = explode(' ', $this->removeDiacritics($lookfor));
        $query->where(function ($subQuery) use ($terms, $type) {
            foreach ($terms as $term) {
                $searchPattern = '%' . $term . '%';
                switch ($type) {
                    case 'title':
                        $subQuery->orWhereRaw("LOWER(REPLACE(title, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern]);
                        break;
                    case 'author':
                        $subQuery->orWhereHas('authors', function ($query) use ($term, $searchPattern) {
                            $query->whereRaw("LOWER(REPLACE(CONCAT(first_name, ' ', last_name), ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern]);
                        });
                        break;
                    case 'abstract':
                        $subQuery->orWhereRaw("LOWER(REPLACE(abstract, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern]);
                        break;
                    case 'keyword':
                        $subQuery->orWhereHas('keywords', function ($query) use ($term, $searchPattern) {
                            $query->whereRaw("LOWER(REPLACE(keyword, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern]);
                        });
                        break;
                    case 'publisher':
                        $subQuery->orWhereHas('publisher', function ($query) use ($term, $searchPattern) {
                            $query->whereRaw("LOWER(REPLACE(name, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern]);
                        });
                        break;
                    case 'entire_document':
                        $subQuery->orWhereRaw("LOWER(REPLACE(title, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern])
                            ->orWhereRaw("LOWER(REPLACE(abstract, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern])
                            ->orWhereRaw("LOWER(REPLACE(pdf_text, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern])
                            ->orWhereHas('authors', function ($query) use ($term, $searchPattern) {
                                $query->whereRaw("LOWER(REPLACE(CONCAT(first_name, ' ', last_name), ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern]);
                            })
                            ->orWhereHas('keywords', function ($query) use ($term, $searchPattern) {
                                $query->whereRaw("LOWER(REPLACE(keyword, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern]);
                            })
                            ->orWhereHas('publisher', function ($query) use ($term, $searchPattern) {
                                $query->whereRaw("LOWER(REPLACE(name, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern]);
                            });
                        break;
                }
            }
        });
    }

    public function search(Request $request): View
    {
        $hitsPerPage = 10;

        $query = Publication::query();
        $types = Type::all();
        $searchTerm = $request->search;

        $this->applySearchFilters($query, $searchTerm);

        $results = $query->paginate($hitsPerPage);

        foreach ($results as $result) {
            $cacheKey = 'publication_' . $result->id . '_pdf_text';
            $pdfText = Cache::remember($cacheKey, now()->addDays(30), function () use ($result) {
                return $result->pdf_text;
            });

            if ($request->type == 'entire_document' && $this->containsSearchTerm($pdfText, $searchTerm)) {
                $result->highlighted_text = $this->getHighlightedSnippets($pdfText, $searchTerm);
            } else {
                $result->highlighted_text = null;
            }
        }

        // Get the last executed query
        $queries = DB::getQueryLog();
        $lastQuery = end($queries);


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

    private function applyExactMatchOrder($query, $searchTerm)
    {
        $terms = explode(' ', $this->removeDiacritics($searchTerm));
        $caseStatements = [];

        foreach ($terms as $term) {
            $term = strtolower($term);
            $caseStatements[] = "LOWER(REPLACE(title, ' ', '')) LIKE '%$term%'";
        }

        $caseSql = implode(' + ', array_map(function ($statement) {
            return "($statement)";
        }, $caseStatements));

        $query->orderByRaw("($caseSql) DESC");
    }

    private function applySearchFilters($query, $searchTerm)
    {
        $terms = explode(' ', $this->removeDiacritics($searchTerm));

        $query->where(function ($subQuery) use ($terms) {
            foreach ($terms as $term) {
                $searchPattern = '%' . $term . '%';
                $subQuery->whereRaw("LOWER(REPLACE(title, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern])
                    ->orWhereRaw("LOWER(REPLACE(abstract, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern])
                    ->orWhereRaw("LOWER(REPLACE(pdf_text, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern])
                    ->orWhereHas('authors', function ($q) use ($term, $searchPattern) {
                        $q->whereRaw("LOWER(REPLACE(CONCAT(first_name, ' ', last_name), ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern]);
                    })
                    ->orWhereHas('keywords', function ($q) use ($term, $searchPattern) {
                        $q->whereRaw("LOWER(REPLACE(keyword, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern]);
                    })
                    ->orWhereHas('publisher', function ($q) use ($term, $searchPattern) {
                        $q->whereRaw("LOWER(REPLACE(name, ' ', '')) LIKE LOWER(REPLACE(?, ' ', ''))", [$searchPattern]);
                    });
            }
        });

        // Add a condition to prioritize exact matches for title
        $this->applyExactMatchOrder($query, $searchTerm);
    }

    private function containsSearchTerm($text, $searchTerm)
    {
        $normalizedText = $this->removeDiacritics($text);
        $terms = explode(' ', $this->removeDiacritics($searchTerm));

        foreach ($terms as $term) {
            if (stripos($normalizedText, $term) !== false) {
                return true;
            }
        }
        return false;
    }

    private function getHighlightedSnippets($text, $searchTerm)
    {
        $terms = explode(' ', $this->removeDiacritics($searchTerm));
        $normalizedText = $this->removeDiacritics($text);

        // Find positions of terms in normalized text
        $positions = $this->getTermPositions($normalizedText, $terms);

        // Generate and highlight snippets in original text
        return $this->highlightSnippets($text, $positions, $terms);
    }

    private function getTermPositions($text, $terms)
    {
        $words = preg_split('/\s+/', $text);
        $wordPositions = [];

        foreach ($terms as $term) {
            foreach ($words as $index => $word) {
                if ($this->isAtLeast80PercentMatch($word, $term)) {
                    $wordPositions[$index] = $word;
                }
            }
        }

        return $wordPositions;
    }

    private function highlightSnippets($text, $positions, $terms, $radius = 5, $maxSnippets = 2)
    {
        // Split the original text into words
        $words = preg_split('/\s+/', $text);
        $snippets = [];

        foreach ($positions as $position => $word) {
            $start = max($position - $radius, 0);
            $end = min($position + $radius, count($words) - 1);
            $length = $end - $start + 1;

            // Extract the snippet
            $snippetWords = array_slice($words, $start, $length);
            $snippetText = implode(' ', $snippetWords);

            // Highlight terms in the snippet
            $highlightedSnippet = $this->highlightText($snippetText, $terms);

            // Add the snippet if it contains highlighted terms
            if ($highlightedSnippet !== $snippetText) {
                $snippets[] = $highlightedSnippet;
            }
        }

        // Remove duplicate snippets
        $snippets = array_unique($snippets);

        // Limit the number of snippets
        $snippets = array_slice($snippets, 0, $maxSnippets);

        // Add ellipsis at the end if there's only one snippet
        if (count($snippets) === 1) {
            $snippets[0] .= ' ...';
        }

        // Combine snippets into a single string
        return !empty($snippets) ? implode(' ... ', $snippets) : '';
    }

    private function isAtLeast80PercentMatch($word, $term)
    {
        $wordLength = mb_strlen($word);
        $termLength = mb_strlen($term);
        $minLength = ceil($wordLength * 0.8);

        if ($termLength >= $minLength) {
            return mb_stripos($word, $term) !== false;
        }

        return false;
    }

    private function highlightText($text, $terms)
    {
        foreach ($terms as $term) {
            $text = preg_replace_callback('/\b(\w+)\b/iu', function ($matches) use ($term) {
                if ($this->isAtLeast80PercentMatch($this->removeDiacritics($matches[0]), $term)) {
                    return '<mark>' . $matches[0] . '</mark>';
                }
                return $matches[0];
            }, $text);
        }
        return $text;
    }

    private function removeDiacritics($text)
    {
        return transliterator_transliterate('NFD; [:Nonspacing Mark:] Remove; NFC;', $text);
    }
}
