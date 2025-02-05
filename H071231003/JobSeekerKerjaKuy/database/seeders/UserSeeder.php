<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('password11'),
        ]);

        User::factory()->create([
            'username' => 'employer1',
            'email' => 'employer1@gmail.com',
            'role' => 'employer',
            'password' => bcrypt('password11'),
        ]);

        User::factory()->create([
            'username' => 'employer2',
            'email' => 'employer2@gmail.com',
            'role' => 'employer',
            'password' => bcrypt('password11'),
        ]);

        User::factory()->create([
            'username' => 'jobseeker1',
            'email' => 'jobseeker1@gmail.com',
            'role' => 'job_seeker',
            'password' => bcrypt('password11'),
        ]);

        User::factory()->create([
            'username' => 'jobseeker2',
            'email' => 'jobseeker2@gmail.com',
            'role' => 'job_seeker',
            'password' => bcrypt('password11'),
        ]);

        User::factory()->create([
            'username' => 'jobseeker3',
            'email' => 'jobseeker3@gmail.com',
            'role' => 'job_seeker',
            'password' => bcrypt('password11'),
        ]);

        User::factory()->create([
            'username' => 'jobseeker4',
            'email' => 'jobseeker4@gmail.com',
            'role' => 'job_seeker',
            'password' => bcrypt('password11'),
        ]);

        User::factory()->create([
            'username' => 'jobseeker5',
            'email' => 'jobseeker5@gmail.com',
            'role' => 'job_seeker',
            'password' => bcrypt('password11'),
        ]);

        User::factory(5)->create();
    }
}