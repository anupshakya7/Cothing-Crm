<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->double('total_price')->nullable(); // 8 total digits, 2 digits after decimal point
            $table->double('outstading_price')->nullable(); // 8 total digits, 2 digits after decimal point
            $table->double('receivable_amount')->nullable(); // 8 total digits, 2 digits after decimal point

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
