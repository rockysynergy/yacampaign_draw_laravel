<?php

namespace Orqlog\YacampaignDrawLaravel\Providers;

use Illuminate\Support\ServiceProvider;
use Orqlog\YacampaignDrawLaravel\Contracts\DrawCampaignRepositoryContract;
use Orqlog\YacampaignDrawLaravel\Domain\Repository\DrawCampaignRepository;

class DrawCampaignServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../resources/routes/api.php');
    }

    public function register()
    {
        $this->app->bind(DrawCampaignRepositoryContract::class, DrawCampaignRepository::class);
    }
}

