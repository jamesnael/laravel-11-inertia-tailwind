<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbHomeAboutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_home_about', function (Blueprint $table) {
            $table->id();
            $table->longText('left_text')->nullable();
            $table->string('left_button_label')->nullable();
            $table->string('left_button_link')->nullable();
            $table->longText('right_text')->nullable();
            $table->string('right_button_label')->nullable();
            $table->string('right_button_link')->nullable();
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
        Schema::dropIfExists('tb_home_about');
    }
}
