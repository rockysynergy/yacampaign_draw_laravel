<?php

namespace Orqlog\YacampaignDrawLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;
use Orqlog\YacampaignDrawLaravel\Domain\Service\DrawCampaignService;

class DrawCampaignController extends BaseController
{
    public function show($campaignId)
    {
        return response(['data' => [
            'title' => 'ATitle',
            'id' => $campaignId
        ]]);
    }

    public function create(Request $request, DrawCampaignService $drawCampaignService)
    {
        try {
            $drawCampaignService->saveCampaign($request->input());
            return response(['status' => 1, 'data' => []]);
        } catch (\Exception $e) {
            Log::debug($e->message . ' ' . $e->getTraceAsString());
            return response(['status' => 0, 'data' => []]);
        }
    }

    public function update($campaignId, Request $request, DrawCampaignService $drawCampaignService)
    {
        try {
            $data = $request->input();
            $data['id'] = $campaignId;
            $drawCampaignService->saveCampaign($request->input());
            return response(['status' => 1, 'data' => []]);
        } catch (\Exception $e) {
            Log::debug($e->message . ' ' . $e->getTraceAsString());
            return response(['status' => 0, 'data' => []]);
        }
    }

    
}
