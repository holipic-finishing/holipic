<?php

use App\Models\EwalletWithdraw;
use App\Repositories\EwalletWithdrawRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EwalletWithdrawRepositoryTest extends TestCase
{
    use MakeEwalletWithdrawTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var EwalletWithdrawRepository
     */
    protected $ewalletWithdrawRepo;

    public function setUp()
    {
        parent::setUp();
        $this->ewalletWithdrawRepo = App::make(EwalletWithdrawRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateEwalletWithdraw()
    {
        $ewalletWithdraw = $this->fakeEwalletWithdrawData();
        $createdEwalletWithdraw = $this->ewalletWithdrawRepo->create($ewalletWithdraw);
        $createdEwalletWithdraw = $createdEwalletWithdraw->toArray();
        $this->assertArrayHasKey('id', $createdEwalletWithdraw);
        $this->assertNotNull($createdEwalletWithdraw['id'], 'Created EwalletWithdraw must have id specified');
        $this->assertNotNull(EwalletWithdraw::find($createdEwalletWithdraw['id']), 'EwalletWithdraw with given id must be in DB');
        $this->assertModelData($ewalletWithdraw, $createdEwalletWithdraw);
    }

    /**
     * @test read
     */
    public function testReadEwalletWithdraw()
    {
        $ewalletWithdraw = $this->makeEwalletWithdraw();
        $dbEwalletWithdraw = $this->ewalletWithdrawRepo->find($ewalletWithdraw->id);
        $dbEwalletWithdraw = $dbEwalletWithdraw->toArray();
        $this->assertModelData($ewalletWithdraw->toArray(), $dbEwalletWithdraw);
    }

    /**
     * @test update
     */
    public function testUpdateEwalletWithdraw()
    {
        $ewalletWithdraw = $this->makeEwalletWithdraw();
        $fakeEwalletWithdraw = $this->fakeEwalletWithdrawData();
        $updatedEwalletWithdraw = $this->ewalletWithdrawRepo->update($fakeEwalletWithdraw, $ewalletWithdraw->id);
        $this->assertModelData($fakeEwalletWithdraw, $updatedEwalletWithdraw->toArray());
        $dbEwalletWithdraw = $this->ewalletWithdrawRepo->find($ewalletWithdraw->id);
        $this->assertModelData($fakeEwalletWithdraw, $dbEwalletWithdraw->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteEwalletWithdraw()
    {
        $ewalletWithdraw = $this->makeEwalletWithdraw();
        $resp = $this->ewalletWithdrawRepo->delete($ewalletWithdraw->id);
        $this->assertTrue($resp);
        $this->assertNull(EwalletWithdraw::find($ewalletWithdraw->id), 'EwalletWithdraw should not exist in DB');
    }
}
