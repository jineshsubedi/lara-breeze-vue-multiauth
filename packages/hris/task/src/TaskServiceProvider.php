<?php

namespace Hris\Task;

use Hris\Task\Models\Task;
use Hris\Task\Models\HelpDesk;
use Hris\Task\Observers\TaskObserver;
use Illuminate\Support\ServiceProvider;
use Hris\Task\Observers\HelpDeskObserver;

class TaskServiceProvider extends ServiceProvider
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

        $this->mergeConfigFrom(
            __DIR__.'/config/constant.php', 'taskConstant'
        );
        $this->publishes([
            __DIR__.'/config/taskConstant.php' => config_path('taskConstant.php'),
        ]);

        Task::observe(TaskObserver::class);
        HelpDesk::observe(HelpDeskObserver::class);
    }
}
