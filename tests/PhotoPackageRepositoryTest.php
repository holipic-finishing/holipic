<?php

use App\Models\PhotoPackage;
use App\Repositories\PhotoPackageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PhotoPackageRepositoryTest extends TestCase
{
    use MakePhotoPackageTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PhotoPackageRepository
     */
    protected $photoPackageRepo;

    public function setUp()
    {
        parent::setUp();
        $this->photoPackageRepo = App::make(PhotoPackageRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePhotoPackage()
    {
        $photoPackage = $this->fakePhotoPackageData();
        $createdPhotoPackage = $this->photoPackageRepo->create($photoPackage);
        $createdPhotoPackage = $createdPhotoPackage->toArray();
        $this->assertArrayHasKey('id', $createdPhotoPackage);
        $this->assertNotNull($createdPhotoPackage['id'], 'Created PhotoPackage must have id specified');
        $this->assertNotNull(PhotoPackage::find($createdPhotoPackage['id']), 'PhotoPackage with given id must be in DB');
        $this->assertModelData($photoPackage, $createdPhotoPackage);
    }

    /**
     * @test read
     */
    public function testReadPhotoPackage()
    {
        $photoPackage = $this->makePhotoPackage();
        $dbPhotoPackage = $this->photoPackageRepo->find($photoPackage->id);
        $dbPhotoPackage = $dbPhotoPackage->toArray();
        $this->assertModelData($photoPackage->toArray(), $dbPhotoPackage);
    }

    /**
     * @test update
     */
    public function testUpdatePhotoPackage()
    {
        $photoPackage = $this->makePhotoPackage();
        $fakePhotoPackage = $this->fakePhotoPackageData();
        $updatedPhotoPackage = $this->photoPackageRepo->update($fakePhotoPackage, $photoPackage->id);
        $this->assertModelData($fakePhotoPackage, $updatedPhotoPackage->toArray());
        $dbPhotoPackage = $this->photoPackageRepo->find($photoPackage->id);
        $this->assertModelData($fakePhotoPackage, $dbPhotoPackage->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePhotoPackage()
    {
        $photoPackage = $this->makePhotoPackage();
        $resp = $this->photoPackageRepo->delete($photoPackage->id);
        $this->assertTrue($resp);
        $this->assertNull(PhotoPackage::find($photoPackage->id), 'PhotoPackage should not exist in DB');
    }
}
