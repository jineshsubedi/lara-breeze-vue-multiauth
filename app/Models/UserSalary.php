<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'base_salary',
        'basic_salary',
        'ta',
        'da',
        'ca',
        'daily_al',
        'fa',
        'ma',
        'pa',
        'incentive',
        'pf',
        'ot',
        'cit',
        'insurance',
        'petty_cash',
        'advance',
        'others',
        'total_salary',
        'salary_date',
    ];
}
