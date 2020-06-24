<?php

namespace Orqlog\YacampaignDraw\Models;

use Illuminate\Database\Eloquent\Model;
use Orqlog\YacampaignDraw\Contracts\DrawCampaignRepositoryContract;
use Orqlog\YacampaignDraw\Domain\Model\DrawCampaign as DrawCampaignModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orqlog\Yacampaign\Domain\Model\CampaignInterface;
use Orqlog\YacampaignDraw\Domain\Model\DrawCampaignValidator;

class DrawCampaignRepository extends Model implements DrawCampaignRepositoryContract
{

    use SoftDeletes;
    protected $table = 'ya_drawcampaigns'; // The corresponding table name

    public function getStartAtAttribute() :?\DateTime
    {
        if (isset($this->start_at)) {
            return new \DateTime(date('Y-m-d H:i:s', $this->start_at));
        }
        return null;
    }

    public function setStartAtAttribute($value) :void
    {
        if (!is_null($value)) {
            $this->attributes['start_at'] = strtotime($value->format('Y-m-d H:i:s'));
        }
    }

    public function getEndAtAttribute() :?\DateTime
    {
        if (isset($this->end_at)) {
            return new \DateTime(date('Y-m-d H:i:s', $this->end_at));
        }
        return null;
    }

    public function setEndAtAttribute($value) :void
    {
        if (!is_null($value)) {
            $this->attributes['end_at'] = strtotime($value->format('Y-m-d H:i:s'));
        }
    }

    /**
     * Persist the campaign
     */
    public function add(DrawCampaignModel $drawCampaign): DrawCampaignModel
    {
        $tId = $drawCampaign->getId();
        $fItem = $this->find($tId);

        if (is_int($tId) && !is_null($fItem)) {
            // update existing record
            $item = $this->makeItem($drawCampaign, $fItem);
        } else {
            // insert new onw
            $item = $this->makeItem($drawCampaign);
        }
        $item->save();

        $drawCampaign->setId($item->id);
        return $drawCampaign;
    }

    public function findById(int $id) :CampaignInterface
    {
        $item = $this->find($id);
        return $this->makeCampaign(json_decode(json_encode($item), true));
    }

    /**
     * Constitute Draw campaign from raw data
     */
    public function makeCampaign(array $data) : CampaignInterface
    {
        $drawCampaign = new DrawCampaignModel();
        if (is_array($data)) $data = (Object) $data;

        if (isset($data->id)) $drawCampaign->setId($data->id);
        if (isset($data->start_at)) $drawCampaign->setStartAt(new \DateTime($data->start_at));
        if (isset($data->end_at)) $drawCampaign->setEndat(new \DateTime($data->end_at));
        if (isset($data->title)) $drawCampaign->setTitle($data->title);
        if (isset($data->description)) $drawCampaign->setDescription($data->description);

        $validator = new DrawCampaignValidator();
        $validator->validate($drawCampaign);
        return $drawCampaign;
    }

    /**
     * Convert from DrawCampaign to data format
     */
    protected function makeItem(DrawCampaignModel $drawCampaign, $item = null) : Object
    {
        $item = is_null($item) ? new self() : $item;

        $item->end_at = $drawCampaign->getEndAt();
        $item->start_at = $drawCampaign->getStartAt();
        $item->title = $drawCampaign->getTitle();
        $item->description = $drawCampaign->getDescription();

        return $item;
    }

    function attachPrize(int $campaignId, int $prizeId) :void
    {

    }

    public function detachPrize(int $campaignId, int $prizeId) :void
    {

    }

    public function attachQualifyPolicy(int $campaignId, int $qualifyPolicyId) :void
    {

    }

    public function detachQualifyPolicy(int $campaignId, int $qualifyPolicyId) :void
    {

    }
}
