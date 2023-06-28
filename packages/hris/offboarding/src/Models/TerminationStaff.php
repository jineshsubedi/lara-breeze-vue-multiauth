<?php

namespace Hris\Offboarding\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminationStaff extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'user_id', 'termination_type','termination_detail', 'start_date', 'end_date', 'justification_detail', 'justification_date', 'status', 'terminate_by', 'offBoarding_date');

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function type()
    {
        return $this->belongsTo(TerminationType::class, 'termination_type');
    }
    public function terminteby()
    {
        return $this->belongsTo(User::class, 'terminate_by');
    }
}
