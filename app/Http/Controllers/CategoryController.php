<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{

    public function index(): View
    {
        $categories = Category::all();

        return view('admin.category.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.category.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return to_route('category.index')->with('status', 'Category created successfully!');
    }

    public function edit(Category $category): View
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());
        return to_route('category.index')->with('status', 'Category updated successfully!');
    }

    public function destroy(Category $category): RedirectResponse
    {
        try {
            $category->delete();
            $message = 'Category deleted successfully!';
        } catch (\Exception $e) {
            $message = 'Failed to delete the category. It might be in use.';
        }
        return to_route('category.index')->with('status', $message);
    }

}
