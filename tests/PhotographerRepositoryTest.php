<?php

use App\Models\Photographer;
use App\Repositories\PhotographerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PhotographerRepositoryTest extends TestCase
{
    use MakePhotographerTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PhotographerRepository
     */
    protected $photographerRepo;

    public function setUp()
    {
        parent::setUp();
        $this->photographerRepo = App::make(PhotographerRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePhotographer()
    {
        $photographer = $this->fakePhotographerData();
        $createdPhotographer = $this->photographerRepo->create($photographer);
        $createdPhotographer = $createdPhotographer->toArray();
        $this->assertArrayHasKey('id', $createdPhotographer);
        $this->assertNotNull($createdPhotographer['id'], 'Created Photographer must have id specified');
        $this->assertNotNull(Photographer::find($createdPhotographer['id']), 'Photographer with given id must be in DB');
        $this->assertModelData($photographer, $createdPhotographer);
    }

    /**
     * @test read
     */
    public function testReadPhotographer()
    {
        $photographer = $this->makePhotographer();
        $dbPhotographer = $this->photographerRepo->find($photographer->id);
        $dbPhotographer = $dbPhotographer->toArray();
        $this->assertModelData($photographer->toArray(), $dbPhotographer);
    }

    /**
     * @test update
     */
    public function testUpdatePhotographer()
    {
        $photographer = $this->makePhotographer();
        $fakePhotographer = $this->fakePhotographerData();
        $updatedPhotographer = $this->photographerRepo->update($fakePhotographer, $photographer->id);
        $this->assertModelData($fakePhotographer, $updatedPhotographer->toArray());
        $dbPhotographer = $this->photographerRepo->find($photographer->id);
        $this->assertModelData($fakePhotographer, $dbPhotographer->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePhotographer()
    {
        $photographer = $this->makePhotographer();
        $resp = $this->photographerRepo->delete($photographer->id);
        $this->assertTrue($resp);
        $this->assertNull(Photographer::find($photographer->id), 'Photographer should not exist in DB');
    }
}
