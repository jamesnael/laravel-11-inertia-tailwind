<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFlexyParagraphDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_flexy_paragraph_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('flexy_id')->nullable();
            $table->integer('flexy_paragraph_id')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
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
        Schema::dropIfExists('tb_flexy_paragraph_detail');
    }
}
