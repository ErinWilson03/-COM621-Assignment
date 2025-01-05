<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate fake vacancies and users so i can reference them directly
        $vacancy = Vacancy::factory()->create();
        $user = User::factory()->create();

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'mobile_number' => $this->faker->numerify('07########'),
            'supporting_statement' => $this->faker->sentence(),
            'cv_path' => 'path/to/fake/cv.pdf',
            'vacancy_reference' => $vacancy->reference_number,
            'user_id' => $user->id,
        ];
    }
}
