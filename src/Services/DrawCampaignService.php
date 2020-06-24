<?php

namespace Orqlog\YacampaignDraw\Services;

use Orqlog\YacampaignDraw\Contracts\DrawCampaignRepositoryContract;

class DrawCampaignService
{

    /**
     * Create the campaign
     */
    public function createCampaign(array $data) :void
    {
        $drawCampaignRepository = app()->make(DrawCampaignRepositoryContract::class);
        $drawCampaign = $drawCampaignRepository->makeCampaign($data);
        $drawCampaignRepository->add($drawCampaign);
    }
}
