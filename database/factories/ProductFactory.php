<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'store_id' => $this->faker->numberBetween(1, 1),
            'name' => $this->faker->name,
            'value' => $this->faker->numberBetween(10, 100),
            'active' => $this->faker->boolean,
        ];
    }
}
