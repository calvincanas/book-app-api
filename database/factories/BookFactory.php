<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(random_int(3, 10)),
            'description' => $this->faker->text,
            'author' => $this->faker->name
        ];
    }
}
