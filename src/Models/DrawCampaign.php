<?php

namespace Orqlog\YacampaignDraw\Models;

use Illuminate\Database\Eloquent\Model;
use Orqlog\YacampaignDraw\Contracts\DrawCampaignRepository;
use Orqlog\YacampaignDraw\Domain\Model\DrawCampaign as DrawCampaignModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orqlog\YacampaignDraw\Domain\Model\DrawCampaignValidator;

// class DrawCampaign extends Model implements DrawCampaignRepository
class DrawCampaign extends Model
{

    use SoftDeletes;
    protected $table = 'ya_drawcampaigns'; // The corresponding table name

    public function add(DrawCampaignModel $drawCampaign): void
    {
        $item = $this->makeItem($drawCampaign);
        $item->save();
    }

    public function findById(int $id) :DrawCampaignModel
    {
        $item = $this->find($id);
        $item->prizes = $this->prizes()->pluck('id');

        return $this->makeDrawCampaign($item);
    }

    /**
     * Constitute Draw campaign from raw data
     */
    public function makeCampaign(array $data) : DrawCampaignModel
    {
        $drawCampaign = new DrawCampaignModel();
        if (is_array($data)) $data = (Object) $data;

        if (isset($data->id)) $drawCampaign->setIdentifier($data->id);
        if (isset($data->start_at)) $drawCampaign->setStartAt(new \DateTime($data->start_at));
        if (isset($data->expire_at)) $drawCampaign->setExpireAt(new \DateTime($data->expire_at));
        if (isset($data->title)) $drawCampaign->setTitle($data->title);
        if (isset($data->description)) $drawCampaign->setDescription($data->description);

        $validator = new DrawCampaignValidator();
        $validator->validate($drawCampaign);
        return $drawCampaign;
    }

    /**
     * Convert from DrawCampaign to data format
     */
    protected function makeItem(DrawCampaignModel $drawCampaign) : Object
    {
        $item = new self();
        $item->expire_at = $drawCampaign->getExpireAt();
        $item->start_at = $drawCampaign->getStartAt();
        $item->title = $drawCampaign->getTitle();
        $item->description = $drawCampaign->getDescription();

        return $item;
    }
}
