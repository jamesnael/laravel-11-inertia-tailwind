<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldApprovalStatusMsKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('ms_karyawan', function (Blueprint $table) {
            $table->string('approval_status')->nullable()->after('status');
            $table->longText('reject_reason')->nullable()->after('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('ms_karyawan', function (Blueprint $table) {
            $table->dropColumn(['approval_status','reject_reason']);
        });
    }
}
