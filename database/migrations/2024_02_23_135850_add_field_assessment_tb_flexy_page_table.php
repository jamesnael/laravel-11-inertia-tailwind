<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldAssessmentTbFlexyPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_flexy_page', function (Blueprint $table) {
            $table->boolean('is_assessment')->default(false)->after('is_plastic');
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
            $table->dropColumn(['is_assessment']);
        });
    }
}
