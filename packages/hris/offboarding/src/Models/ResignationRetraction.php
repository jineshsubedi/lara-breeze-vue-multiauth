<?php

namespace Hris\Offboarding\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResignationRetraction extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'user_id', 'resignation_staffs_id', 'retraction_reason', 'description', 'work_commitment', 'hr_approval', 'hr_remark');

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function retractionReason(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->reasonTitle($value) 
        );
    }
    public function reasonTitle($value)
    {
        $answers = config('offboardConstant.retraction_status');
        $key = array_search($value, array_column($answers, 'value'));
        return $answers[$key]['title'];
    }
    
}
