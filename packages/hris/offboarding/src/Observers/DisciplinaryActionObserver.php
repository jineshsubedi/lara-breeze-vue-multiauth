<?php

namespace Hris\Offboarding\Observers;

use App\Enums\StaffType;
use App\Models\User;
use Hris\Offboarding\Models\DisciplinaryAction;
use Hris\Offboarding\Notifications\DisciplinaryActionNotification;
use Illuminate\Support\Facades\Notification;

class DisciplinaryActionObserver
{
    public function creating(DisciplinaryAction $disciplinaryAction)
    {
        $disciplinaryAction->branch_id = auth()->user()->branch_id;
        $disciplinaryAction->issued_by = auth()->id();
    }
    /**
     * Handle the DisciplinaryAction "created" event.
     *
     * @param  \App\Models\DisciplinaryAction  $disciplinaryAction
     * @return void
     */
    public function created(DisciplinaryAction $disciplinaryAction)
    {
        $disciplinaryAction->load(['isseudby:id,name']);
        $user = User::find($disciplinaryAction->user_id);
        $message = $disciplinaryAction->isseudby->name.' Has created a disciplinary action against you.';
        $link = $this->staffUrl($user, $disciplinaryAction->id);
        Notification::send($user, new DisciplinaryActionNotification($disciplinaryAction, $message, $link));
    }

    /**
     * Handle the DisciplinaryAction "updated" event.
     *
     * @param  \App\Models\DisciplinaryAction  $disciplinaryAction
     * @return void
     */
    public function updated(DisciplinaryAction $disciplinaryAction)
    {
        if($disciplinaryAction->isDirty('justification_description'))
        {
            $disciplinaryAction->load(['user:id,name']);
            $user = User::find($disciplinaryAction->issued_by);
            $message = $disciplinaryAction->user->name.' Has submitted justification on disciplinary action.';
            $link = $this->staffUrlMain($user, $disciplinaryAction->id);
            Notification::send($user, new DisciplinaryActionNotification($disciplinaryAction, $message, $link));
        }
    }

    /**
     * Handle the DisciplinaryAction "deleted" event.
     *
     * @param  \App\Models\DisciplinaryAction  $disciplinaryAction
     * @return void
     */
    public function deleted(DisciplinaryAction $disciplinaryAction)
    {
        //
    }

    /**
     * Handle the DisciplinaryAction "restored" event.
     *
     * @param  \App\Models\DisciplinaryAction  $disciplinaryAction
     * @return void
     */
    public function restored(DisciplinaryAction $disciplinaryAction)
    {
        //
    }

    /**
     * Handle the DisciplinaryAction "force deleted" event.
     *
     * @param  \App\Models\DisciplinaryAction  $disciplinaryAction
     * @return void
     */
    public function forceDeleted(DisciplinaryAction $disciplinaryAction)
    {
        //
    }
    private function staffUrlMain($user,$id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.disciplinaryactions.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.disciplinaryactions.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.disciplinaryactions.show', $id);
        }
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.disciplinary.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.disciplinary.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.disciplinary.show', $id);
        }
    }
}
