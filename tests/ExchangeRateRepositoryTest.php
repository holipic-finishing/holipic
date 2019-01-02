<?php

use App\Models\ExchangeRate;
use App\Repositories\ExchangeRateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExchangeRateRepositoryTest extends TestCase
{
    use MakeExchangeRateTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ExchangeRateRepository
     */
    protected $exchangeRateRepo;

    public function setUp()
    {
        parent::setUp();
        $this->exchangeRateRepo = App::make(ExchangeRateRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateExchangeRate()
    {
        $exchangeRate = $this->fakeExchangeRateData();
        $createdExchangeRate = $this->exchangeRateRepo->create($exchangeRate);
        $createdExchangeRate = $createdExchangeRate->toArray();
        $this->assertArrayHasKey('id', $createdExchangeRate);
        $this->assertNotNull($createdExchangeRate['id'], 'Created ExchangeRate must have id specified');
        $this->assertNotNull(ExchangeRate::find($createdExchangeRate['id']), 'ExchangeRate with given id must be in DB');
        $this->assertModelData($exchangeRate, $createdExchangeRate);
    }

    /**
     * @test read
     */
    public function testReadExchangeRate()
    {
        $exchangeRate = $this->makeExchangeRate();
        $dbExchangeRate = $this->exchangeRateRepo->find($exchangeRate->id);
        $dbExchangeRate = $dbExchangeRate->toArray();
        $this->assertModelData($exchangeRate->toArray(), $dbExchangeRate);
    }

    /**
     * @test update
     */
    public function testUpdateExchangeRate()
    {
        $exchangeRate = $this->makeExchangeRate();
        $fakeExchangeRate = $this->fakeExchangeRateData();
        $updatedExchangeRate = $this->exchangeRateRepo->update($fakeExchangeRate, $exchangeRate->id);
        $this->assertModelData($fakeExchangeRate, $updatedExchangeRate->toArray());
        $dbExchangeRate = $this->exchangeRateRepo->find($exchangeRate->id);
        $this->assertModelData($fakeExchangeRate, $dbExchangeRate->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteExchangeRate()
    {
        $exchangeRate = $this->makeExchangeRate();
        $resp = $this->exchangeRateRepo->delete($exchangeRate->id);
        $this->assertTrue($resp);
        $this->assertNull(ExchangeRate::find($exchangeRate->id), 'ExchangeRate should not exist in DB');
    }
}
