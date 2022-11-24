<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAllowance extends Model
{
    use HasFactory;

    protected $fillable = ['user_salary_id','title','amount','type'];
}
