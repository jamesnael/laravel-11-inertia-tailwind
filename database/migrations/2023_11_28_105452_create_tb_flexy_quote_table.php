<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFlexyQuoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_flexy_quote', function (Blueprint $table) {
            $table->id();
            $table->integer('flexy_id')->nullable();
            $table->string('tipe')->nullable();
            $table->string('quote')->nullable();
            $table->string('author')->nullable();
            $table->integer('position')->nullable();
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
        Schema::dropIfExists('tb_flexy_quote');
    }
}
