<?php

namespace Orqlog\YacampaignDraw\Providers;

use Konekt\Concord\BaseBoxServiceProvider;
use Orqlog\YacampaignDraw\Models\DrawCampaignRepository;

class ModuleServiceProvider extends BaseBoxServiceProvider
{

    protected $models = [
        DrawCampaignRepository::class,
    ];
}
