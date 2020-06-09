<?php

namespace Orqlog\YacampaignDraw\Models;

use Illuminate\Database\Eloquent\Model;
use Orqlog\YacampaignDraw\Contracts\DrawCampaignRepository as ContractsDrawCampaignRepository;
use Orqlog\YacampaignDraw\Domain\DrawCampaign;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orqlog\YacampaignDraw\Domain\DrawCampaignValidator;

class DrawCampaignRepository extends Model implements ContractsDrawCampaignRepository
{

    use SoftDeletes;
    protected $table = 'wqb_banners'; // The corresponding table name

    public function add(DrawCampaign $drawCampaign): void
    {
        $item = $this->makeItem($drawCampaign);
        $item->save();
    }

    public function findById(int $id) :DrawCampaign
    {
        $item = $this->find($id);
        $item->prizes = $this->prizes()->pluck('id');

        return $this->makeDrawCampaign($item);
    }

    /**
     * Constitute Draw campaign from raw data
     */
    public function makeDrawCampaign($data) : DrawCampaign
    {
        $drawCampaign = new DrawCampaign();
        if (is_array($data)) $data = (Object) $data;

        if (isset($data->start_at)) $drawCampaign->setStartAt(new \DateTime($data->start_at));
        if (isset($data->expire_at)) $drawCampaign->setExpireAt(new \DateTime($data->expire_at));
        if (isset($data->title)) $drawCampaign->setTitle($data->title);
        if (isset($data->description)) $drawCampaign->setDescription($data->description);

        if (isset($data->prizes)) {
            // Constitute the Prize
            $prizeRepository = new PrizeRepository();
            if (is_string($data->prizes)) { $data->prizes = explode(',', $data->prizes); }
            foreach ($data->prizes as $prizeId) {
                $drawCampaign->addPrize($prizeRepository->findById($prizeId));
            }
        }


        $validator = new DrawCampaignValidator();
        $validator->validate($drawCampaign);
        return $drawCampaign;
    }

    /**
     * Convert from DrawCampaign to data format
     */
    protected function makeItem(DrawCampaign $drawCampaign) : Object
    {
        $item = new self();
        $item->expire_at = $drawCampaign->getExpireAt();
        $item->start_at = $drawCampaign->getStartAt();
        $item->title = $drawCampaign->getTitle();
        $item->description = $drawCampaign->getDescription();



        return $item;
    }
}
