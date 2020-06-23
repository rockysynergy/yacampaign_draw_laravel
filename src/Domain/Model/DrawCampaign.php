<?php

namespace Orqlog\YacampaignDraw\Domain\Model;

use Orqlog\Yacampaign\Domain\Model\Impl\AbstractCampaign;

class DrawCampaign extends AbstractCampaign
{
    /**
     * @param string
     */
    protected $title;

    /**
     * @param string
     */
    protected $description;

    public function getTitle() :string
    {
        return $this->title;
    }

    public function setTitle(string $title) :void
    {
        $this->title = $title;
    }

    public function getDescription() :string
    {
        return $this->description;
    }

    public function setDescription(string $description) :void
    {
        $this->description = $description;
    }
}
