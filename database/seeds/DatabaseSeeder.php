<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(CompanysTableSeeder::class);
        // $this->call(PackagesTableSeeder::class);
        // $this->call(CurrenciesTableSeeder::class);
        // $this->call(CouponCodeTableSeeder::class);
        // $this->call(ExchangeRatesTableSeeder::class);

        /**
         *
         * Don't run seed of TransactionsTableSeeder, RoomsTableSeeder
         *
         */

        // $this->call(TransactionsTableSeeder::class);
        // $this->call(RoomsTableSeeder::class);

        // $this->call(CompanyPackagesTableSeeder::class);
        // $this->call(PhotoPackagesTableSeeder::class);
        // $this->call(BranchesTableSeeder::class);
        // $this->call(PhotographersTableSeeder::class);
        // $this->call(PagesTableSeeder::class);
        // $this->call(SettingsTableSeeder::class);
        // $this->call(CustomersTableSeeder::class);
        // $this->call(BookingsTableSeeder::class);
        // $this->call(OrderTableSeeder::class);

        /**
         * Seed Withdraw
         */
        // $this->call(EwalletWithdrawSeeder::class);
        // $this->call(TimezonesTableSeeder::class);

        /**
         * Seed Image
         */
        // $this->call(ListingsTableSeeder::class);

        $this->call(ImagesTableSeeder::class);
    }
}
