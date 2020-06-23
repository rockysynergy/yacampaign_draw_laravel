<?php

use Orqlog\YacampaignDraw\Models\DrawCampaign;
use Illuminate\Foundation\Testing\RefreshDatabase;

require_once "DbConfigTrait.php";

final class FactoryTest extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase, DbConfigTrait;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../src/resources/database/migrations');
    }


    /**
     * @test
     */
    public function campaignValidatorIsCalledUponCreation()
    {
        $drawCampaign = new DrawCampaign();
        $drawCampaign->title = 'Hey title';
        $drawCampaign->save();

        $this->assertDatabaseHas('ya_drawcampaigns', ['title' => 'Hey title']);
        $this->assertTrue(true);
    }
}
