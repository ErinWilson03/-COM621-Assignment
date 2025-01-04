<?php

namespace App\Enums;
use App\Traits\EnumOptions;

enum LocationEnum: String
{
    use EnumOptions;   
    // Allowed values for the location field of a vacancy
    case Remote = 'Remote';
    case InOffice = 'In Office';
    case Hybrid = 'Hybrid';
}
