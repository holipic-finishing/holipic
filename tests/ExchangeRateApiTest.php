<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExchangeRateApiTest extends TestCase
{
    use MakeExchangeRateTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateExchangeRate()
    {
        $exchangeRate = $this->fakeExchangeRateData();
        $this->json('POST', '/api/v1/exchangeRates', $exchangeRate);

        $this->assertApiResponse($exchangeRate);
    }

    /**
     * @test
     */
    public function testReadExchangeRate()
    {
        $exchangeRate = $this->makeExchangeRate();
        $this->json('GET', '/api/v1/exchangeRates/'.$exchangeRate->id);

        $this->assertApiResponse($exchangeRate->toArray());
    }

    /**
     * @test
     */
    public function testUpdateExchangeRate()
    {
        $exchangeRate = $this->makeExchangeRate();
        $editedExchangeRate = $this->fakeExchangeRateData();

        $this->json('PUT', '/api/v1/exchangeRates/'.$exchangeRate->id, $editedExchangeRate);

        $this->assertApiResponse($editedExchangeRate);
    }

    /**
     * @test
     */
    public function testDeleteExchangeRate()
    {
        $exchangeRate = $this->makeExchangeRate();
        $this->json('DELETE', '/api/v1/exchangeRates/'.$exchangeRate->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/exchangeRates/'.$exchangeRate->id);

        $this->assertResponseStatus(404);
    }
}
