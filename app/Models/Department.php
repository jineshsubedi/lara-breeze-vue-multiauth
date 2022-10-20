<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'minimum_leave', 'maximum_leave', 'department_head'];

    public function user()
    {
        return $this->belongsTo(User::class, 'department_head');
    }
}
