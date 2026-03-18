<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Inertia\Inertia;

   
class CategoryController extends Controller
{
    public function index(Request $request) {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    public function showPage() {
        return Inertia::render('Categories/Index');
    }
}

