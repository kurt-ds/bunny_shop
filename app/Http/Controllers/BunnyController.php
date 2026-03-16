<?php

namespace App\Http\Controllers;

use App\Models\Bunny;
use Illuminate\Http\Request;
use App\Http\Resources\BunnyResource;

class BunnyController extends Controller
{
public function index(Request $request) 
{
    // 1. Start the query builder instance
    $query = Bunny::query();

    // 2. Apply filters to the INSTANCE ($query), not the Class (Bunny)
    // Note: Changed 'name' to 'search' to match your URL
    if ($request->filled('search')) {
        $query->search($request->input('search'));
    }

    if ($request->filled('category_id')) {
        $query->ofCategory($request->input('category_id'));
    }

    // 3. Call paginate() on the $query instance that has the filters applied
    $bunnies = $query->paginate(3)->withQueryString();

    return BunnyResource::collection($bunnies);
}
}