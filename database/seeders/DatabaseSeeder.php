<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder; 
use App\Models\Category;
use App\Models\Bunny; 
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $breeds = collect(['Netherland Dwarf', 'Holland Lop', 'Lionhead', 'Mini Rex']);


        $breeds->each(function($breedName) {
            $category = Category::factory()->create([
                'name' => $breedName,
                'slug' => Str::slug($breedName),
            ]);

            for ($i = 1; $i <= 3; $i++) {
                $imageName = Str::snake(strtolower($breedName)) . "_{$i}.jpg";
           
                Bunny::factory()->create([
                    'category_id' => $category->id,
                    'image_url' => "bunnies/{$imageName}",
                ]);
            }


        });





    }
}
