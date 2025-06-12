<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTbFlexypageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_flexy_page', function (Blueprint $table) {
            $table->boolean('is_event')->after('is_law')->default(false);
            $table->integer('event_id')->after('country_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_flexy_page', function (Blueprint $table) {
            $table->dropColumn(['is_event','event_id']);
        });
    }
}
