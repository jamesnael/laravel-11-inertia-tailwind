<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldFlexyParagraph extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_flexy_paragraph_detail', function (Blueprint $table) {
            $table->string('button_label')->after('icon')->nullable();
            $table->string('button_url')->after('button_label')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_flexy_paragraph_detail', function (Blueprint $table) {
            $table->dropColumn(['button_label','button_url']);
        });
    }
}
