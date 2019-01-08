<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_id');
            $table->integer('photographer_id');
            $table->integer('customer_id');
            $table->decimal('total_amount');
            $table->datetime('purchase_date');
            $table->datetime('download_date');
            $table->string('payment_method');
            $table->string('purchase_from');
            $table->integer('status');
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
        Schema::drop('orders');
    }
}
