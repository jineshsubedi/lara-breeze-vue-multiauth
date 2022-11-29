<?php

namespace App\Services;

use App\Models\Leave;
use App\Models\LeaveSetting;

class LeaveSettingService
{

    protected $model;

	public function __construct(LeaveSetting $model)
	{
		$this->model = $model;
	}
    public function getApprovalPersons($branchId)
	{
		$setting = $this->getSettingByBranch($branchId,['s_approval','h_approval','m_approval', 'hr_person', 'm_person'])->toArray();
        return $setting;
	}

	public function getSettingByBranch($branchId,$cols = ['*'])
	{
		return $this->model->where('branch_id', $branchId)->first($cols);
	}

    public function getCountApprovalList($branchId)
    {
        $setting = $this->getApprovalPersons($branchId);
        $leave = new Leave();
        $leave = $leave->where('branch_id', $branchId);
        return [
            's_count' => $setting['s_approval'] == 1 ? $leave->where('s_approve', 0)->count() : 0,
            'h_count' => $setting['h_approval'] == 1 ? $leave->where('h_approve', 0)->count() : 0,
            'm_count' => $setting['m_approval'] == 1 ?  $leave->where('m_approve', 0)->count(): 0,
        ];
    }

}