<?php

use App\Models\TransactionCalulatorEwallet;
use App\Repositories\TransactionCalulatorEwalletRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionCalulatorEwalletRepositoryTest extends TestCase
{
    use MakeTransactionCalulatorEwalletTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var TransactionCalulatorEwalletRepository
     */
    protected $transactionCalulatorEwalletRepo;

    public function setUp()
    {
        parent::setUp();
        $this->transactionCalulatorEwalletRepo = App::make(TransactionCalulatorEwalletRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateTransactionCalulatorEwallet()
    {
        $transactionCalulatorEwallet = $this->fakeTransactionCalulatorEwalletData();
        $createdTransactionCalulatorEwallet = $this->transactionCalulatorEwalletRepo->create($transactionCalulatorEwallet);
        $createdTransactionCalulatorEwallet = $createdTransactionCalulatorEwallet->toArray();
        $this->assertArrayHasKey('id', $createdTransactionCalulatorEwallet);
        $this->assertNotNull($createdTransactionCalulatorEwallet['id'], 'Created TransactionCalulatorEwallet must have id specified');
        $this->assertNotNull(TransactionCalulatorEwallet::find($createdTransactionCalulatorEwallet['id']), 'TransactionCalulatorEwallet with given id must be in DB');
        $this->assertModelData($transactionCalulatorEwallet, $createdTransactionCalulatorEwallet);
    }

    /**
     * @test read
     */
    public function testReadTransactionCalulatorEwallet()
    {
        $transactionCalulatorEwallet = $this->makeTransactionCalulatorEwallet();
        $dbTransactionCalulatorEwallet = $this->transactionCalulatorEwalletRepo->find($transactionCalulatorEwallet->id);
        $dbTransactionCalulatorEwallet = $dbTransactionCalulatorEwallet->toArray();
        $this->assertModelData($transactionCalulatorEwallet->toArray(), $dbTransactionCalulatorEwallet);
    }

    /**
     * @test update
     */
    public function testUpdateTransactionCalulatorEwallet()
    {
        $transactionCalulatorEwallet = $this->makeTransactionCalulatorEwallet();
        $fakeTransactionCalulatorEwallet = $this->fakeTransactionCalulatorEwalletData();
        $updatedTransactionCalulatorEwallet = $this->transactionCalulatorEwalletRepo->update($fakeTransactionCalulatorEwallet, $transactionCalulatorEwallet->id);
        $this->assertModelData($fakeTransactionCalulatorEwallet, $updatedTransactionCalulatorEwallet->toArray());
        $dbTransactionCalulatorEwallet = $this->transactionCalulatorEwalletRepo->find($transactionCalulatorEwallet->id);
        $this->assertModelData($fakeTransactionCalulatorEwallet, $dbTransactionCalulatorEwallet->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteTransactionCalulatorEwallet()
    {
        $transactionCalulatorEwallet = $this->makeTransactionCalulatorEwallet();
        $resp = $this->transactionCalulatorEwalletRepo->delete($transactionCalulatorEwallet->id);
        $this->assertTrue($resp);
        $this->assertNull(TransactionCalulatorEwallet::find($transactionCalulatorEwallet->id), 'TransactionCalulatorEwallet should not exist in DB');
    }
}
