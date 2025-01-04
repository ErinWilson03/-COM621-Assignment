<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;

    protected $table = 'companies';

    protected $guarded = [
        'id',
    ];


    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

    // Companies have one author user
    public function authors(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
