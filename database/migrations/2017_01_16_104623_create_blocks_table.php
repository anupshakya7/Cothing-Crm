<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('position');
            $table->string('display');
            $table->string('column')->nullable();
            $table->string('filter')->nullable();
            $table->integer('category_id')->default(0);
            $table->integer('limit')->default(0)->nullable();
            $table->boolean('show_title')->default(0)->nullable();
            $table->boolean('published')->default(0)->nullable();
            $table->integer('order')->default(0)->nullable();
            $table->string('style')->nullable();
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
        Schema::dropIfExists('blocks');
    }
}
