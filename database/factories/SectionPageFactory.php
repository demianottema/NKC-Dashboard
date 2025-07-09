<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SectionPage>
 */
class SectionPageFactory extends Factory
{
    public function definition(): array
    {
        // Get all SectionPageTypes from the folder
        $folder = app_path('Filament\Resources\Groups\SectionTypes\Types');
        $namespace = 'App\\Filament\\Resources\\Groups\\SectionTypes\\Types\\';

        $classes = collect(File::files($folder))
            ->filter(fn($file) => $file->getExtension() === 'php')
            ->map(function ($file) use ($namespace) {
                $class = $namespace . $file->getBasename('.php');
                return class_exists($class) ? $class : null;
            })
            ->filter()
            ->values();

        return [
            'name' => $this->faker->sentence(3),
            'section_id' => Section::factory(),
            'type' => $this->faker->randomElement($classes)
        ];
    }
}
