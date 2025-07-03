<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a admin user
        $user = User::FirstOrCreate([
            'email'                 => 'd.ottema@aegolius.nl',
        ],
        [
            'name'                  => 'Demian Ottema',
            'password'              => Hash::make( env('ADMIN_PASSWORD', 'Welkom123') ),
            'email_verified_at'     => now(),
        ]);

        for ($i = 1; $i < 15; $i++){
            $group = $user->groups()->create([
                'name' => 'Activiteitencomissie ('.$i.')',
                'slug' => 'actco-'.$i,
            ]);
        }

        $group = $user->groups()->create([
            'name' => 'Activiteitencomissie',
            'slug' => 'actco',
        ]);

        $section = $group->sections()->create([
            'name' => 'Vergaderingen'
        ]);

        for ($i = 1; $i < 100; $i++){
            $section->sectionPages()->create([
                'name' => 'Maandag 03-04-2025 ('.$i.')'
            ]);
        }
        
    }
}
