<?php

namespace App\Enums;
use App\Traits\EnumOptions;

enum VacancyTypeEnum: String
{
    use EnumOptions;
    // Defining the allowed values for a vacancy type
    case FullTime = 'Full-Time';
    case PartTime = 'Part-Time';
    case Contract = 'Contract';
    case Temporary = 'Temporary';
    case Internship = 'Internship';
}
