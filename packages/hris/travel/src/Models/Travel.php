<?php

namespace Hris\Travel\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'unique_id', 'from', 'to', 'assigned_to', 'assigned_from', 'purpose', 'type', 'status', 'assignment_type', 'assignment_category', 'mode_of_transport', 'payment_mode', 'road_sub', 'reimbursement', 'position', 'grade', 'per_diem_amount', 'account_name', 'account_number', 'bank_name', 'advance_required', 'supervisor_approval', 'supervisor_remark', 'hr_approval', 'hr_remark', 'chairman_approval', 'chairman_remark', 'account_approval', 'account_remark', 'supervisor_expense_approval', 'supervisor_expense_remark', 'account_expense_approval', 'account_expense_remark', 'hr_expense_approval', 'hr_expense_remark', 'chairman_expense_approval', 'chairman_expense_remark', 'accept_status');

    protected $appends = ['supervisor_action', 'account_action', 'hr_action', 'chairman_action'];

    public function assign_from()
    {
        return $this->belongsTo(User::class, 'assigned_from');
    }
    public function assign_to()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function assign_type()
    {
        return $this->belongsTo(AssignmentType::class, 'assignment_type');
    }
    public function assign_category()
    {
        return $this->belongsTo(AssignmentCategory::class, 'assignment_category');
    }

    public function destination()
    {
        return $this->hasMany(TravelDestination::class, 'travel_id');
    }
    public function reply()
    {
        return $this->hasMany(TravelReply::class, 'travel_id');
    }
    public function roadSub(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? $this->getConstantLabel($value, config('travelConstant.road_sub')) : ''
        );
    }
    public function paymentMode(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? $this->getConstantLabel($value, config('travelConstant.payment_mode')) : ''
        );
    }
    public function reimbursement(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? $this->getConstantLabel($value, config('travelConstant.reimbursement')) : ''
        );
    }
    public function position(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? $this->getConstantLabel($value, config('travelConstant.level')) : ''
        );
    }
    public function grade(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? $this->getConstantLabel($value, config('travelConstant.grade')) : ''
        );
    }

    public static function getConstantLabel($value, $answers)
    {
        $key = array_search($value, array_column($answers, 'value'));
        return $answers[$key]['title'];
    }

    public function supervisorAction(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatusLabel(0, $this->supervisor_approval)
        );
    }
    public function accountAction(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatusLabel($this->supervisor_approval, $this->account_approval)
        );
    }
    public function hrAction(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatusLabel($this->account_approval, $this->hr_approval)
        );
    }
    public function chairmanAction(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatusLabel($this->hr_approval, $this->chairman_approval)
        );
    }
    private function getStatusLabel($prev, $value)
    {
        if($prev == 2)
            return '<span class="badge bg-danger">Rejected</span>';
        if($value == 0)
            return '<span class="badge bg-secondary">Pending</span>';
        if($value == 1)
            return '<span class="badge bg-success">Approved</span>';
        if($value == 2)
            return '<span class="badge bg-danger">Rejected</span>';

        return '';
    }
}
