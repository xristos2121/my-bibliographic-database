<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublisherRequest;
use App\Http\Requests\UpdatePublisherRequest;
use App\Models\Publisher;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublisherController extends Controller
{
    public function index(): View
    {
        $publishers = Publisher::all();
        return view('admin.publisher.index', compact('publishers'));
    }

    public function create(): View
    {
        return view('admin.publisher.create');
    }

    public function store(StorePublisherRequest $request): RedirectResponse
    {
        Publisher::create($request->validated());
        return to_route('publisher.index')->with('success', 'Publisher created successfully.');
    }

    public function edit(Publisher $publisher): View
    {
        return view('admin.publisher.edit', compact('publisher'));
    }

    public function update(UpdatePublisherRequest $request, Publisher $publisher): RedirectResponse
    {
        $publisher->update($request->validated());
        return to_route('publisher.index')->with('success', 'Publisher updated successfully.');
    }

    public function destroy(Publisher $publisher): RedirectResponse
    {
        $publisher->delete();
        return to_route('publisher.index')->with('success', 'Publisher deleted successfully.');
    }
}
