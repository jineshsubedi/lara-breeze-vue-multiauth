<?php

namespace Hris\Attendance\Observers;

use App\Models\User;
use Hris\Attendance\Models\Attendance;
use Illuminate\Support\Facades\Notification;
use Hris\Attendance\Notifications\AttendanceNotification;

class AttendanceObserver
{
    /**
     * Handle the Attendance "created" event.
     *
     * @param  Hris\Attendance\Models\Attendance  $attendance
     * @return void
     */
    public function created(Attendance $attendance)
    {
        $attendance->load(['user:id,name,staff_type']);
        $this->attendanceNotification($attendance);
    }

    /**
     * Handle the Attendance "updated" event.
     *
     * @param  Hris\Attendance\Models\Attendance  $attendance
     * @return void
     */
    public function updated(Attendance $attendance)
    {
        $attendance->load(['user:id,name,staff_type']);
        $this->attendanceNotification($attendance);
    }

    /**
     * Handle the Attendance "deleted" event.
     *
     * @param  Hris\Attendance\Models\Attendance  $attendance
     * @return void
     */
    public function deleted(Attendance $attendance)
    {
        //
    }

    /**
     * Handle the Attendance "restored" event.
     *
     * @param  Hris\Attendance\Models\Attendance  $attendance
     * @return void
     */
    public function restored(Attendance $attendance)
    {
        //
    }

    /**
     * Handle the Attendance "force deleted" event.
     *
     * @param  Hris\Attendance\Models\Attendance  $attendance
     * @return void
     */
    public function forceDeleted(Attendance $attendance)
    {
        //
    }
    private function attendanceNotification($attendance)
    {
        $shift = auth()->user()->shiftTime;
        if(!isset($shift->id))
        {
            return '';
        }
        $link = $this->staffUrl($attendance->user, $attendance->id);
        if($attendance->isDirty('in_time')){
            if($shift->start_time <= $attendance->in_time)
            {
                $message = $attendance->user->name.', Your Attendance Clock In Time Is Late. Click here to fill Late Clock In Reason.';
                Notification::send($attendance->user, new AttendanceNotification($attendance, $message, $link));
            }
            if($attendance->generateDistance($attendance->in_location))
            {
                $message = $attendance->user->name.', Your Attendance Clock In Location Is Away. Click here to fill Away Clock In Reason.';
                Notification::send($attendance->user, new AttendanceNotification($attendance, $message, $link));
            }
        }
        if($attendance->isDirty('out_time')){
            if($shift->end_time >= $attendance->out_time)
            {
                $message = $attendance->user->name.', Your Attendance Clock Out Time Is Early. Click here to fill Early Clock Out Reason.';
                Notification::send($attendance->user, new AttendanceNotification($attendance, $message, $link));
            }
            if($attendance->generateDistance($attendance->out_location))
            {
                $message = $attendance->user->name.', Your Attendance Clock Out Location Is Away. Click here to fill Away Clock Out Reason.';
                Notification::send($attendance->user, new AttendanceNotification($attendance, $message, $link));
            }
        }
    }

    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.attendances.show', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.attendances.show', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.attendances.show', $id);
        }
    }
}
