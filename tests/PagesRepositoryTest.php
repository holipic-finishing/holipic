<?php

use App\Models\CompanyAdmin\Pages;
use App\Repositories\PagesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesRepositoryTest extends TestCase
{
    use MakePagesTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PagesRepository
     */
    protected $pagesRepo;

    public function setUp()
    {
        parent::setUp();
        $this->pagesRepo = App::make(PagesRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePages()
    {
        $pages = $this->fakePagesData();
        $createdPages = $this->pagesRepo->create($pages);
        $createdPages = $createdPages->toArray();
        $this->assertArrayHasKey('id', $createdPages);
        $this->assertNotNull($createdPages['id'], 'Created Pages must have id specified');
        $this->assertNotNull(Pages::find($createdPages['id']), 'Pages with given id must be in DB');
        $this->assertModelData($pages, $createdPages);
    }

    /**
     * @test read
     */
    public function testReadPages()
    {
        $pages = $this->makePages();
        $dbPages = $this->pagesRepo->find($pages->id);
        $dbPages = $dbPages->toArray();
        $this->assertModelData($pages->toArray(), $dbPages);
    }

    /**
     * @test update
     */
    public function testUpdatePages()
    {
        $pages = $this->makePages();
        $fakePages = $this->fakePagesData();
        $updatedPages = $this->pagesRepo->update($fakePages, $pages->id);
        $this->assertModelData($fakePages, $updatedPages->toArray());
        $dbPages = $this->pagesRepo->find($pages->id);
        $this->assertModelData($fakePages, $dbPages->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePages()
    {
        $pages = $this->makePages();
        $resp = $this->pagesRepo->delete($pages->id);
        $this->assertTrue($resp);
        $this->assertNull(Pages::find($pages->id), 'Pages should not exist in DB');
    }
}
