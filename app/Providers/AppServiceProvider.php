<?php

namespace App\Providers;

use App\Models\GameRecords;
use App\Observers\GameRecordsObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        GameRecords::observe(GameRecordsObserver::class);
    }
}
