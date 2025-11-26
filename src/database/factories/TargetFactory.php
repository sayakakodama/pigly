<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TargetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10);
            'target_weight' => $this->faker->randomFloat(1, 40, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
