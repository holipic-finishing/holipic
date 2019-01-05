<?php

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $faker = Faker\Factory::create();

        \App\Models\Transaction::truncate();

        $status = ['RECIVED', 'BEEN_SEEN'];

        $packages = \App\Models\Package::all();
        $feeArr = [];

        foreach ($packages as $p) {
            $feeArr[] = $p['fee'];
        }

        for ($i=0; $i < 2000 ; $i++) {
            $id_rand = $faker->numberBetween(1, 51);
            $amount = $faker->randomNumber(4);
            $fee = $faker->randomElement($feeArr);
            $system_fee = $amount*$fee/100;

            \App\Models\Transaction::create([
                'user_id' => $id_rand,
                'type' => $faker->numberBetween(0, 1), //incomece
                'currency_id' => $faker->numberBetween(1, 3),
                'amount' => $amount,
                'status' => $faker->randomElement($status),
                'company_id' => $id_rand,
                // 'dated' => $faker->dateTimeThisYear(),
                'dated' => $faker->dateTimeBetween($startDate = '-6 months', $endDate = '+6 months', $timezone = null),
                'system_fee' => $system_fee,
                'credit_card_fee' => $faker->randomNumber(3),
                'invoice' => $faker->ean13,
                'title' => $faker->sentence(4)
            ]);
        }
    }
}
