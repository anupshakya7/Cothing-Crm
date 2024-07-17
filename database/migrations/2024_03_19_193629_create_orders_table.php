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
            $table->id();
            $table->integer('customer_id');
            $table->string('customer_name');
            $table->date('ordered_date');
            $table->string('customer_contact_number');
            $table->string('delivery_address');
            $table->text('delivery_remarks')->nullable();
            $table->unsignedBigInteger('product_id'); // assuming it's a foreign key
            $table->integer('measurement_id');
            $table->integer('quantity');
            $table->double('price');
            $table->double('delivery_charge')->nullable();
            $table->string('order_id');
            $table->text('order_notes')->nullable();
            $table->unsignedBigInteger('handled_by'); // assuming it's a foreign key
            $table->string('status');
            $table->string('priority');
            $table->double('advance')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->date('payment_date')->nullable(); // assuming it can be nullable
            $table->integer('delivery_partner_id')->nullable();
            $table->date('delivery_date')->nullable();
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
