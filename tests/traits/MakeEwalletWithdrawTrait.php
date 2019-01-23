<?php

use Faker\Factory as Faker;
use App\Models\EwalletWithdraw;
use App\Repositories\EwalletWithdrawRepository;

trait MakeEwalletWithdrawTrait
{
    /**
     * Create fake instance of EwalletWithdraw and save it in database
     *
     * @param array $ewalletWithdrawFields
     * @return EwalletWithdraw
     */
    public function makeEwalletWithdraw($ewalletWithdrawFields = [])
    {
        /** @var EwalletWithdrawRepository $ewalletWithdrawRepo */
        $ewalletWithdrawRepo = App::make(EwalletWithdrawRepository::class);
        $theme = $this->fakeEwalletWithdrawData($ewalletWithdrawFields);
        return $ewalletWithdrawRepo->create($theme);
    }

    /**
     * Get fake instance of EwalletWithdraw
     *
     * @param array $ewalletWithdrawFields
     * @return EwalletWithdraw
     */
    public function fakeEwalletWithdraw($ewalletWithdrawFields = [])
    {
        return new EwalletWithdraw($this->fakeEwalletWithdrawData($ewalletWithdrawFields));
    }

    /**
     * Get fake data of EwalletWithdraw
     *
     * @param array $postFields
     * @return array
     */
    public function fakeEwalletWithdrawData($ewalletWithdrawFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'amount' => $fake->word,
            'bank_account_number' => $fake->word,
            'bank_name' => $fake->word,
            'account_holder_name' => $fake->word,
            'iban' => $fake->word,
            'swift_code' => $fake->word,
            'status' => $fake->word,
            'company_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $ewalletWithdrawFields);
    }
}
