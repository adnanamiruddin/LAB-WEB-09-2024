<?php

namespace Database\Seeders;

use App\Models\Employer;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employer::create([
            'user_id' => 2,
            'company_name' => 'Tech Corp',
            'company_description' => 'A leading tech company.',
            'industry' => 'Technology',
            'website' => 'https://techcorp.com',
            'address' => '123 Tech Street',
            'contact' => '123-456-7890',
        ]);

        Employer::create([
            'user_id' => 3,
            'company_name' => 'Innovate Ltd',
            'company_description' => 'Innovative solutions for modern problems.',
            'industry' => 'Innovation',
            'website' => 'https://innovateltd.com',
            'address' => '456 Innovation Avenue',
            'contact' => '987-654-3210',
        ]);

        Employer::create([
            'user_id' => 4,
            'company_name' => 'NextGen Solutions',
            'company_description' => 'Cutting-edge technology solutions.',
            'industry' => 'Technology',
            'website' => 'https://nextgensolutions.com',
            'address' => '789 Future Road',
            'contact' => '555-555-5555',
        ]);

        Employer::create([
            'user_id' => 5,
            'company_name' => 'GreenTech Innovations',
            'company_description' => 'Innovative green technology solutions.',
            'industry' => 'Green Technology',
            'website' => 'https://greentech.com',
            'address' => '1010 Eco Street',
            'contact' => '444-444-4444',
        ]);

        Employer::create([
            'user_id' => 6,
            'company_name' => 'HealthTech Corp',
            'company_description' => 'Healthcare technology solutions.',
            'industry' => 'Healthcare',
            'website' => 'https://healthtech.com',
            'address' => '2020 Wellness Way',
            'contact' => '333-333-3333',
        ]);

        Employer::create([
            'user_id' => 7,
            'company_name' => 'EduTech Innovations',
            'company_description' => 'Educational technology solutions.',
            'industry' => 'Education',
            'website' => 'https://edutech.com',
            'address' => '3030 Learning Lane',
            'contact' => '222-222-2222',
        ]);

        Employer::create([
            'user_id' => 8,
            'company_name' => 'FinTech Solutions',
            'company_description' => 'Financial technology solutions.',
            'industry' => 'Finance',
            'website' => 'https://fintech.com',
            'address' => '4040 Money Street',
            'contact' => '111-111-1111',
        ]);

        Employer::create([
            'user_id' => 9,
            'company_name' => 'AutoTech Innovations',
            'company_description' => 'Automotive technology solutions.',
            'industry' => 'Automotive',
            'website' => 'https://autotech.com',
            'address' => '5050 Drive Avenue',
            'contact' => '666-666-6666',
        ]);

        Employer::create([
            'user_id' => 10,
            'company_name' => 'BioTech Solutions',
            'company_description' => 'Biotechnology solutions.',
            'industry' => 'Biotechnology',
            'website' => 'https://biotech.com',
            'address' => '6060 Bio Boulevard',
            'contact' => '777-777-7777',
        ]);
    }
}