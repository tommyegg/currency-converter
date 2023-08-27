<?php

namespace App\Providers;

use App\Repositories\ExchangeRateRepository;
use App\Repositories\Interface\ExchangeRateInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ExchangeRateInterface::class,
            ExchangeRateRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
