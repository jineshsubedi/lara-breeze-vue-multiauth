<?php

namespace Hris\Booking;

use Hris\Booking\Models\Booking;
use Hris\Booking\Observers\BookingObserver;
use Illuminate\Support\ServiceProvider;

class BookingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        Booking::observe(BookingObserver::class);
    }
}
