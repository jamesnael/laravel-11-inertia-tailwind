<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFlexyReferenceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_flexy_reference_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('flexy_id')->nullable();
            $table->string('flexy_reference_id')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->string('accessed_date')->nullable();
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
        Schema::dropIfExists('tb_flexy_reference_detail');
    }
}
