<?php

namespace App\Models;

use Carbon\Carbon;
use App\Library\Imagetool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id', 'user_id', 'leave_type_id', 'type', 'compensation', 'start_date', 's_approve', 'h_approve', 'm_approve', 'end_date', 'duration', 'description', 'contact_no', 'maximum_leave', 's_remarks', 'm_remarks', 'h_remarks', 'paid', 'emergency', 'document'];

    CONST LEAVE_NATURE_FULL = 1;
    CONST LEAVE_NATURE_HALF = 2;
    CONST LEAVE_NATURE_QUARTER = 3;

    CONST PAID_LEAVE = 1;
    CONST UNPAID_LEAVE = 0;

    protected $appends = ['request_date', 'status'];

    public static function getLeaveNatures()
    {
        return [
            'Full Day' => self::LEAVE_NATURE_FULL,
            'Half Day' => self::LEAVE_NATURE_HALF,
            'Quarter Day' => self::LEAVE_NATURE_QUARTER
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class,'leave_type_id');
    }

    public function requestDate(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->created_at)->format('d F, Y h:i a'), 
        );
    }
    public function status(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatus(), 
        );
    }
    public function getStatus()
    {
        $setting = LeaveSetting::where('branch_id', auth()->user()->branch_id)->first();
        if(!isset($setting->id))
        {
            return '<span class="badge bg-success">Approved</span>';
        }
        if($setting->s_approval == 1 && $this->s_approve == 0)
        {
            return '<span class="badge bg-secondary">Supervisor Approval Required</span>';
        }
        if($this->s_approve == 2 && $this->h_approve == 0)
        {
            return '<span class="badge bg-danger">Supervisor Rejected</span>';
        }
        if($setting->h_approval == 1 && $this->h_approve == 0)
        {
            return '<span class="badge bg-secondary">HR Approval Required</span>';
        }
        if($this->s_approve == 1 && $this->h_approve == 2 && $this->m_approve == 0)
        {
            return '<span class="badge bg-danger">HR Rejected</span>';
        }
        if($setting->m_approval == 1 && $this->m_approve == 0)
        {
            return '<span class="badge bg-secondary">Manager Approval Required</span>';
        }
        if($this->s_approve == 1 && $this->h_approve == 1 && $this->m_approve == 2)
        {
            return '<span class="badge bg-danger">Manager Rejected</span>';
        }
        return '<span class="badge bg-success">Approved</span>';
    }

    public function getDocumentPathAttribute()
    {
        $url = '';
        if(!empty($this->document))
        {
            if (Storage::exists($this->document))
            {
                $url = Imagetool::mycrop($this->document, 300, 300);
            }
        }
        return $url;
    }
    public static function getTypeLabel($type)
    {
        $label = '';
        switch ($type) {
            case 1:
                $label = 'Full';
                break;
            case 2:
                $label = 'Half';
                break;
            case 3:
                $label = 'Quarter';
                break;
            default:
                $label = '';
                break;
        }
        return $label;
    }
}
