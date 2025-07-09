<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use App\Models\Section;
use App\Models\SectionPage;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create an admin user
        $user = User::firstOrCreate([
            'email' => 'd.ottema@aegolius.nl',
        ], [
            'name' => 'Demian Ottema',
            'password' => Hash::make(env('ADMIN_PASSWORD', 'Welkom123')),
            'email_verified_at' => now(),
        ]);

        // Create 5 users with avatar
        User::factory()->count(5)->create();

        // Create 5 groups
        Group::factory()->count(5)->create()->each(function ($group) use ($user) {
            // Attach admin user to group
            $group->users()->attach($user->id);

            // Attach random users to group
            $group->users()->attach(
                User::where('id', '!=', $user->id)->inRandomOrder()->take(rand(1, 5))->pluck('id')
            );

            // Create 5 sections for each group
            Section::factory()->count(5)->create([
                'group_id' => $group->id,
            ])->each(function ($section) {
                // Create 3-10 pages per section
                SectionPage::factory()->count(rand(3,10))->create([
                    'section_id' => $section->id,
                ]);
            });
        });
    }
}