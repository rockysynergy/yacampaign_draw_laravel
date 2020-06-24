<?php

namespace Orqlog\YacampaignDraw\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;
use Orqlog\YacampaignDraw\Services\DrawCampaignService;

class DrawCampaignController extends BaseController
{
    public function show($campainId)
    {
        return response(['data' => [
            'title' => 'ATitle'
        ]]);
    }

    public function create(Request $request, DrawCampaignService $drawCampaignService)
    {
        try {
            $drawCampaignService->createCampaign($request->input());
            return response(['status' => 1, 'data' => []]);
        } catch (\Exception $e) {
            Log::debug($e->message . ' ' . $e->getTraceAsString());
            return response(['status' => 0, 'data' => []]);
        }
    }
}
