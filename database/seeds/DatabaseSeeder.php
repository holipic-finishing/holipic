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
        $this->call(CurrenciesTableSeeder::class);
        $this->call(TransactionsTableSeeder::class);
        $this->call(PackagesTableSeeder::class);
        $this->call(CompanysTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
