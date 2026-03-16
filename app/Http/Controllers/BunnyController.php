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
    
    public function show(Bunny $bunny): BunnyResource {
        return new BunnyResource($bunny);
    }

    public function store(Request $request): BunnyResource {
        //VALIDATION

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:99999.99',
            'age_months' => 'required|numeric|min:0|max:12',
            'gender' => 'required|in:male,female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string|max:1000',
            'is_sold' => 'required|boolean'
        ]);

        //ERROR HANDLING
        if ($request->hasFile('image')) {
            // This stores the file in storage/app/public/bunnies
            // and returns the path (e.g., "bunnies/xyz.jpg")
            $path = $request->file('image')->store('bunnies', 'public');
                
            // Add the path to the validated data array
            $validated['image_url'] = $path;

        //INSERTION

        $bunny = Bunny::create($validated);

        return new BunnyResource($bunny);
    }
}