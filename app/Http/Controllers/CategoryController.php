<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::with('children')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->whereNull('parent_id')
            ->get();

        return view('admin.category.index', compact('categories', 'search'));
    }

    public function children(Category $category)
    {
        $children = $category->children;
        return view('admin.category.children', compact('category', 'children'));
    }

    public function create()
    {
        $categories = Category::all();
        $categoriesWithPath = $this->buildCategoryPaths($categories);
        return view('admin.category.create', compact('categories', 'categoriesWithPath'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return to_route('categories.index')->with('status', 'Category created successfully!');
    }

    public function edit(Category $category): View
    {
        $categories = Category::all();
        $categoriesWithPath = $this->buildCategoryPaths($categories);
        return view('admin.category.edit', compact('category', 'categories', 'categoriesWithPath'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());
        return to_route('categories.index')->with('status', 'Category updated successfully!');
    }

    public function destroy(Category $category): RedirectResponse
    {
        try {
            if ($category->publications()->exists()) {
                return redirect()->route('categories.index')->with('status', 'Category cannot be deleted because it is associated with publications.');
            }

            $category->delete();

            return redirect()->route('categories.index')->with('status', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('status', 'Failed to delete the category. It might be in use.');
        }
    }

    private function buildCategoryPaths($categories, $parentId = null, $prefix = '')
    {
        $result = [];
        foreach ($categories->where('parent_id', $parentId) as $category) {
            $category->full_path = $prefix . $category->name;
            $result[] = $category;
            $result = array_merge($result, $this->buildCategoryPaths($categories, $category->id, $category->full_path . ' > '));
        }
        return $result;
    }


}
