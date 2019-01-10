<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderExchangeApiTest extends TestCase
{
    use MakeOrderExchangeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateOrderExchange()
    {
        $orderExchange = $this->fakeOrderExchangeData();
        $this->json('POST', '/api/v1/orderExchanges', $orderExchange);

        $this->assertApiResponse($orderExchange);
    }

    /**
     * @test
     */
    public function testReadOrderExchange()
    {
        $orderExchange = $this->makeOrderExchange();
        $this->json('GET', '/api/v1/orderExchanges/'.$orderExchange->id);

        $this->assertApiResponse($orderExchange->toArray());
    }

    /**
     * @test
     */
    public function testUpdateOrderExchange()
    {
        $orderExchange = $this->makeOrderExchange();
        $editedOrderExchange = $this->fakeOrderExchangeData();

        $this->json('PUT', '/api/v1/orderExchanges/'.$orderExchange->id, $editedOrderExchange);

        $this->assertApiResponse($editedOrderExchange);
    }

    /**
     * @test
     */
    public function testDeleteOrderExchange()
    {
        $orderExchange = $this->makeOrderExchange();
        $this->json('DELETE', '/api/v1/orderExchanges/'.$orderExchange->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/orderExchanges/'.$orderExchange->id);

        $this->assertResponseStatus(404);
    }
}
