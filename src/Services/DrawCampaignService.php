<?php

namespace Orqlog\YacampaignDraw\Services;

use Orqlog\YacampaignDraw\Models\DrawCampaignRepository;

class DrawCampaignService
{

    /**
     * Create the campaign
     */
    public function createCampaign(array $data) :void
    {
        $drawCampaignRepository = new DrawCampaignRepository();
        $drawCampaign = $drawCampaignRepository->makeCampaign($data);
        $drawCampaignRepository->add($drawCampaign);
    }
}
