<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveSetting extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id', 'quarter_day', 'half_day', 'sandwich', 'handover', 's_approval', 'h_approval', 'm_approval', 'accural_basis', 'hr_person', 'm_person', 'leave_handler', 'maximum_leave'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function hr()
    {
        return $this->belongsTo(User::class, 'hr_person');
    }
    public function handler()
    {
        return $this->belongsTo(User::class, 'leave_handler');
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'm_person');
    }
    public function scopeBranchSetting($query)
    {
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('branch_id', auth()->user()->branch_id);
        }
        return $query;
    }
}
