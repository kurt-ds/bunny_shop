<?php

namespace App\Http\Controllers;

use App\Http\Resources\BunnyResource;
use App\Models\Bunny;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BunnyController extends Controller
{
    public function index(Request $request) {
        $bunnies = Bunny::paginate(3)->toResourceCollection();

        return BunnyResource::collection($bunnies);
    }
}
