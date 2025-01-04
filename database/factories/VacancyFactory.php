<?php

namespace Database\Factories;

use App\Models\Vacancy;
use App\Models\Company;
use App\Enums\VacancyTypeEnum;
use App\Enums\IndustryEnum;
use App\Enums\LocationEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacancy>
 */
class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate realistic future dates
        $applicationOpenDate = Carbon::now()->addDays(rand(1, 30)); // Open within the next 30 days
        $applicationCloseDate = $applicationOpenDate->copy()->addMonths(rand(1, 3)); // Close within 1 to 3 months after open

        // Use ucwords to ensure title is in proper case
        $title = ucwords($this->faker->jobTitle());

        // Generate a reference number which matches the pattern
        $referenceNumber = 'VAC-' . strtoupper(Str::random(6));

        // Generate a fake company
        $company = Company::factory()->create();  // Create and persist a User

        return [
            'title' => $title,
            'company_id' => $company,
            'description' => $this->faker->sentence(),
            'skills_required' => implode(', ', $this->faker->words(5)),
            'application_open_date' => $applicationOpenDate->format('Y-m-d H:i:s'),
            'application_close_date' => $applicationCloseDate->format('Y-m-d H:i:s'),
            'location' => $this->faker->randomElement(LocationEnum::cases())->value,
            'salary' => $this->faker->numberBetween(20000, 150000),
            'industry' => $this->faker->randomElement(IndustryEnum::cases())->value,
            'vacancy_type' => $this->faker->randomElement(VacancyTypeEnum::cases())->value,
            'reference_number' => $referenceNumber,
        ];
    }
}
