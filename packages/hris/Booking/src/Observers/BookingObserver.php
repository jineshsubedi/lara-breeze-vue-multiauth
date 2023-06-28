<?php

namespace Hris\Booking\Observers;

use App\Enums\StatusType;
use Hris\Booking\Models\Booking;
use Hris\Booking\Models\BookingStaffs;

class BookingObserver
{
    public function creating(Booking $booking)
    {
        $booking->booked_by = auth()->id();
        $booking->branch_id = auth()->user()->branch_id;
    }
    /**
     * Handle the Booking "created" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function created(Booking $booking)
    {
        $this->updateBookingOwner($booking);
    }

    /**
     * Handle the Booking "updated" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function updated(Booking $booking)
    {
        $this->updateBookingOwner($booking);
    }

    public function updateBookingOwner($booking)
    {
        BookingStaffs::updateOrCreate([
            'booking_id' => $booking->id,
            'staff_id' => $booking->booked_by,
            'status' => StatusType::ACCEPTED->value,
        ]);
    }
    /**
     * Handle the Booking "deleted" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function deleted(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function restored(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function forceDeleted(Booking $booking)
    {
        //
    }
}
