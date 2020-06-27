<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orqlog\YacampaignDrawLaravel\Domain\Model\DrawCampaign;
use Orqlog\YacampaignDrawLaravel\Domain\Repository\DrawCampaignRepository;

require_once __DIR__ . "/../../DbConfigTrait.php";

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
    
    protected function getPackageProviders($app)
    {
        return ['\Orqlog\YacampaignDrawLaravel\Providers\MyServiceProvider'];
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
    public function addWillReturnAddedCampaignModel()
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

    /**
     * @test
     */
    public function removeDrawCampaign()
    {
        $this->withFactories(self::getFactoryPath());
        $drawCampaign = factory(DrawCampaignRepository::class)->create();

        $drawCampaignRepository = new DrawCampaignRepository();
        $drawCampaignRepository->remove($drawCampaign->id);
        
        $inserted = DB::table('ya_drawcampaigns')->find($drawCampaign->id);
        // var_dump($inserted);
        $this->assertNotNull($inserted->deleted_at);
    }

}
