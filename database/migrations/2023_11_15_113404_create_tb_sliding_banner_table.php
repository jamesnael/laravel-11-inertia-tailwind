<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSlidingBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_sliding_banner', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->longText('desktop_banner')->nullable();
            $table->longText('mobile_banner')->nullable();
            
            $table->string('tipe')->nullable();
            $table->integer('position')->default(1);
            $table->boolean('status')->default(false);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
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
        Schema::dropIfExists('tb_sliding_banner');
    }
}
