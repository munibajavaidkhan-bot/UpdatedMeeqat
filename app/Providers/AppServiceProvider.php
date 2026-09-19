<?php

namespace App\Providers;

use App\Services\ChadarSizeService;
use App\Services\DistanceCalculatorService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ChadarSizeService::class, function () {
            return new ChadarSizeService();
        });

        $this->app->singleton(DistanceCalculatorService::class, function () {
            return new DistanceCalculatorService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
