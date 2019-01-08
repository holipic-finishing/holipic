<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->decimal('amount',20,10);
            $table->string('status');
            $table->decimal('system_fee',20,10);
            $table->decimal('credit_card_fee',8,2);
            $table->string('invoice');
            $table->integer('user_id');
            $table->integer('currency_id');
            $table->integer('company_id');
            $table->datetime('dated');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transactions');
    }
}
