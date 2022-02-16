<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $kind = $this->faker->unique()->randomElement(
            [
            "cat",
            "dog",
            "bird",
            "bear",
            ]
        );

        return [
            'kind' => $kind,
            'size_max' => $this->faker->numberBetween(50, 250),
            'age_max' => $this->faker->numberBetween(10, 100),
            'grow_factor' => $this->faker->randomFloat(1, 0.4, 1.5),
            'avatar' => $kind
        ];
    }
}
