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
            $table->decimal('total_amount', 30, 15)->nullable();
            $table->datetime('purchase_date')->nullable();
            $table->datetime('download_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('purchase_from')->nullable();
            $table->string('status');
            $table->string('invoice')->nullable();
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
