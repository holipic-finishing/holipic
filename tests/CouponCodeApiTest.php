<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CouponCodeApiTest extends TestCase
{
    use MakeCouponCodeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCouponCode()
    {
        $couponCode = $this->fakeCouponCodeData();
        $this->json('POST', '/api/v1/couponCodes', $couponCode);

        $this->assertApiResponse($couponCode);
    }

    /**
     * @test
     */
    public function testReadCouponCode()
    {
        $couponCode = $this->makeCouponCode();
        $this->json('GET', '/api/v1/couponCodes/'.$couponCode->id);

        $this->assertApiResponse($couponCode->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCouponCode()
    {
        $couponCode = $this->makeCouponCode();
        $editedCouponCode = $this->fakeCouponCodeData();

        $this->json('PUT', '/api/v1/couponCodes/'.$couponCode->id, $editedCouponCode);

        $this->assertApiResponse($editedCouponCode);
    }

    /**
     * @test
     */
    public function testDeleteCouponCode()
    {
        $couponCode = $this->makeCouponCode();
        $this->json('DELETE', '/api/v1/couponCodes/'.$couponCode->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/couponCodes/'.$couponCode->id);

        $this->assertResponseStatus(404);
    }
}
