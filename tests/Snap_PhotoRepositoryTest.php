<?php

use App\Models\Snap_Photo;
use App\Repositories\Snap_PhotoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Snap_PhotoRepositoryTest extends TestCase
{
    use MakeSnap_PhotoTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var Snap_PhotoRepository
     */
    protected $snapPhotoRepo;

    public function setUp()
    {
        parent::setUp();
        $this->snapPhotoRepo = App::make(Snap_PhotoRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSnap_Photo()
    {
        $snapPhoto = $this->fakeSnap_PhotoData();
        $createdSnap_Photo = $this->snapPhotoRepo->create($snapPhoto);
        $createdSnap_Photo = $createdSnap_Photo->toArray();
        $this->assertArrayHasKey('id', $createdSnap_Photo);
        $this->assertNotNull($createdSnap_Photo['id'], 'Created Snap_Photo must have id specified');
        $this->assertNotNull(Snap_Photo::find($createdSnap_Photo['id']), 'Snap_Photo with given id must be in DB');
        $this->assertModelData($snapPhoto, $createdSnap_Photo);
    }

    /**
     * @test read
     */
    public function testReadSnap_Photo()
    {
        $snapPhoto = $this->makeSnap_Photo();
        $dbSnap_Photo = $this->snapPhotoRepo->find($snapPhoto->id);
        $dbSnap_Photo = $dbSnap_Photo->toArray();
        $this->assertModelData($snapPhoto->toArray(), $dbSnap_Photo);
    }

    /**
     * @test update
     */
    public function testUpdateSnap_Photo()
    {
        $snapPhoto = $this->makeSnap_Photo();
        $fakeSnap_Photo = $this->fakeSnap_PhotoData();
        $updatedSnap_Photo = $this->snapPhotoRepo->update($fakeSnap_Photo, $snapPhoto->id);
        $this->assertModelData($fakeSnap_Photo, $updatedSnap_Photo->toArray());
        $dbSnap_Photo = $this->snapPhotoRepo->find($snapPhoto->id);
        $this->assertModelData($fakeSnap_Photo, $dbSnap_Photo->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSnap_Photo()
    {
        $snapPhoto = $this->makeSnap_Photo();
        $resp = $this->snapPhotoRepo->delete($snapPhoto->id);
        $this->assertTrue($resp);
        $this->assertNull(Snap_Photo::find($snapPhoto->id), 'Snap_Photo should not exist in DB');
    }
}
