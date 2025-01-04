<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;

    protected $table = 'applications';

    protected $guarded = [
        'id',
    ];

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_reference', 'reference_number');
    }

}
