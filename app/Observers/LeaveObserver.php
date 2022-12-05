<?php

namespace App\Observers;

use App\Models\CompensatoryOff;
use App\Models\Leave;
use App\Models\LeaveSetting;
use Illuminate\Support\Facades\Storage;

class LeaveObserver
{
    protected $disk = 'public';
    protected $path = 'leave_documents';

    public function creating(Leave $leave)
    {
        $doc = '';
        if (request()->hasFile('documentFile')) {
            $doc = request()->file('documentFile')->store($this->path, $this->disk);
        }
        $leave->document = $doc;
        $leave->user_id = auth()->id();
        $leave->branch_id = auth()->user()->branch_id;
        if(request()->accrual == 0)
        {
            $leave->paid = '1';
        }
        if(request()->remaining == 0 || request()->join_duration < request()->eligible)
        {
            $leave->paid = '1';
        }
    }
    /**
     * Handle the Leave "created" event.
     *
     * @param  \App\Models\Leave  $leave
     * @return void
     */
    public function created(Leave $leave)
    {
        //
    }

    /**
     * Handle the Leave "updated" event.
     *
     * @param  \App\Models\Leave  $leave
     * @return void
     */
    public function updated(Leave $leave)
    {
        //
    }

    /**
     * Handle the Leave "deleted" event.
     *
     * @param  \App\Models\Leave  $leave
     * @return void
     */
    public function deleted(Leave $leave)
    {
        if(Storage::exists($leave->document))
        {
            Storage::delete($leave->document);
        }
    }

    /**
     * Handle the Leave "restored" event.
     *
     * @param  \App\Models\Leave  $leave
     * @return void
     */
    public function restored(Leave $leave)
    {
        //
    }

    /**
     * Handle the Leave "force deleted" event.
     *
     * @param  \App\Models\Leave  $leave
     * @return void
     */
    public function forceDeleted(Leave $leave)
    {
        //
    }
}
