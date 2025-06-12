<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldEprFlexyPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_flexy_page', function (Blueprint $table) {
            $table->integer('epr_id')->after('zeroplastic_id')->nullable();
            $table->boolean('is_epr')->after('is_zeroplastic')->default(false);
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
            $table->dropColumn(['epr_id', 'is_epr']);
        });
    }
}
