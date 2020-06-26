<?php

namespace Orqlog\YacampaignDraw\Providers;

use Illuminate\Support\ServiceProvider;
use Orqlog\YacampaignDraw\Contracts\DrawCampaignRepository as DrawCampainRepositoryContract;
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
        $this->loadRoutesFrom(__DIR__ . '/../../tests/Functional/Controller/route_api.php');
    }

    public function register()
    {
        $this->app->bind(DrawCampainRepositoryContract::class, DrawCampaignRepository::class);
    }
}

