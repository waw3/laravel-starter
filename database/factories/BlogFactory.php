<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(rand(5, 15), true)),
            'slug' => $this->faker->unique->slug,
            'content' => $this->faker->paragraph(5),
            'photo' => 'images/photo'.$this->faker->unique()->numberBetween(0, 17).'.jpg',
        ];
    }
}
