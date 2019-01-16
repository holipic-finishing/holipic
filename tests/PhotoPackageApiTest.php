<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PhotoPackageApiTest extends TestCase
{
    use MakePhotoPackageTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePhotoPackage()
    {
        $photoPackage = $this->fakePhotoPackageData();
        $this->json('POST', '/api/v1/photoPackages', $photoPackage);

        $this->assertApiResponse($photoPackage);
    }

    /**
     * @test
     */
    public function testReadPhotoPackage()
    {
        $photoPackage = $this->makePhotoPackage();
        $this->json('GET', '/api/v1/photoPackages/'.$photoPackage->id);

        $this->assertApiResponse($photoPackage->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePhotoPackage()
    {
        $photoPackage = $this->makePhotoPackage();
        $editedPhotoPackage = $this->fakePhotoPackageData();

        $this->json('PUT', '/api/v1/photoPackages/'.$photoPackage->id, $editedPhotoPackage);

        $this->assertApiResponse($editedPhotoPackage);
    }

    /**
     * @test
     */
    public function testDeletePhotoPackage()
    {
        $photoPackage = $this->makePhotoPackage();
        $this->json('DELETE', '/api/v1/photoPackages/'.$photoPackage->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/photoPackages/'.$photoPackage->id);

        $this->assertResponseStatus(404);
    }
}
