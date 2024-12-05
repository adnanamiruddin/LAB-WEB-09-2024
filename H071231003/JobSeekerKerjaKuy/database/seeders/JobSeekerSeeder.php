<?php

namespace Database\Seeders;

use App\Models\JobSeeker;
use Illuminate\Database\Seeder;

class JobSeekerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobSeeker::create([
            'user_id' => 3,
            'full_name' => 'John Doe',
            'skills' => 'PHP, Laravel, JavaScript',
            'certificates' => 'Certified Laravel Developer',
            'education_history' => 'B.Sc. in Computer Science',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'contact' => '987-654-3210',
            'address' => '456 Main Street',
            'bio' => 'Experienced web developer.',
        ]);

        JobSeeker::create([
            'user_id' => 4,
            'full_name' => 'Alice Johnson',
            'skills' => 'Python, Django, Machine Learning',
            'certificates' => 'Certified Data Scientist',
            'education_history' => 'M.Sc. in Data Science',
            'date_of_birth' => '1988-03-03',
            'gender' => 'female',
            'contact' => '321-654-9870',
            'address' => '123 Oak Street',
            'bio' => 'Data scientist with a passion for AI.',
        ]);

        JobSeeker::create([
            'user_id' => 5,
            'full_name' => 'Jane Smith',
            'skills' => 'React, Node.js, MongoDB',
            'certificates' => 'Certified Full Stack Developer',
            'education_history' => 'B.Sc. in Software Engineering',
            'date_of_birth' => '1992-02-02',
            'gender' => 'female',
            'contact' => '123-456-7890',
            'address' => '789 Elm Street',
            'bio' => 'Full stack developer with 5 years of experience.',
        ]);

        JobSeeker::create([
            'user_id' => 6,
            'full_name' => 'Michael Brown',
            'skills' => 'Java, Spring, Hibernate',
            'certificates' => 'Certified Java Developer',
            'education_history' => 'B.Sc. in Information Technology',
            'date_of_birth' => '1985-05-05',
            'gender' => 'male',
            'contact' => '555-555-5555',
            'address' => '1010 Binary Blvd',
            'bio' => 'Java developer with 10 years of experience.',
        ]);

        JobSeeker::create([
            'user_id' => 7,
            'full_name' => 'Emily Davis',
            'skills' => 'Ruby, Rails, PostgreSQL',
            'certificates' => 'Certified Ruby Developer',
            'education_history' => 'B.Sc. in Computer Engineering',
            'date_of_birth' => '1991-07-07',
            'gender' => 'female',
            'contact' => '444-444-4444',
            'address' => '2020 Code Lane',
            'bio' => 'Ruby on Rails developer with 8 years of experience.',
        ]);

        JobSeeker::create([
            'user_id' => 8,
            'full_name' => 'David Wilson',
            'skills' => 'C#, .NET, SQL Server',
            'certificates' => 'Certified .NET Developer',
            'education_history' => 'B.Sc. in Software Development',
            'date_of_birth' => '1987-09-09',
            'gender' => 'male',
            'contact' => '333-333-3333',
            'address' => '3030 Dev Drive',
            'bio' => 'Experienced .NET developer.',
        ]);

        JobSeeker::create([
            'user_id' => 9,
            'full_name' => 'Sophia Martinez',
            'skills' => 'Swift, iOS, Xcode',
            'certificates' => 'Certified iOS Developer',
            'education_history' => 'B.Sc. in Mobile Development',
            'date_of_birth' => '1993-11-11',
            'gender' => 'female',
            'contact' => '222-222-2222',
            'address' => '4040 App Avenue',
            'bio' => 'iOS developer with 6 years of experience.',
        ]);

        JobSeeker::create([
            'user_id' => 10,
            'full_name' => 'Olivia Garcia',
            'skills' => 'Kotlin, Android, Firebase',
            'certificates' => 'Certified Android Developer',
            'education_history' => 'B.Sc. in Mobile Computing',
            'date_of_birth' => '1995-12-12',
            'gender' => 'female',
            'contact' => '111-111-1111',
            'address' => '5050 Mobile Street',
            'bio' => 'Android developer with 4 years of experience.',
        ]);
    }
}