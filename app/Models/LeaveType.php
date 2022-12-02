<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = array('title', 'days', 'apply_before', 'eligible', 'continuous', 'accrual', 'accrual_basis', 'branch_id','is_extra');

    protected $table = 'leave_types';

    CONST FILE_FIELD = 1;
    CONST DATE_FIELD = 0;

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
