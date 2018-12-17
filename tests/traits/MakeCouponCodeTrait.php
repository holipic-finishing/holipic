<?php

use Faker\Factory as Faker;
use App\Models\CouponCode;
use App\Repositories\CouponCodeRepository;

trait MakeCouponCodeTrait
{
    /**
     * Create fake instance of CouponCode and save it in database
     *
     * @param array $couponCodeFields
     * @return CouponCode
     */
    public function makeCouponCode($couponCodeFields = [])
    {
        /** @var CouponCodeRepository $couponCodeRepo */
        $couponCodeRepo = App::make(CouponCodeRepository::class);
        $theme = $this->fakeCouponCodeData($couponCodeFields);
        return $couponCodeRepo->create($theme);
    }

    /**
     * Get fake instance of CouponCode
     *
     * @param array $couponCodeFields
     * @return CouponCode
     */
    public function fakeCouponCode($couponCodeFields = [])
    {
        return new CouponCode($this->fakeCouponCodeData($couponCodeFields));
    }

    /**
     * Get fake data of CouponCode
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCouponCodeData($couponCodeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'code' => $fake->word,
            'discount' => $fake->word,
            'active' => $fake->word,
            'from_date' => $fake->date('Y-m-d H:i:s'),
            'to_date' => $fake->date('Y-m-d H:i:s'),
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $couponCodeFields);
    }
}
