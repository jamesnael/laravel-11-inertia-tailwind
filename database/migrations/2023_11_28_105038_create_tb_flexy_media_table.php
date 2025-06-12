<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFlexyMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_flexy_media', function (Blueprint $table) {
            $table->id();
            $table->integer('flexy_id')->nullable();
            $table->string('tipe')->nullable();
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('source')->nullable();
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
        Schema::dropIfExists('tb_flexy_media');
    }
}
