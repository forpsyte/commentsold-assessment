<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->foreignId('product_id')->references('id')->on('products')->index();
            $table->foreignId('inventory_id')->references('id')->on('inventories')->index();
            $table->string('street_address', 128);
            $table->string('apartment', 32)->nullable();
            $table->string('city', 64);
            $table->string('state', 2);
            $table->string('country_code', 2);
            $table->string('zip', 16);
            $table->string('phone_number', 32);
            $table->string('email', 64);
            $table->string('name', 64);
            $table->string('order_status', 32);
            $table->string('payment_ref', 32)->nullable();
            $table->string('transaction_id', 32)->nullable();
            $table->integer('payment_amount_cents');
            $table->integer('ship_charged_cents')->nullable();
            $table->integer('ship_cost_cents')->nullable();
            $table->integer('subtotal_cents');
            $table->integer('total_cents');
            $table->string('shipper_name', 32);
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('shipped_date')->nullable();
            $table->string('tracking_number', 256);
            $table->integer('tax_total_cents');
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
        Schema::dropIfExists('orders');
    }
}
