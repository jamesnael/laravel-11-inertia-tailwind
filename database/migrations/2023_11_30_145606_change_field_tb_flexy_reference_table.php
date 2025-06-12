<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldTbFlexyReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_flexy_reference_detail', function (Blueprint $table) {
            $table->longText('content')->after('title')->nullable();
            $table->dropColumn(['url','accessed_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_flexy_reference_detail', function (Blueprint $table) {
            $table->dropColumn(['content']);
            $table->string('url')->after('title')->nullable();
            $table->string('accessed_date')->after('title')->nullable();
        });
    }
}
