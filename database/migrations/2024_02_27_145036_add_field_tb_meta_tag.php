<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldTbMetaTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_meta_tag', function (Blueprint $table) {
            $table->string('route_slug')->after('description')->nullable();
            $table->string('controller_name')->after('route_slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_meta_tag', function (Blueprint $table) {
            $table->dropColumn(['route_slug','controller_name']);
        });
    }
}
