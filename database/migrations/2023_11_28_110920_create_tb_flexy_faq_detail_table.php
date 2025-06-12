<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFlexyFaqDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_flexy_faq_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('flexy_id')->nullable();
            $table->integer('flexy_faq_id')->nullable();
            $table->string('question')->nullable();
            $table->string('answer')->nullable();
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
        Schema::dropIfExists('tb_flexy_faq_detail');
    }
}
