<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EwalletWithdrawApiTest extends TestCase
{
    use MakeEwalletWithdrawTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateEwalletWithdraw()
    {
        $ewalletWithdraw = $this->fakeEwalletWithdrawData();
        $this->json('POST', '/api/v1/ewalletWithdraws', $ewalletWithdraw);

        $this->assertApiResponse($ewalletWithdraw);
    }

    /**
     * @test
     */
    public function testReadEwalletWithdraw()
    {
        $ewalletWithdraw = $this->makeEwalletWithdraw();
        $this->json('GET', '/api/v1/ewalletWithdraws/'.$ewalletWithdraw->id);

        $this->assertApiResponse($ewalletWithdraw->toArray());
    }

    /**
     * @test
     */
    public function testUpdateEwalletWithdraw()
    {
        $ewalletWithdraw = $this->makeEwalletWithdraw();
        $editedEwalletWithdraw = $this->fakeEwalletWithdrawData();

        $this->json('PUT', '/api/v1/ewalletWithdraws/'.$ewalletWithdraw->id, $editedEwalletWithdraw);

        $this->assertApiResponse($editedEwalletWithdraw);
    }

    /**
     * @test
     */
    public function testDeleteEwalletWithdraw()
    {
        $ewalletWithdraw = $this->makeEwalletWithdraw();
        $this->json('DELETE', '/api/v1/ewalletWithdraws/'.$ewalletWithdraw->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/ewalletWithdraws/'.$ewalletWithdraw->id);

        $this->assertResponseStatus(404);
    }
}
