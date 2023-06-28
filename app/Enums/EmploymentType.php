<?php 

namespace App\Enums;

enum EmploymentType:string
{
    case FULL = 'Full Time';
    case PART = 'Part Time';
    case CONTRACT = 'Contract';
}