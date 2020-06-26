<?php

namespace Orqlog\YacampaignDraw\Providers;

use Illuminate\Support\ServiceProvider;
use Orqlog\YacampaignDraw\Contracts\DrawCampaignRepositoryContract;
use Orqlog\YacampaignDraw\Models\DrawCampaignRepository;

class MyServiceProvider extends ServiceProvider
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

