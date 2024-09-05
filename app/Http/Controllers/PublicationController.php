<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Models\Publication;
use App\Models\Author;
use App\Models\Type;
use App\Models\Keyword;
use App\Models\Publisher;
use App\Models\Collection;
use App\Models\FieldDefinition;
use App\Models\PublicationUri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as TitleView;
use App\Jobs\ProcessPdf;


class PublicationController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::all();
        $types = Type::all();
        $keywords = Keyword::all();
        $publishers = Publisher::all();
        $collections = Collection::all();
        $collectionsWithPath = $this->buildCollectionPaths($collections);

        $publicationsQuery = Publication::query()
            ->when($request->input('search'), function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('id', $search)
                        ->orWhere('title', 'like', "%{$search}%");
                });
            })
            ->when($request->input('publication_date_from'), function ($query, $publication_date_from) {
                return $query->where('publication_date', '>=', $publication_date_from);
            })
            ->when($request->input('publication_date_to'), function ($query, $publication_date_to) {
                return $query->where('publication_date', '<=', $publication_date_to);
            })
            ->when($request->input('publisher_id'), function ($query, $publisher_id) {
                return $query->where('publisher_id', $publisher_id);
            })
            ->when($request->input('type_id'), function ($query, $type_id) {
                return $query->where('type_id', $type_id);
            })
            ->when($request->input('collections'), function ($query, $collections) {
                return $query->whereHas('collections', function ($query) use ($collections) {
                    $query->whereIn('collections.id', $collections);
                });
            })
            ->when($request->input('authors'), function ($query, $authors) {
                return $query->whereHas('authors', function ($query) use ($authors) {
                    $query->whereIn('authors.id', $authors);
                });
            })
            ->when($request->input('keywords'), function ($query, $keywords) {
                return $query->whereHas('keywords', function ($query) use ($keywords) {
                    $query->whereIn('keywords.id', $keywords);
                });
            })
            ->when($request->filled('active'), function ($query) use ($request) {
                return $query->where('active', $request->input('active'));
            })
            ->orderBy('id', 'desc');;

        $totalPublications = $publicationsQuery->count();
        $publications = $publicationsQuery->paginate(10);
        TitleView::share('pageTitle', 'Publications');

        return view('admin.publications.index', compact('publications', 'authors', 'types', 'keywords', 'publishers', 'collections', 'collectionsWithPath', 'totalPublications'));
    }

    public function create(): View
    {
        $authors = Author::all();
        $types = Type::all();
        $keywords = Keyword::all();
        $publishers = Publisher::all();
        $collections = Collection::all();
        $customFields = FieldDefinition::all();
        TitleView::share('pageTitle', 'Create Publication');
        return view('admin.publications.create', compact('authors', 'types', 'keywords', 'publishers', 'collections', 'customFields'));
    }

    public function store(StorePublicationRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $name = $originalName;
            $counter = 1;

            while (Storage::disk('public')->exists("publications/{$name}.{$extension}")) {
                $name = $originalName . '_' . $counter;
                $counter++;
            }

            $filePath = $file->storeAs('publications', "{$name}.{$extension}", 'public');
            $validatedData['file'] = $filePath;
        }

        $publication = Publication::create($validatedData);
        $this->syncRelations($publication, $request);

        if ($request->has('custom_fields')) {
            foreach ($request->input('custom_fields') as $fieldName => $fieldData) {
                $publication->customFields()->create([
                    'field_definition_id' => $fieldData['type_id'],
                    'value' => $fieldData['value'],
                ]);
            }
        }

        if ($request->has('uris')) {
            $uris = $request->input('uris');
            foreach ($uris as $uri) {
                if (!is_null($uri) && $uri !== '') {
                    PublicationUri::create(['publication_id' => $publication->id, 'uri' => $uri]);
                }
            }
        }

        if (isset($filePath) && config('app.store_pdf_contents')) {
            ProcessPdf::dispatch(storage_path('app/public/' . $filePath), $publication->id);
        }

        return to_route('publications.index')->with('success', 'Publication created successfully.');
    }


    public function show(Publication $publication): View
    {
        return view('publications.show', compact('publication'));
    }

    public function edit(Publication $publication): View
    {
        $authors = Author::all();
        $types = Type::all();
        $keywords = Keyword::all();
        $publishers = Publisher::all();
        $collections = Collection::all();
        $customFields = FieldDefinition::all();
        $publicationCustomFields = $publication->customFields;
        $uris = $publication->uris;
        $collectionsWithPath = $this->buildCollectionPaths($collections);

        TitleView::share('pageTitle', 'Edit Publication');
        return view('admin.publications.edit', compact('publication', 'authors', 'types', 'keywords','publishers','collections', 'customFields', 'publicationCustomFields', 'uris', 'collectionsWithPath'));
    }

    public function update(UpdatePublicationRequest $request, Publication $publication): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $originalName  = Str::slug($originalName, '_');

            $name = $originalName;
            $counter = 1;

            while (Storage::disk('public')->exists("publications/{$name}.{$extension}")) {
                if ("publications/{$name}.{$extension}" != $publication->file) {
                    $name = $originalName . '_' . $counter;
                    $counter++;
                } else {
                    break;
                }
            }

            $filePath = $file->storeAs('publications', "{$name}.{$extension}", 'public');
            $validatedData['file'] = $filePath;

            if ($publication->file && $publication->file !== $filePath) {
                Storage::disk('public')->delete($publication->file);
            }

            if (config('app.store_pdf_contents')) {
            ProcessPdf::dispatch(storage_path('app/public/' . $filePath), $publication->id);
            }
        }

        $publication->update($validatedData);
        $this->syncRelations($publication, $request);

        $customFields = $request->input('custom_fields', []);
        $existingCustomFields = $publication->customFields->keyBy('field_definition_id');

        // Update or create custom fields
        foreach ($customFields as $fieldData) {
            $fieldDefinitionId = $fieldData['field_definition_id'];
            $value = $fieldData['value'];

            if ($existingCustomFields->has($fieldDefinitionId)) {
                $existingCustomField = $existingCustomFields->get($fieldDefinitionId);
                $existingCustomField->update(['value' => $value]);
            } else {
                $publication->customFields()->create([
                    'field_definition_id' => $fieldDefinitionId,
                    'value' => $value,
                ]);
            }
        }

        foreach ($existingCustomFields as $fieldDefinitionId => $existingCustomField) {
            if (!isset($customFields[$fieldDefinitionId])) {
                $existingCustomField->delete();
            }
        }

        $uris = $request->input('uris', []);
        $uriModels = [];

        if ($request->has('uris')) {
            $uris = $request->input('uris');
            PublicationUri::where('publication_id', $publication->id)->delete();
            foreach ($uris as $uri) {
                PublicationUri::create(['publication_id' => $publication->id, 'uri' => $uri]);
            }
        }

        return to_route('publications.index')->with('success', 'Publication updated successfully.');
    }

    public function destroy(Publication $publication): RedirectResponse
    {
        $publication->delete();
        return to_route('publications.index')->with('success', 'Publication deleted successfully.');
    }

    /**
     * Syncs authors and keywords relations for a publication.
     *
     * @param  \App\Models\Publication  $publication
     * @param  \Illuminate\Foundation\Http\FormRequest  $request
     */

    private function syncRelations(Publication $publication, FormRequest $request): void
    {
        // Sync authors
        $authors = $request->input('authors', []);
        $publication->authors()->sync($authors);

        // Process keywords
        $keywords = $request->input('keywords', []);
        $keywordIds = [];

        foreach ($keywords as $keyword) {
            if (is_numeric($keyword)) {
                $keywordIds[] = $keyword;
            } else {
                // Create new keyword
                $newKeyword = Keyword::firstOrCreate(['keyword' => $keyword], [
                    'slug' => Str::slug($keyword),
                    'active' => 1
                ]);
                $keywordIds[] = $newKeyword->id;
            }
        }

        $publication->keywords()->sync($keywordIds);

        // Sync collections
        $collections = $request->input('collections', []);
        $publication->collections()->sync($collections);
    }

    private function buildCollectionPaths($collections, $parentId = null, $prefix = '')
    {
        $result = [];
        foreach ($collections->where('parent_id', $parentId) as $collection) {
            $collection->full_path = $prefix . $collection->name;
            $result[] = $collection;
            $result = array_merge($result, $this->buildCollectionPaths($collections, $collection->id, $collection->full_path . ' > '));
        }
        return $result;
    }
}
