<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Snap_PhotoApiTest extends TestCase
{
    use MakeSnap_PhotoTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSnap_Photo()
    {
        $snapPhoto = $this->fakeSnap_PhotoData();
        $this->json('POST', '/api/v1/snapPhotos', $snapPhoto);

        $this->assertApiResponse($snapPhoto);
    }

    /**
     * @test
     */
    public function testReadSnap_Photo()
    {
        $snapPhoto = $this->makeSnap_Photo();
        $this->json('GET', '/api/v1/snapPhotos/'.$snapPhoto->id);

        $this->assertApiResponse($snapPhoto->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSnap_Photo()
    {
        $snapPhoto = $this->makeSnap_Photo();
        $editedSnap_Photo = $this->fakeSnap_PhotoData();

        $this->json('PUT', '/api/v1/snapPhotos/'.$snapPhoto->id, $editedSnap_Photo);

        $this->assertApiResponse($editedSnap_Photo);
    }

    /**
     * @test
     */
    public function testDeleteSnap_Photo()
    {
        $snapPhoto = $this->makeSnap_Photo();
        $this->json('DELETE', '/api/v1/snapPhotos/'.$snapPhoto->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/snapPhotos/'.$snapPhoto->id);

        $this->assertResponseStatus(404);
    }
}
