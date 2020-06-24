<?php

namespace Orqlog\YacampaignDraw\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Orqlog\YacampaignDraw\Models\DrawCampaignRepository;

class ModuleServiceProvider extends BaseModuleServiceProvider
{

    protected $models = [
        DrawCampaignRepository::class,
    ];
}
