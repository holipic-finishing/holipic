<?php

use Faker\Factory as Faker;
use App\Models\OrderExchange;
use App\Repositories\OrderExchangeRepository;

trait MakeOrderExchangeTrait
{
    /**
     * Create fake instance of OrderExchange and save it in database
     *
     * @param array $orderExchangeFields
     * @return OrderExchange
     */
    public function makeOrderExchange($orderExchangeFields = [])
    {
        /** @var OrderExchangeRepository $orderExchangeRepo */
        $orderExchangeRepo = App::make(OrderExchangeRepository::class);
        $theme = $this->fakeOrderExchangeData($orderExchangeFields);
        return $orderExchangeRepo->create($theme);
    }

    /**
     * Get fake instance of OrderExchange
     *
     * @param array $orderExchangeFields
     * @return OrderExchange
     */
    public function fakeOrderExchange($orderExchangeFields = [])
    {
        return new OrderExchange($this->fakeOrderExchangeData($orderExchangeFields));
    }

    /**
     * Get fake data of OrderExchange
     *
     * @param array $postFields
     * @return array
     */
    public function fakeOrderExchangeData($orderExchangeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'order_id' => $fake->randomDigitNotNull,
            'exchange_rate_to_dollar' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $orderExchangeFields);
    }
}
