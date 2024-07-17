<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplyCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supply_category', function (Blueprint $table) {
            $table->integer('category_type')->nullable()->after('status');
            $table->integer('parent_category')->nullable()->after('category_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supply_category', function (Blueprint $table) {
            $table->dropColumn('category_type');
            $table->dropColumn('parent_category');
        });
    }
}
