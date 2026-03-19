<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Bunny;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Inertia\Inertia;
use Illuminate\Support\Str;

   
class CategoryController extends Controller
{
    public function index(Request $request) {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required|max:1000'
            ]);

            $validated['slug'] = Str::slug($validated['name']);

            $category = Category::create($validated);

            return new CategoryResource($category);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to add category!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id) {
        try {
            $category = Category::findOrFail($id);

            $category->delete();

            return response()->json([
                'success'=> true,
                'message'=> 'Removal of breed is successsful'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message'=> 'Removal is UNsuccessful',
                'error'=> $e->getMessage()
            ], 500);
        }
    }

    public function show($id) {
        try {
            $category = Category::findOrFail($id);

            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Fetching category failed!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $category = Category::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required|max:1000'
            ]);


            $category->update($validated);

            return new CategoryResource($category);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update category!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showPage() {
        return Inertia::render('Categories/Index');
    }

    public function showAddCategory() {
        return Inertia::render('Categories/Create');
    }

    public function showEditCategory($id) {
        return Inertia::render('Categories/Edit', [
            'id'=> $id
        ]);
    }
}

