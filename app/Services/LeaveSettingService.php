<?php

namespace App\Services;

use App\Models\Leave;
use App\Models\LeaveSetting;
use App\Models\User;
use Carbon\Carbon;


class LeaveSettingService
{
    protected $model;

    public function __construct(LeaveSetting $model)
    {
        $this->model = $model;
    }

    public function getApprovalPersons($branchId)
    {
        $setting = $this->getSettingByBranch($branchId, ['s_approval', 'h_approval', 'm_approval', 'hr_person', 'm_person', 'accrual_basis', 'handover'])->toArray();

        return $setting;
        // return array_filter($setting, function($val) {
        // 	return $val != 0;
        // });
    }

    public function getSettingByBranch($branchId, $cols = ['*'])
    {
        return $this->model
            ->first($cols);
    }

    public function canDeleteLeaveRequest($leaveRequest): bool
    {
        $timeLimit = Carbon::createFromFormat('H:i a', '10:00 AM');

        if ($leaveRequest->start_date <= Carbon::now() && Carbon::now() < $timeLimit) {

            return true;
        } elseif ($leaveRequest->start_date >= Carbon::now()) {

            return true;
        }

        return false;
    }

    public function getAllowedLeaveNatures($branchId)
    {
        $setting = $this->getSettingByBranch($branchId, ['quarter_day', 'half_day']);


        $data[] = ['value' => Leave::LEAVE_NATURE_FULL, 'title' => 'Full Day'];

        if ($setting->half_day) {
            $data[] = ['value' => Leave::LEAVE_NATURE_HALF, 'title' => 'Half Day'];
        }

        if ($setting->quarter_day) {
            $data[] = ['value' => Leave::LEAVE_NATURE_QUARTER, 'title' => 'Quarter Day'];
        }

        return $data;
    }
    public function getCountApprovalList($branchId)
    {
        $setting = $this->getApprovalPersons($branchId);
        $subordinate = User::active()->where('branch_id', auth()->user()->branch_id)->where('supervisor_id', auth()->id())->pluck('id');
        return [
            's_count' => $setting['s_approval'] == 1 ? Leave::where('branch_id', $branchId)->whereIn('user_id', $subordinate)->where('s_approve', '0')->count() : 0,
            'h_count' => $setting['h_approval'] == 1 ? Leave::where('branch_id', $branchId)->where('s_approve', '1')->where('h_approve', '0')->count() : 0,
            'm_count' => $setting['m_approval'] == 1 ?  Leave::where('branch_id', $branchId)->where('h_approve', '1')->where('m_approve', '0')->count() : 0,
        ];
    }
}
