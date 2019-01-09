<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PhotographerApiTest extends TestCase
{
    use MakePhotographerTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePhotographer()
    {
        $photographer = $this->fakePhotographerData();
        $this->json('POST', '/api/v1/photographers', $photographer);

        $this->assertApiResponse($photographer);
    }

    /**
     * @test
     */
    public function testReadPhotographer()
    {
        $photographer = $this->makePhotographer();
        $this->json('GET', '/api/v1/photographers/'.$photographer->id);

        $this->assertApiResponse($photographer->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePhotographer()
    {
        $photographer = $this->makePhotographer();
        $editedPhotographer = $this->fakePhotographerData();

        $this->json('PUT', '/api/v1/photographers/'.$photographer->id, $editedPhotographer);

        $this->assertApiResponse($editedPhotographer);
    }

    /**
     * @test
     */
    public function testDeletePhotographer()
    {
        $photographer = $this->makePhotographer();
        $this->json('DELETE', '/api/v1/photographers/'.$photographer->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/photographers/'.$photographer->id);

        $this->assertResponseStatus(404);
    }
}
