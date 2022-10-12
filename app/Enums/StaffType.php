<?php 

namespace App\Enums;

enum StaffType:int
{
    case ADMIN = 1;
    case SUPERVISOR = 2;
    case STAFF = 3;
}