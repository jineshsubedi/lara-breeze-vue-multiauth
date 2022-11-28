<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = array('title', 'days', 'apply_before', 'eligible', 'continuous', 'accrual', 'accrual_basis', 'branch_id');

    protected $table = 'leave_types';

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
