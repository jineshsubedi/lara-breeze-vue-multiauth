<?php

namespace App\Services;

use App\Models\Leave;


class LeaveRequestService
{
    protected $model;

    public function __construct(Leave $model)
    {
        $this->model = $model;
    }

    public function countLeaveRequest(
        $userId,
        $leaveTypeId,
        $leaveNature,
        $startDate,
        $endDate,

        //        $paid = '0',
        //        $sApprove = '1',
        //        $hApprove = '1',
        //        $mApprove = '1',

    ) {
        return $this->model
            ->where('user_id', $userId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('type', $leaveNature)
            ->where('paid', '0')
            ->where('s_approve', '1')
            ->where('h_approve', '1')
            ->where('m_approve', '1')
            ->where('start_date', '>=', $startDate)
            ->where('start_date', '<=', $endDate)
            ->sum('duration');
    }

    public function prevLeaveRequest(
        $userId,
        $leaveTypeId,

        //		$paid = '0',
        //		$sApprove = '1',
        //		$hApprove = '1',
        //		$mApprove = '1',

        $lastYear,

    ) {
        return $this->model
            ->where('user_id', $userId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('paid', '0')
            ->where('s_approve', '1')
            ->where('h_approve', '1')
            ->where('m_approve', '1')
            ->where('end_date', '>', $lastYear)
            ->where('start_date', '<=', $lastYear)
            ->first();
    }
}
