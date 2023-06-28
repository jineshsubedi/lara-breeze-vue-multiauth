<?php

namespace Hris\Travel\Observers;

use Hris\Travel\Models\TravelExpense;

class TravelExpenseObserver
{
    public function creating(TravelExpense $travelExpense)
    {
        $travelExpense->date = Date('Y-m-d');
        $travelExpense->total = $travelExpense->ticket + $travelExpense->lodging + $travelExpense->breakfast + $travelExpense->lunch + $travelExpense->dinner + $travelExpense->phone + $travelExpense->local_conveyance + $travelExpense->others;
    }
    /**
     * Handle the TravelExpense "created" event.
     *
     * @param  \App\Models\TravelExpense  $travelExpense
     * @return void
     */
    public function created(TravelExpense $travelExpense)
    {
        //
    }

    /**
     * Handle the TravelExpense "updated" event.
     *
     * @param  \App\Models\TravelExpense  $travelExpense
     * @return void
     */
    public function updated(TravelExpense $travelExpense)
    {
        //
    }

    /**
     * Handle the TravelExpense "deleted" event.
     *
     * @param  \App\Models\TravelExpense  $travelExpense
     * @return void
     */
    public function deleted(TravelExpense $travelExpense)
    {
        //
    }

    /**
     * Handle the TravelExpense "restored" event.
     *
     * @param  \App\Models\TravelExpense  $travelExpense
     * @return void
     */
    public function restored(TravelExpense $travelExpense)
    {
        //
    }

    /**
     * Handle the TravelExpense "force deleted" event.
     *
     * @param  \App\Models\TravelExpense  $travelExpense
     * @return void
     */
    public function forceDeleted(TravelExpense $travelExpense)
    {
        //
    }
}
