<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\User;
use App\Models\Vacancy;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Acquiring the seeded user and applying for three of the seeded vacancies
        $jane = User::where('name', 'Jane Doe')->first();
        Application::create([
            'name' => $jane->name,
            'email' => $jane->email,
            'mobile_number' => '07856236948',
            'supporting_statement' => 'I believe my skills align well with the job, and I would love to contribute.', // Custom supporting statement
            'cv_path' => 'cv_file/Jane_Doe.pdf',
            'vacancy_reference' => 'VAC-812345',
            'user_id' => $jane->id,
        ]);

        Application::create([
            'name' => $jane->name,
            'email' => $jane->email,
            'mobile_number' => '07856236948',
            'supporting_statement' => 'I believe my skills align well with the job, and I would love to contribute.', // Custom supporting statement
            'cv_path' => 'cv_file/Jane_Doe.pdf',
            'vacancy_reference' => 'VAC-867890',
            'user_id' => $jane->id,
        ]);
        
        Application::create([
            'name' => $jane->name,
            'email' => $jane->email,
            'mobile_number' => '07856236948',
            'supporting_statement' => 'I believe my skills align well with the job, and I would love to contribute.', // Custom supporting statement
            'cv_path' => 'cv_file/Jane_Doe.pdf',
            'vacancy_reference' => 'VAC-856789',
            'user_id' => $jane->id,
        ]);
    }
}
