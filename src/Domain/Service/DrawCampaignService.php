<?php

namespace Orqlog\YacampaignDrawLaravel\Domain\Service;

use Orqlog\Yacampaign\Domain\Service\CampaignService;
use Orqlog\YacampaignDrawLaravel\Contracts\DrawCampaignRepositoryContract;
use Orqlog\YacampaignDrawLaravel\Domain\Repository\DrawCampaignRepository;

class DrawCampaignService extends CampaignService {

    /**
     * Create or update the campaign
     */
    public function saveCampaign(array $data) :void
    {
        $drawCampaignRepository = app()->make(DrawCampaignRepositoryContract::class);
        $drawCampaign = $drawCampaignRepository->makeCampaign($data);
        $drawCampaignRepository->add($drawCampaign);
    }

    /**
     * Decide prize
     */
    public function decidePrize(int $userId, int $campaignId): array
    {
        return [];
    }
    
}
