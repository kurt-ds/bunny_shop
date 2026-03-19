<?php

namespace App\Http\Controllers;

use App\Models\Bunny;
use Illuminate\Http\Request;
use App\Http\Resources\BunnyResource;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

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

            if ($request->filled('category')) {
                $query->ofCategory($request->input('category'));
            }


            $perPage = $request->integer('per_page', 3);
            $perPage = max(1, min($perPage, 100));

            // 3. Call paginate() on the $query instance that has the filters applied
            $bunnies = $query->paginate($perPage)->withQueryString();

            return BunnyResource::collection($bunnies);
        }
    
    public function show(Bunny $bunny): BunnyResource {
        return new BunnyResource($bunny);
    }

    public function store(Request $request): BunnyResource {
        //VALIDATION
        try {
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0|max:99999.99',
                'age_months' => 'required|numeric|min:0|max:240',
                'gender' => 'required|in:male,female',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string|max:1000',
            ]);

            // Check if an image was actually uploaded
            if ($request->hasFile('image')) {
                // Store the file in 'storage/app/public/bunnies' 
                // and get the relative path
                $path = $request->file('image')->store('bunnies', 'public');
                
                // Replace the 'image' value in our validated array with the path
                $validated['image_url'] = $path;
            }



            //INSERTION

            $bunny = Bunny::create($validated);

            return new BunnyResource($bunny);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to add bunny!',
                'error' => $e->getMessage()
            ], 500);
        }
        }

    public function destroy($id) {
        try {
            $bunny = Bunny::findOrFail($id);

            if ($bunny->image_url) {
                Storage::disk('public')->delete($bunny->image_url);
            }

            $bunny->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bunny released!'
            ]);

        } catch (Exception $e) {
            // Handle cases where the bunny doesn't exist or deletion fails
            return response()->json([
                'message' => 'Failed to delete bunny.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id) {
    $bunny = Bunny::findOrFail($id);

    $validated = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0|max:99999.99',
        'age_months' => 'required|numeric|min:0|max:240',
        'gender' => 'required|in:male,female',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required|string|max:1000',
    ]);

    // 1. Check if a new image file was uploaded
    if ($request->hasFile('image')) {
        
        // 2. Delete the old image if it exists in storage
        if ($bunny->image_url) {
            // Assumes image_url is stored as 'bunnies/filename.jpg'
            Storage::disk('public')->delete(
                $bunny->image_url);
        }

        // 3. Store the new image and get the path
        $path = $request->file('image')->store('bunnies', 'public');
        
        // 4. Add the new path to the validated data
        $validated['image_url'] = $path;
    }

        $bunny = Bunny::findOrFail($id);

        $bunny->update($validated);


        return new BunnyResource($bunny);
    }


    public function showPage() {
        return Inertia::render('Bunnies/Index');
    }

    public function showBunny($id) {
        return Inertia::render('Bunnies/Single', [
            'id' => $id
        ]);
    }

    public function showAddBunny() {
        return Inertia::render('Bunnies/Create');
    }

    public function showEditBunny($id) {
        return Inertia::render('Bunnies/Edit', [
            'id' => $id
        ]);
    }
}

