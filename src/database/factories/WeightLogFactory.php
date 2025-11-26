<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WeightLogFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => 1,
            'date' => $this->faker->date(),
            'weight' => $this->faker->randomFloat(1, 40, 120),
            'calories' => $this->faker->numberBetween(1000, 3000),
            'exercise_time' => $this->faker->time(),
            'exercise_content' => $this->faker->sentence(10),
        ];
    }
}
