<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionCalulatorEwalletApiTest extends TestCase
{
    use MakeTransactionCalulatorEwalletTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateTransactionCalulatorEwallet()
    {
        $transactionCalulatorEwallet = $this->fakeTransactionCalulatorEwalletData();
        $this->json('POST', '/api/v1/transactionCalulatorEwallets', $transactionCalulatorEwallet);

        $this->assertApiResponse($transactionCalulatorEwallet);
    }

    /**
     * @test
     */
    public function testReadTransactionCalulatorEwallet()
    {
        $transactionCalulatorEwallet = $this->makeTransactionCalulatorEwallet();
        $this->json('GET', '/api/v1/transactionCalulatorEwallets/'.$transactionCalulatorEwallet->id);

        $this->assertApiResponse($transactionCalulatorEwallet->toArray());
    }

    /**
     * @test
     */
    public function testUpdateTransactionCalulatorEwallet()
    {
        $transactionCalulatorEwallet = $this->makeTransactionCalulatorEwallet();
        $editedTransactionCalulatorEwallet = $this->fakeTransactionCalulatorEwalletData();

        $this->json('PUT', '/api/v1/transactionCalulatorEwallets/'.$transactionCalulatorEwallet->id, $editedTransactionCalulatorEwallet);

        $this->assertApiResponse($editedTransactionCalulatorEwallet);
    }

    /**
     * @test
     */
    public function testDeleteTransactionCalulatorEwallet()
    {
        $transactionCalulatorEwallet = $this->makeTransactionCalulatorEwallet();
        $this->json('DELETE', '/api/v1/transactionCalulatorEwallets/'.$transactionCalulatorEwallet->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/transactionCalulatorEwallets/'.$transactionCalulatorEwallet->id);

        $this->assertResponseStatus(404);
    }
}
