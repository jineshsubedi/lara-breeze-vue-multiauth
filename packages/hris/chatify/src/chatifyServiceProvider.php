<?php

namespace Hris\Chatify;

use Illuminate\Support\ServiceProvider;

class ChatifyServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        // controller 
        $this->publishes([
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers/vendor/Chatify')
        ], 'chatify-controllers');
        // views 
        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/Chatify')
        ], 'chatify-views');
    }
}
