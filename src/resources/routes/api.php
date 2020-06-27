<?php

Route::prefix('v1')->namespace('Orqlog\YacampaignDrawLaravel\Http\Controllers\Admin')->group(function(){
// Route::prefix('v1')->namespace('Admin')->group(function(){

    // Route::get('drawcampaign/{campaignId}', function ($campaignId) {
    //     return 'Hey you the campaign: ' . $campaignId;
    // });
    Route::get('drawcampaign/{campaignId}', 'DrawCampaignController@show')->name('CampaignShow');
    Route::post('drawcampaign', 'DrawCampaignController@create')->name('CampaignCreate');
    Route::put('drawcampaign/{campaignId}', 'DrawCampaignController@update')->name('CampaignUpdate');
});
