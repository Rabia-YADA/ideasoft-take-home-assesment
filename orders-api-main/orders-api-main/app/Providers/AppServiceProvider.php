<?php

namespace App\Providers;

use App\Repositories\DiscountRuleRepository;
use App\Services\Discount\DiscountCalculator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(DiscountCalculator::class, function ($app) {
            return new DiscountCalculator(
                $app->make(DiscountRuleRepository::class)
            );
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
