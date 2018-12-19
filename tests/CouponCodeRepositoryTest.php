<?php

use App\Models\CouponCode;
use App\Repositories\CouponCodeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CouponCodeRepositoryTest extends TestCase
{
    use MakeCouponCodeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CouponCodeRepository
     */
    protected $couponCodeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->couponCodeRepo = App::make(CouponCodeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCouponCode()
    {
        $couponCode = $this->fakeCouponCodeData();
        $createdCouponCode = $this->couponCodeRepo->create($couponCode);
        $createdCouponCode = $createdCouponCode->toArray();
        $this->assertArrayHasKey('id', $createdCouponCode);
        $this->assertNotNull($createdCouponCode['id'], 'Created CouponCode must have id specified');
        $this->assertNotNull(CouponCode::find($createdCouponCode['id']), 'CouponCode with given id must be in DB');
        $this->assertModelData($couponCode, $createdCouponCode);
    }

    /**
     * @test read
     */
    public function testReadCouponCode()
    {
        $couponCode = $this->makeCouponCode();
        $dbCouponCode = $this->couponCodeRepo->find($couponCode->id);
        $dbCouponCode = $dbCouponCode->toArray();
        $this->assertModelData($couponCode->toArray(), $dbCouponCode);
    }

    /**
     * @test update
     */
    public function testUpdateCouponCode()
    {
        $couponCode = $this->makeCouponCode();
        $fakeCouponCode = $this->fakeCouponCodeData();
        $updatedCouponCode = $this->couponCodeRepo->update($fakeCouponCode, $couponCode->id);
        $this->assertModelData($fakeCouponCode, $updatedCouponCode->toArray());
        $dbCouponCode = $this->couponCodeRepo->find($couponCode->id);
        $this->assertModelData($fakeCouponCode, $dbCouponCode->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCouponCode()
    {
        $couponCode = $this->makeCouponCode();
        $resp = $this->couponCodeRepo->delete($couponCode->id);
        $this->assertTrue($resp);
        $this->assertNull(CouponCode::find($couponCode->id), 'CouponCode should not exist in DB');
    }
}
