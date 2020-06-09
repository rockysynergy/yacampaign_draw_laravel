<?php

namespace Orqlog\YacampaignDraw\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Orqlog\YacampaignDraw\Contracts\DrawCampaign as DrawCampaignContract;
use Orqlog\YacampaignDraw\Models\DrawCampaign;


class ModuleServiceProvider extends BaseModuleServiceProvider
{

    protected $models = [
        DrawCampaign::class,
    ];
}
