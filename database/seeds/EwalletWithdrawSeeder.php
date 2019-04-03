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

        $amount = [10, 15, 20, 25 , 30];
        $status = ['PENDING', 'DONE' , 'CANCEL'];
        $listcompany = [];
        $companies = \App\Models\Company::all();
        $id_banks = ['Bank Rakyat Indonesia (BRI)' ,'Bank Mandiri', 'Bank Central Asia (BCA)', 'Bank Negara Indonesia (BNI)', 'Bank CIMB Niaga', 'Bank Tabungan Negara (BTN)', 'Bank Panin', 'Bank Permata', 'Bank Internasional Indonesia (BII)', 'Maybank', 'Bank Danamon', 'HSBC'];

        foreach ($companies as $key => $company) {
        	array_push($listcompany, $company->id);
        }

        for($i = 0 ; $i <= 100 ; $i++ ){
            $company_id = $faker->randomElement($listcompany);

            $fk = new Faker\Generator();
            $payment = new Faker\Provider\en_US\Payment($fk);

            \App\Models\EwalletWithdraw::create([
                'amount'                => $faker->randomElement($amount),
                'bank_account_number'   => $payment->bankAccountNumber(),
                'bank_name'             => $faker->randomElement($id_banks),
                'account_holder_name'   => $faker->name,
                'iban'                  => $faker->iban(+62),
                'swift_code'            => $faker->swiftBicNumber,
                'status'                => $faker->randomElement($status),
                'company_id'            => $company_id,

            ]);
            sleep(1);
        }
    }
}
