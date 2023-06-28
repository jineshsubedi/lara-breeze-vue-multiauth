<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'branch_id', 'minimum_leave', 'maximum_leave', 'department_head'];

    public function user()
    {
        return $this->belongsTo(User::class, 'department_head');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function scopeBranchList($query)
    {
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->whereBranchId(auth()->user()->branch_id);
        }
        return $query;
    }
}
