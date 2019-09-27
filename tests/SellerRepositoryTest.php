<?php namespace Tests\Repositories;

use App\Models\Seller;
use App\Repositories\SellerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SellerRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SellerRepository
     */
    protected $sellerRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->sellerRepo = \App::make(SellerRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_seller()
    {
        $seller = factory(Seller::class)->make()->toArray();

        $createdSeller = $this->sellerRepo->create($seller);

        $createdSeller = $createdSeller->toArray();
        $this->assertArrayHasKey('id', $createdSeller);
        $this->assertNotNull($createdSeller['id'], 'Created Seller must have id specified');
        $this->assertNotNull(Seller::find($createdSeller['id']), 'Seller with given id must be in DB');
        $this->assertModelData($seller, $createdSeller);
    }

    /**
     * @test read
     */
    public function test_read_seller()
    {
        $seller = factory(Seller::class)->create();

        $dbSeller = $this->sellerRepo->find($seller->id);

        $dbSeller = $dbSeller->toArray();
        $this->assertModelData($seller->toArray(), $dbSeller);
    }

    /**
     * @test update
     */
    public function test_update_seller()
    {
        $seller = factory(Seller::class)->create();
        $fakeSeller = factory(Seller::class)->make()->toArray();

        $updatedSeller = $this->sellerRepo->update($fakeSeller, $seller->id);

        $this->assertModelData($fakeSeller, $updatedSeller->toArray());
        $dbSeller = $this->sellerRepo->find($seller->id);
        $this->assertModelData($fakeSeller, $dbSeller->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_seller()
    {
        $seller = factory(Seller::class)->create();

        $resp = $this->sellerRepo->delete($seller->id);

        $this->assertTrue($resp);
        $this->assertNull(Seller::find($seller->id), 'Seller should not exist in DB');
    }
}
