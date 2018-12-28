<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionExchangeApiTest extends TestCase
{
    use MakeTransactionExchangeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateTransactionExchange()
    {
        $transactionExchange = $this->fakeTransactionExchangeData();
        $this->json('POST', '/api/v1/transactionExchanges', $transactionExchange);

        $this->assertApiResponse($transactionExchange);
    }

    /**
     * @test
     */
    public function testReadTransactionExchange()
    {
        $transactionExchange = $this->makeTransactionExchange();
        $this->json('GET', '/api/v1/transactionExchanges/'.$transactionExchange->id);

        $this->assertApiResponse($transactionExchange->toArray());
    }

    /**
     * @test
     */
    public function testUpdateTransactionExchange()
    {
        $transactionExchange = $this->makeTransactionExchange();
        $editedTransactionExchange = $this->fakeTransactionExchangeData();

        $this->json('PUT', '/api/v1/transactionExchanges/'.$transactionExchange->id, $editedTransactionExchange);

        $this->assertApiResponse($editedTransactionExchange);
    }

    /**
     * @test
     */
    public function testDeleteTransactionExchange()
    {
        $transactionExchange = $this->makeTransactionExchange();
        $this->json('DELETE', '/api/v1/transactionExchanges/'.$transactionExchange->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/transactionExchanges/'.$transactionExchange->id);

        $this->assertResponseStatus(404);
    }
}
