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

        $status = ['RECIVED', 'DONE'];
        $packages = \App\Models\Package::all();

        $feeArr = [];

        foreach ($packages as $p) {
            $feeArr[] = $p['fee'];
        }

        for ($i=0; $i < 2000 ; $i++) {
            $id_rand = $faker->numberBetween(2, 31);
            $amount = $faker->randomFloat(2);
            $fee = $faker->randomElement($feeArr);
            $status_rand = $faker->randomElement($status);
            if($status_rand == 'RECIVED'){
                $system_fee = $amount*$fee/100;
            }else{
                $system_fee = 0.000;
            }

            \App\Models\Transaction::create([
                'user_id' => $id_rand,
                'currency_id' => $faker->numberBetween(1, 3),
                'amount' => $amount,
                'status' => $status_rand,
                'company_id' => $id_rand,
                'dated' => $faker->dateTimeBetween($startDate = '-6 months', $endDate = '+8 months', $timezone = null),
                'system_fee' => $system_fee,
                'credit_card_fee' => rand(2,5),
                'invoice' => $faker->ean13,
                'title' => $faker->sentence(4)
            ]);
        }
    }
}
