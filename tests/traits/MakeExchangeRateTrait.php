<?php

use Faker\Factory as Faker;
use App\Models\ExchangeRate;
use App\Repositories\ExchangeRateRepository;

trait MakeExchangeRateTrait
{
    /**
     * Create fake instance of ExchangeRate and save it in database
     *
     * @param array $exchangeRateFields
     * @return ExchangeRate
     */
    public function makeExchangeRate($exchangeRateFields = [])
    {
        /** @var ExchangeRateRepository $exchangeRateRepo */
        $exchangeRateRepo = App::make(ExchangeRateRepository::class);
        $theme = $this->fakeExchangeRateData($exchangeRateFields);
        return $exchangeRateRepo->create($theme);
    }

    /**
     * Get fake instance of ExchangeRate
     *
     * @param array $exchangeRateFields
     * @return ExchangeRate
     */
    public function fakeExchangeRate($exchangeRateFields = [])
    {
        return new ExchangeRate($this->fakeExchangeRateData($exchangeRateFields));
    }

    /**
     * Get fake data of ExchangeRate
     *
     * @param array $postFields
     * @return array
     */
    public function fakeExchangeRateData($exchangeRateFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'from_currency_id' => $fake->randomDigitNotNull,
            'to_currency_id' => $fake->randomDigitNotNull,
            'rate' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $exchangeRateFields);
    }
}
