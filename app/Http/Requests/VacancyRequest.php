<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\IndustryEnum;
use App\Enums\LocationEnum;
use App\Enums\VacancyTypeEnum;
use Illuminate\Validation\Rule;


class VacancyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'company_id' => ['required', 'exists:companies,id'],
            'skills_required' => ['nullable', 'string'],
            'application_open_date' => ['required', 'date'],
            'application_close_date' => ['required', 'date', 'after:application_open_date'],
            'location' => [Rule::enum(LocationEnum::class)],
            'salary'=>['nullable'],
            'industry' => [Rule::enum(IndustryEnum::class)],
            'vacancy_type' => [Rule::enum(VacancyTypeEnum::class)],
        ];
    }
}
