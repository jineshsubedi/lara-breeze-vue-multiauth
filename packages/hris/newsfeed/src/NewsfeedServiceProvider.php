<?php

namespace Hris\Newsfeed;

use Hris\Newsfeed\Models\Newsfeed;
use Hris\Newsfeed\Models\NewsfeedComment;
use Hris\Newsfeed\Models\NewsfeedLike;
use Hris\Newsfeed\Observers\NewsfeedCommentObserver;
use Hris\Newsfeed\Observers\NewsfeedLikeObserver;
use Hris\Newsfeed\Observers\NewsfeedObserver;
use Illuminate\Support\ServiceProvider;

class NewsfeedServiceProvider extends ServiceProvider
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
            __DIR__.'/config/Constant.php', 'newsfeedConstant'
        );
        Newsfeed::observe(NewsfeedObserver::class);
        NewsfeedLike::observe(NewsfeedLikeObserver::class);
        NewsfeedComment::observe(NewsfeedCommentObserver::class);
    }
}
