<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $company = $this->faker->company,
            'slug' => Str::slug($company),
            'description' => $this->faker->sentence,
            'notes' => $this->faker->paragraph,
            'agreements' => $this->faker->paragraph,
            'has_budget_management' => $this->faker->boolean,
            'has_file_management' => $this->faker->boolean,
            'active' => $this->faker->boolean,
        ];
    }
}
