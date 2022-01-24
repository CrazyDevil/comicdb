<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PublisherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'founded_year' => $this->faker->year(),
            'website_url' => $this->faker->unique()->url(),
            'twitter_url' => $this->faker->unique()->url(),
            'address' => $this->faker->address(),
            'zip' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'country' => $this->faker->countryISOAlpha3(),
        ];
    }
}
