<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orqlog\YacampaignDraw\Domain\Model\DrawCampaign;
use Orqlog\YacampaignDraw\Models\DrawCampaignRepository;

require_once __DIR__ . "/../DbConfigTrait.php";

final class DrawCampaignRepositoryTest extends \Orchestra\Testbench\TestCase
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

    /**
     * @test
     */
    public function createDrawCampaignCanPersistToDatabase()
    {
        $drawCampaign = new DrawCampaignRepository();
        $drawCampaign->title = 'Hey title';
        $drawCampaign->description = 'Hey Description';
        $drawCampaign->save();

        $this->assertDatabaseHas('ya_drawcampaigns', ['title' => 'Hey title']);
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function makeCampaignThrowsExceptionIfEndDateIsEarlierThanStartDate()
    {

        $this->expectExceptionCode('1591674076');
        $drawCampaignRepository = new DrawCampaignRepository();
        $data = [
            'title' => 'The campaign title',
            'start_at' => '2020-04-22 11:12:00',
            'end_at' => '2020-04-22 10:12:00',
        ];
        $drawCampaignRepository->makeCampaign($data);
    }

    /**
     * @test
     */
    public function makeCampaignCreatesDrawCampaign()
    {
        $drawCampaignRepository = new DrawCampaignRepository();
        $data = [
            'title' => 'The campaign title',
            'start_at' => '2020-04-22 10:12:00',
            'end_at' => '2020-04-22 11:12:00',
        ];
        $result = $drawCampaignRepository->makeCampaign($data);

        $this->assertTrue($result instanceof DrawCampaign);
    }

    /**
     * @test
     */
    public function addWillPersistDataCorrectly()
    {
        $drawCampaignRepository = new DrawCampaignRepository();

        $data = [
            'title' => 'The title',
            'description' => 'The description',
            'start_at' => '2020-12-20 12:12:12',
            'end_at' => '2021-12-20 12:12:12',
        ];
        $drawCampaign = $drawCampaignRepository->makeCampaign($data);

        $drawCampaignRepository->add($drawCampaign);
        $expected = $data;
        $expected['start_at'] = strtotime($expected['start_at']);
        $expected['end_at'] = strtotime($expected['end_at']);
        $this->assertDatabaseHas('ya_drawcampaigns', $expected);
    }

    /**
     * @test
     */
    public function addWillReturnUpdatedCampaignModel()
    {
        $drawCampaignRepository = new DrawCampaignRepository();

        $data = [
            'title' => 'The title',
            'description' => 'The description',
            'start_at' => '2020-12-20 12:12:12',
            'end_at' => '2021-12-20 12:12:12',
        ];
        $drawCampaign = $drawCampaignRepository->makeCampaign($data);

        $addedCampaign = $drawCampaignRepository->add($drawCampaign);

        $this->assertTrue($addedCampaign->getId() > 0);
    }

    /**
     * @test
     */
    public function addWoudNotInsertNewRecordIfTheDrawCampaignExistsInDatabaseAlready()
    {
        $this->withFactories(self::getFactoryPath());
        $drawCampaignRepository = factory(DrawCampaignRepository::class)->create();

        $data = [
            'id' => $drawCampaignRepository->id,
            'title' => 'The title',
            'description' => 'Description aaaa',
        ];
        $drawCampaign = $drawCampaignRepository->makeCampaign($data);
        $drawCampaignRepository->add($drawCampaign);

        $this->assertDatabaseCount('ya_drawcampaigns', 1);
    }

    /**
     * @test
     */
    public function addWoudUpdateTheExistingRecord()
    {
        $this->withFactories(self::getFactoryPath());
        $drawCampaignRepository = factory(DrawCampaignRepository::class)->create();

        $data = [
            'id' => $drawCampaignRepository->id,
            'title' => 'The title',
            'description' => 'Description aaaa',
        ];
        $this->assertNotEquals($data['title'], $drawCampaignRepository->title);

        $drawCampaign = $drawCampaignRepository->makeCampaign($data);
        $drawCampaignRepository->add($drawCampaign);

        $updatedDrawCampaign = $drawCampaignRepository->findById($data['id']);
        $this->assertEquals($data['title'], $updatedDrawCampaign->getTitle());
    }

}
