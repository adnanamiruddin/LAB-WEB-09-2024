<?php

namespace Database\Seeders;

use App\Models\JobPost;
use Illuminate\Database\Seeder;

class JobPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobPost::create([
            'employer_id' => 1,
            'title' => 'Software Engineer',
            'location' => 'Remote',
            'job_type' => 'full-time',
            'contact_email' => 'hr@techcorp.com',
            'description' => 'Develop and maintain web applications.',
            'requirements' => '3+ years of experience with PHP and Laravel.',
            'salary' => 600000000.00, 
            'payday' => 'yearly',
        ]);

        JobPost::create([
            'employer_id' => 2,
            'title' => 'Frontend Developer',
            'location' => 'New York, NY',
            'job_type' => 'full-time',
            'contact_email' => 'hr@innovateltd.com',
            'description' => 'Design and implement user interfaces.',
            'requirements' => '2+ years of experience with React.',
            'salary' => 5833333.33, 
            'payday' => 'monthly',
        ]);

        JobPost::create([
            'employer_id' => 1,
            'title' => 'Backend Developer',
            'location' => 'San Francisco, CA',
            'job_type' => 'full-time',
            'contact_email' => 'hr@techcorp.com',
            'description' => 'Develop and maintain backend services.',
            'requirements' => '3+ years of experience with Node.js.',
            'salary' => 1538461.54, 
            'payday' => 'weekly',
        ]);

        JobPost::create([
            'employer_id' => 2,
            'title' => 'Data Analyst',
            'location' => 'Chicago, IL',
            'job_type' => 'full-time',
            'contact_email' => 'hr@innovateltd.com',
            'description' => 'Analyze and interpret complex data sets.',
            'requirements' => '2+ years of experience with SQL and Python.',
            'salary' => 178082.19,
            'payday' => 'daily',
        ]);

        JobPost::create([
            'employer_id' => 1,
            'title' => 'DevOps Engineer',
            'location' => 'Austin, TX',
            'job_type' => 'full-time',
            'contact_email' => 'hr@techcorp.com',
            'description' => 'Manage and automate infrastructure.',
            'requirements' => '3+ years of experience with AWS and Docker.',
            'salary' => 900000000.00,
            'payday' => 'yearly',
        ]);

        JobPost::create([
            'employer_id' => 2,
            'title' => 'UX/UI Designer',
            'location' => 'Seattle, WA',
            'job_type' => 'full-time',
            'contact_email' => 'hr@innovateltd.com',
            'description' => 'Design user-friendly interfaces.',
            'requirements' => '2+ years of experience with Figma and Sketch.',
            'salary' => 5833333.33, 
            'payday' => 'monthly',
        ]);

        JobPost::create([
            'employer_id' => 1,
            'title' => 'Project Manager',
            'location' => 'Boston, MA',
            'job_type' => 'full-time',
            'contact_email' => 'hr@techcorp.com',
            'description' => 'Manage software development projects.',
            'requirements' => '5+ years of experience in project management.',
            'salary' => 1826923.08, 
            'payday' => 'weekly',
        ]);

        JobPost::create([
            'employer_id' => 2,
            'title' => 'QA Engineer',
            'location' => 'Denver, CO',
            'job_type' => 'full-time',
            'contact_email' => 'hr@innovateltd.com',
            'description' => 'Ensure the quality of software products.',
            'requirements' => '3+ years of experience with automated testing.',
            'salary' => 205479.45, 
            'payday' => 'daily',
        ]);
    }
}