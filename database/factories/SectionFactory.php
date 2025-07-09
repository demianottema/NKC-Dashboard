<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    protected $model = Section::class;

    public function definition(): array
    {
        return [
            'group_id' => Group::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
        ];
    }
}