<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'price' => $this->faker->randomNumber(2),
            'size' => $this->faker->randomElement(['1', '2', '4', '6', '8', '10', '12', 'PP', 'P', 'M', 'G', 'GG', 'EGG', 'BABYLOOK']),
            'type' => $this->faker->numberBetween(1,4),
            'model' => $this->faker->word,
            'tissue' => $this->faker->word,
            'color' => $this->faker->word,
            'pocket' => $this->faker->numberBetween(0,1),
            'collar' => $this->faker->numberBetween(1,5),
            'cuff' => $this->faker->numberBetween(1,4),
            'vivo' => $this->faker->numberBetween(0,1),
            'faixa' => $this->faker->numberBetween(1,3),
        ];
    }
}
