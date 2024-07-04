<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name;

        // Fetch a random category id or return null
        $parentId = Category::inRandomOrder()->value('id');
        
        return [
            'name' => $name,
            'slug' => Str::slug($name), // Generate slug based on the name
            'status' => 'active',
            'parent_id' => $this->faker->boolean(70) ? $parentId : null, // 70% chance of having a parent_id
        ];
    }
}
