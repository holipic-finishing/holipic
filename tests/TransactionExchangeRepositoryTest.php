<?php

use App\Models\TransactionExchange;
use App\Repositories\TransactionExchangeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionExchangeRepositoryTest extends TestCase
{
    use MakeTransactionExchangeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var TransactionExchangeRepository
     */
    protected $transactionExchangeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->transactionExchangeRepo = App::make(TransactionExchangeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateTransactionExchange()
    {
        $transactionExchange = $this->fakeTransactionExchangeData();
        $createdTransactionExchange = $this->transactionExchangeRepo->create($transactionExchange);
        $createdTransactionExchange = $createdTransactionExchange->toArray();
        $this->assertArrayHasKey('id', $createdTransactionExchange);
        $this->assertNotNull($createdTransactionExchange['id'], 'Created TransactionExchange must have id specified');
        $this->assertNotNull(TransactionExchange::find($createdTransactionExchange['id']), 'TransactionExchange with given id must be in DB');
        $this->assertModelData($transactionExchange, $createdTransactionExchange);
    }

    /**
     * @test read
     */
    public function testReadTransactionExchange()
    {
        $transactionExchange = $this->makeTransactionExchange();
        $dbTransactionExchange = $this->transactionExchangeRepo->find($transactionExchange->id);
        $dbTransactionExchange = $dbTransactionExchange->toArray();
        $this->assertModelData($transactionExchange->toArray(), $dbTransactionExchange);
    }

    /**
     * @test update
     */
    public function testUpdateTransactionExchange()
    {
        $transactionExchange = $this->makeTransactionExchange();
        $fakeTransactionExchange = $this->fakeTransactionExchangeData();
        $updatedTransactionExchange = $this->transactionExchangeRepo->update($fakeTransactionExchange, $transactionExchange->id);
        $this->assertModelData($fakeTransactionExchange, $updatedTransactionExchange->toArray());
        $dbTransactionExchange = $this->transactionExchangeRepo->find($transactionExchange->id);
        $this->assertModelData($fakeTransactionExchange, $dbTransactionExchange->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteTransactionExchange()
    {
        $transactionExchange = $this->makeTransactionExchange();
        $resp = $this->transactionExchangeRepo->delete($transactionExchange->id);
        $this->assertTrue($resp);
        $this->assertNull(TransactionExchange::find($transactionExchange->id), 'TransactionExchange should not exist in DB');
    }
}
