<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionCalulatorEwalletsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_calulator_ewallets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->decimal('amount',20,10)->nullable();
            $table->string('status');
            $table->decimal('system_fee',20,10)->nullable();
            $table->decimal('credit_card_fee',8,2)->nullable();
            $table->string('invoice');
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
        Schema::dropIfExists('transaction_calulator_ewallets');
    }
}
