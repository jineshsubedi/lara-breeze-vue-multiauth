<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Leave;
use App\Models\Branch;
use App\Models\FiscalYear;
use App\Models\LeaveHandover;
use App\Models\Notice;
use App\Observers\NoticeObserver;
use App\Observers\UserObserver;
use App\Observers\LeaveObserver;
use App\Observers\BranchObserver;
use App\Observers\FiscalYearObserver;
use App\Observers\LeaveHandoverObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Leave::observe(LeaveObserver::class);
        Notice::observe(NoticeObserver::class);
        Branch::observe(BranchObserver::class);
        FiscalYear::observe(FiscalYearObserver::class);
        LeaveHandover::observe(LeaveHandoverObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
