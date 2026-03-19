<?php

namespace App\Http\Controllers;

use App\Models\Bunny;
use App\Http\Requests\StoreBunnyRequest;
use App\Http\Requests\UpdateBunnyRequest;
use App\Http\Resources\BunnyResource;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class BunnyController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Bunny::query();

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        if ($request->filled('category')) {
            $query->ofCategory($request->input('category'));
        }

        $perPage = $request->integer('per_page', 3);
        $perPage = max(1, min($perPage, 100));

        $bunnies = $query->paginate($perPage)->withQueryString();

        return BunnyResource::collection($bunnies);
    }

    public function show(Bunny $bunny): BunnyResource
    {
        return new BunnyResource($bunny);
    }

    public function store(StoreBunnyRequest $request): BunnyResource
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('bunnies', 'public');
                $validated['image_url'] = $path;
            }

            $bunny = Bunny::create($validated);

            return new BunnyResource($bunny);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to add bunny!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
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
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete bunny.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateBunnyRequest $request, $id)
    {
        try {
            $bunny = Bunny::findOrFail($id);

            $validated = $request->validated();

            if ($request->hasFile('image')) {
                if ($bunny->image_url) {
                    Storage::disk('public')->delete($bunny->image_url);
                }

                $path = $request->file('image')->store('bunnies', 'public');
                $validated['image_url'] = $path;
            }

            $bunny->update($validated);

            return new BunnyResource($bunny);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update bunny.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function showPage()
    {
        return Inertia::render('Bunnies/Index');
    }

    public function showBunny($id)
    {
        return Inertia::render('Bunnies/Single', [
            'id' => $id
        ]);
    }

    public function showAddBunny()
    {
        return Inertia::render('Bunnies/Create');
    }

    public function showEditBunny($id)
    {
        return Inertia::render('Bunnies/Edit', [
            'id' => $id
        ]);
    }
}
