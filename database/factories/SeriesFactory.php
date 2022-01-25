<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'publisher_id' => Publisher::factory(),
            'volume' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->text(),
            'start_year' => $this->faker->year(),
            'end_year' => $this->faker->year(),
            'rating' => $this->faker->word(),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
