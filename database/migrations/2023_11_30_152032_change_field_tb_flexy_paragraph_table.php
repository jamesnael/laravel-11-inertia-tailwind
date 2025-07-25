<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldTbFlexyParagraphTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('tb_flexy_paragraph', function (Blueprint $table) {
            $table->string('title_size')->after('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('tb_flexy_paragraph', function (Blueprint $table) {
            $table->dropColumn(['title_size']);
        });
    }
}
