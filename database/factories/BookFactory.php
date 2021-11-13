<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['title' => "string", 'author' => "string", 'description' => "string", 'image' => "string"])]
    public function definition(): array {
        return [
            'title' => $this->faker->city(),
            'author' => $this->faker->name(),
            'description' => $this->faker->sentence(30),
            'image' => $this->faker->imageUrl(300, 450)
        ];
    }
}
