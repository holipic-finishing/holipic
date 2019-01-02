<?php

use Faker\Factory as Faker;
use App\Models\TransactionExchange;
use App\Repositories\TransactionExchangeRepository;

trait MakeTransactionExchangeTrait
{
    /**
     * Create fake instance of TransactionExchange and save it in database
     *
     * @param array $transactionExchangeFields
     * @return TransactionExchange
     */
    public function makeTransactionExchange($transactionExchangeFields = [])
    {
        /** @var TransactionExchangeRepository $transactionExchangeRepo */
        $transactionExchangeRepo = App::make(TransactionExchangeRepository::class);
        $theme = $this->fakeTransactionExchangeData($transactionExchangeFields);
        return $transactionExchangeRepo->create($theme);
    }

    /**
     * Get fake instance of TransactionExchange
     *
     * @param array $transactionExchangeFields
     * @return TransactionExchange
     */
    public function fakeTransactionExchange($transactionExchangeFields = [])
    {
        return new TransactionExchange($this->fakeTransactionExchangeData($transactionExchangeFields));
    }

    /**
     * Get fake data of TransactionExchange
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTransactionExchangeData($transactionExchangeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'transaction_id' => $fake->randomDigitNotNull,
            'exchange_rate_dollar' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $transactionExchangeFields);
    }
}
