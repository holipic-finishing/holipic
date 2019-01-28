<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEwalletWithdrawsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ewallet_withdraws', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount');
            $table->string('bank_account_number');
            $table->string('bank_name');
            $table->string('account_holder_name');
            $table->string('iban');
            $table->string('swift_code');
            $table->string('status');
            $table->integer('company_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ewallet_withdraws');
    }
}
