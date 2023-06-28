<?php
namespace App\Enums;

enum StatusEnum:string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case REJECTED = 'reject';
    case INACTIVE = 'inactive';
}