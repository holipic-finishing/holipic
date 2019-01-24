<?php

use Illuminate\Database\Seeder;

class EwalletWithdrawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        \App\Models\EwalletWithdraw::truncate();
        $faker = Faker\Factory::create();

        $amount = [10, 20 , 30];
        $status = ['PENDING', 'DONE' , 'CANCEL'];
        $listcompany = [];
        $companies = \App\Models\Company::all();
        foreach ($companies as $key => $company) {
        	array_push($listcompany, $company->id);
        }

        for($i = 0 ; $i <= 100 ; $i++ ){
            $company_id = $faker->randomElement($listcompany);

            \App\Models\EwalletWithdraw::create([
                'amount' => $faker->randomElement($amount),
                'bank_account_number' => '123456789',
                'bank_name' => 'HSBC',
                'account_holder_name' => 'Hoa Tran SuperMen',
                'iban' => '123-456-789',
                'swift_code' => '987-654-321',
                'status' => $faker->randomElement($status),
                'company_id' => $company_id,

            ]);
            sleep(1);
        }
    }
}
