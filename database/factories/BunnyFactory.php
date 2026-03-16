<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;



class BunnyFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique->word();

        return [
            'name' => ucfirst($name),
            'category_id' => Category::factory(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'age_months' => $this->faker->numberBetween(1, 12),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'image_url' => 'bunnies/placeholder.jpg',
            'description' => $this->faker->paragraph(),
            'is_sold' => $this->faker->boolean()
        ];
    }
}
