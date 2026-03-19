<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Inertia\Inertia;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['slug'] = Str::slug($validated['name']);

            $category = Category::create($validated);

            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to add category!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Removal of breed is successful'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Removal is unsuccessful',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);

            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Fetching category failed!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $validated = $request->validated();

            $category->update($validated);

            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update category!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function showPage()
    {
        return Inertia::render('Categories/Index');
    }

    public function showAddCategory()
    {
        return Inertia::render('Categories/Create');
    }

    public function showEditCategory($id)
    {
        return Inertia::render('Categories/Edit', [
            'id' => $id
        ]);
    }
}
