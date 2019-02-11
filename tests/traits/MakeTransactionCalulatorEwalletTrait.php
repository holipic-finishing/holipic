<?php

use Faker\Factory as Faker;
use App\Models\TransactionCalulatorEwallet;
use App\Repositories\TransactionCalulatorEwalletRepository;

trait MakeTransactionCalulatorEwalletTrait
{
    /**
     * Create fake instance of TransactionCalulatorEwallet and save it in database
     *
     * @param array $transactionCalulatorEwalletFields
     * @return TransactionCalulatorEwallet
     */
    public function makeTransactionCalulatorEwallet($transactionCalulatorEwalletFields = [])
    {
        /** @var TransactionCalulatorEwalletRepository $transactionCalulatorEwalletRepo */
        $transactionCalulatorEwalletRepo = App::make(TransactionCalulatorEwalletRepository::class);
        $theme = $this->fakeTransactionCalulatorEwalletData($transactionCalulatorEwalletFields);
        return $transactionCalulatorEwalletRepo->create($theme);
    }

    /**
     * Get fake instance of TransactionCalulatorEwallet
     *
     * @param array $transactionCalulatorEwalletFields
     * @return TransactionCalulatorEwallet
     */
    public function fakeTransactionCalulatorEwallet($transactionCalulatorEwalletFields = [])
    {
        return new TransactionCalulatorEwallet($this->fakeTransactionCalulatorEwalletData($transactionCalulatorEwalletFields));
    }

    /**
     * Get fake data of TransactionCalulatorEwallet
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTransactionCalulatorEwalletData($transactionCalulatorEwalletFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'title' => $fake->word,
            'amount' => $fake->word,
            'status' => $fake->word,
            'system_fee' => $fake->word,
            'credit_card_fee' => $fake->word,
            'invoice' => $fake->word,
            'user_id' => $fake->randomDigitNotNull,
            'currency_id' => $fake->randomDigitNotNull,
            'company_id' => $fake->randomDigitNotNull,
            'dated' => $fake->date('Y-m-d H:i:s'),
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $transactionCalulatorEwalletFields);
    }
}
