<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

class AppServiceProvider extends ServiceProvider
{

    public function register() {
        $this->app->bind('App\Http\Repositories\UserInfoExportRepositoryInterface', 'App\Http\Repositories\UserInfoExportRepository');
    }

    public function boot() {
        RateLimiter::for('exports', function($job) {
            return Limit::perMinute(2)->by($job->user->id);
        });
    }
}
