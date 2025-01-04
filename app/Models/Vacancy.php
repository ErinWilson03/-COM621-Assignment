<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\VacancyTypeEnum;
use App\Enums\IndustryEnum;
use App\Enums\LocationEnum;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vacancy extends Model
{
    /** @use HasFactory<\Database\Factories\VacancyFactory> */
    use HasFactory;
    protected $table = 'vacancies';

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'vacancy_type' => VacancyTypeEnum::class,
        'industry' => IndustryEnum::class,
        'location'=> LocationEnum::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function application(): HasMany
    {
        return $this->hasMany(Application::class);
    }

}
