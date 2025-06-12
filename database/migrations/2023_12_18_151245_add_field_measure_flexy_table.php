<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldMeasureFlexyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_flexy_page', function (Blueprint $table) {
            $table->integer('measure_id')->after('publication_id')->nullable();
            $table->boolean('is_measure')->after('is_publication')->default(false);
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
            $table->dropColumn(['measure_id', 'is_measure']);
        });
    }
}
