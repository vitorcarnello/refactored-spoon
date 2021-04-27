<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class PlanFactory extends Factory
{
    use WithFaker;

    protected $model = Plan::class;

    public function definition()
    {
        return [
            'name'        => $this->faker->realText,
            'description' => $this->faker->realText,
        ];
    }
}