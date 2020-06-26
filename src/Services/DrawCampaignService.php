<?php

namespace Orqlog\YacampaignDraw\Services;

use Orqlog\YacampaignDraw\Contracts\DrawCampaignRepository;

class DrawCampaignService
{

    /**
     * Create the campaign
     */
    public function createCampaign(array $data) :void
    {
        $drawCampaignRepository = app()->make(DrawCampaignRepository::class);
        $drawCampaign = $drawCampaignRepository->makeCampaign($data);
        $drawCampaignRepository->add($drawCampaign);
    }
}
