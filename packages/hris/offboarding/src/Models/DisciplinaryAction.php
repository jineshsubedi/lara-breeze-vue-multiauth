<?php

namespace Hris\Offboarding\Models;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaryAction extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'user_id', 'disciplinary_ground_id', 'issued_by', 'issued_date', 'previous_action', 'action', 'justification_required', 'justification_description', 'justification_deadline', 'justification_date', 'description', 'suspension', 'penalty', 'suspension_days', 'penalty_charge', 'termination');

    protected $appends = ['status', 'previous'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function isseudby()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function grounds()
    {
        return $this->belongsTo(DisciplinaryGround::class, 'disciplinary_ground_id');
    }

    public function status():Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatus($this->action)
        );
    }
    public function previous():Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatus($this->previous_action)
        );
    }
    private function getStatus($value)
    {
        if($value == 1)
            return '<span class="badge bg-warning">1st Warning</span>';
        if($value == 2)
            return '<span class="badge bg-warning">2nd Warning</span>';
        if($value == 3)
            return '<span class="badge bg-warning">3rd Warning</span>';
        return '';
    }
}
