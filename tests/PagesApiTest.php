<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesApiTest extends TestCase
{
    use MakePagesTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePages()
    {
        $pages = $this->fakePagesData();
        $this->json('POST', '/api/v1/pages', $pages);

        $this->assertApiResponse($pages);
    }

    /**
     * @test
     */
    public function testReadPages()
    {
        $pages = $this->makePages();
        $this->json('GET', '/api/v1/pages/'.$pages->id);

        $this->assertApiResponse($pages->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePages()
    {
        $pages = $this->makePages();
        $editedPages = $this->fakePagesData();

        $this->json('PUT', '/api/v1/pages/'.$pages->id, $editedPages);

        $this->assertApiResponse($editedPages);
    }

    /**
     * @test
     */
    public function testDeletePages()
    {
        $pages = $this->makePages();
        $this->json('DELETE', '/api/v1/pages/'.$pages->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/pages/'.$pages->id);

        $this->assertResponseStatus(404);
    }
}
