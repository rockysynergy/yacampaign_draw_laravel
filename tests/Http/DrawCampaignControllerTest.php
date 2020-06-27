<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orqlog\YacampaignDrawLaravel\Domain\Repository\DrawCampaignRepository;

require_once __DIR__ . "/../Functional/DbConfigTrait.php";

final class DrawCampaignControllerTest extends \Orchestra\Testbench\TestCase
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
        return ['\Orqlog\YacampaignDrawLaravel\Providers\MyServiceProvider'];
    }

    /**
     * @test
     */
    public function show(): void
    {
        $campaignId = '3';
        $response = $this->get('/v1/drawcampaign/' . $campaignId);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $campaignId);
    }

    /**
     * @test
     */
    public function create(): void
    {
        $data = [
            'title' => 'The Title' . date('Y-m-d'),
            'description' => 'The descriptiona',
            'start_at' => '2020-02-12 14:23:15',
            'end_at' => '2020-02-12 17:23:15',
        ];
        $response = $this->json('POST', '/v1/drawcampaign', $data);

        $response->assertStatus(200)
            ->assertJsonPath('status', 1);

        $expected = array_diff_key($data, ['start_at' => '', 'end_at' => '']);
        $this->assertDatabaseHas('ya_drawcampaigns', $expected);
    }

    /**
     * @test
     */
    public function update(): void
    {
        $this->withFactories(self::getFactoryPath());
        $drawCampaign = factory(DrawCampaignRepository::class)->create();
        
        $data = [
            'title' => 'The Title' . date('Y-m-d'),
            'description' => 'The descriptiona',
            'start_at' => '2020-02-12 14:23:15',
            'end_at' => '2020-02-12 17:23:15',
        ];
        $response = $this->json('PUT', '/v1/drawcampaign/' . $drawCampaign->id, $data);

        if ($response->getStatusCode() !== 200) {
            $response->dumpHeaders();
        }
        $response->assertStatus(200)
            ->assertJsonPath('status', 1);

        $expected = array_diff_key($data, ['start_at' => '', 'end_at' => '']);
        $this->assertDatabaseHas('ya_drawcampaigns', $expected);
    }
}
