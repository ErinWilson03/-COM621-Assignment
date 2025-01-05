<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\User;
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
            'supporting_statement' => 'I am the best candiatate for this role and my experience exemplifies this',
            'cv_path' => 'cv_file/Jane_Doe.pdf',
            'vacancy_reference' => 'VAC-812345',
            'user_id' => $jane->id,
        ]);

        Application::create([
            'name' => $jane->name,
            'email' => $jane->email,
            'mobile_number' => '07856236948',
            'supporting_statement' => 'I would love to contribute to such a high-class company with international ties.',
            'cv_path' => 'cv_file/Jane_Doe.pdf',
            'vacancy_reference' => 'VAC-867890',
            'user_id' => $jane->id,
        ]);

        Application::create([
            'name' => $jane->name,
            'email' => $jane->email,
            'mobile_number' => '07856236948',
            'supporting_statement' => 'I believe my skills align well with the job, and I will provide high quality work in this role.',
            'cv_path' => 'cv_file/Jane_Doe.pdf',
            'vacancy_reference' => 'VAC-856789',
            'user_id' => $jane->id,
        ]);
    }
}
