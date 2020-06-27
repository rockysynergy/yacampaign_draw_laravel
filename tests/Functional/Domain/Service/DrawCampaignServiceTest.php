<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orqlog\YacampaignDrawLaravel\Domain\Service\DrawCampaignService;
use Orqlog\YacampaignDrawLaravel\Domain\Repository\DrawCampaignRepository;

require_once __DIR__ . "/../../DbConfigTrait.php";

final class DrawCampaignServiceTest extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase, DbConfigTrait;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(self::getMigrationPath());
    }

    protected function getPackageProviders($app)
    {
        return ['\Orqlog\YacampaignDrawLaravel\Providers\DrawCampaignServiceProvider'];
    }

    /**
     * @test
     */
    public function createCampaignWorks()
    {
        $drawCampaignService = new DrawCampaignService();
        $data = [
            'title' => 'The Title',
            'description' => 'The description',
            'start_at' => '2020-02-12 14:23:15',
            'end_at' => '2020-02-12 17:23:15',
        ];
        $drawCampaignService->saveCampaign($data);

        $expected = array_diff_key($data, ['start_at' => '', 'end_at' => '']);
        $this->assertDatabaseHas('ya_drawcampaigns', $expected);
    }

    /**
     * @test
     */
    public function updateCampaignWorks()
    {
        $this->withFactories(self::getFactoryPath());
        $drawCampaign = factory(DrawCampaignRepository::class)->create();
        
        $drawCampaignService = new DrawCampaignService();
        $data = [
            'id' => $drawCampaign->id,
            'title' => 'The Title updated',
            'description' => 'The description',
            'start_at' => '2020-02-12 14:23:15',
            'end_at' => '2020-02-12 17:23:15',
        ];
        $drawCampaignService->saveCampaign($data);

        $expected = array_diff_key($data, ['start_at' => '', 'end_at' => '']);
        $this->assertDatabaseHas('ya_drawcampaigns', $expected);
    }
}
