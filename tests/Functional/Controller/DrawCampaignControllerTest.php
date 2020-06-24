<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

require_once __DIR__ . "/../DbConfigTrait.php";

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
        // return ['\Orqlog\YacampaignDraw\Providers\MyServiceProvider', '\Orqlog\YacampaignDraw\Providers\MyRouteServiceProvider'];
        return ['\Orqlog\YacampaignDraw\Providers\MyServiceProvider'];
    }

    /**
     * @test
     */
    public function show(): void
    {
        $response = $this->get('/v1/drawcampaign/1');

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'ATitle');
    }

    /**
     * @test
     */
    public function create(): void
    {
        $data = [
            'title' => 'The Title',
            'description' => 'The description',
            'start_at' => '2020-02-12 14:23:15',
            'end_at' => '2020-02-12 17:23:15',
        ];
        $response = $this->json('POST', '/v1/drawcampaign', $data);

        $response->assertStatus(200)
            ->assertJsonPath('status', 1);

        $expected = array_diff_key($data, ['start_at' => '', 'end_at' => '']);
        $this->assertDatabaseHas('ya_drawcampaigns', $expected);
    }
}
