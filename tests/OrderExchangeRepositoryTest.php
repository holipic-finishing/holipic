<?php

use App\Models\OrderExchange;
use App\Repositories\OrderExchangeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderExchangeRepositoryTest extends TestCase
{
    use MakeOrderExchangeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var OrderExchangeRepository
     */
    protected $orderExchangeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->orderExchangeRepo = App::make(OrderExchangeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateOrderExchange()
    {
        $orderExchange = $this->fakeOrderExchangeData();
        $createdOrderExchange = $this->orderExchangeRepo->create($orderExchange);
        $createdOrderExchange = $createdOrderExchange->toArray();
        $this->assertArrayHasKey('id', $createdOrderExchange);
        $this->assertNotNull($createdOrderExchange['id'], 'Created OrderExchange must have id specified');
        $this->assertNotNull(OrderExchange::find($createdOrderExchange['id']), 'OrderExchange with given id must be in DB');
        $this->assertModelData($orderExchange, $createdOrderExchange);
    }

    /**
     * @test read
     */
    public function testReadOrderExchange()
    {
        $orderExchange = $this->makeOrderExchange();
        $dbOrderExchange = $this->orderExchangeRepo->find($orderExchange->id);
        $dbOrderExchange = $dbOrderExchange->toArray();
        $this->assertModelData($orderExchange->toArray(), $dbOrderExchange);
    }

    /**
     * @test update
     */
    public function testUpdateOrderExchange()
    {
        $orderExchange = $this->makeOrderExchange();
        $fakeOrderExchange = $this->fakeOrderExchangeData();
        $updatedOrderExchange = $this->orderExchangeRepo->update($fakeOrderExchange, $orderExchange->id);
        $this->assertModelData($fakeOrderExchange, $updatedOrderExchange->toArray());
        $dbOrderExchange = $this->orderExchangeRepo->find($orderExchange->id);
        $this->assertModelData($fakeOrderExchange, $dbOrderExchange->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteOrderExchange()
    {
        $orderExchange = $this->makeOrderExchange();
        $resp = $this->orderExchangeRepo->delete($orderExchange->id);
        $this->assertTrue($resp);
        $this->assertNull(OrderExchange::find($orderExchange->id), 'OrderExchange should not exist in DB');
    }
}
