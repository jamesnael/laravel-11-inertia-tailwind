<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnForgotPasswordTokenMsKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_karyawan', function (Blueprint $table) {
            $table->string('forgot_password_token')->nullable()->after('reject_reason');
            $table->string('forgot_password_token_lifetime')->nullable()->after('forgot_password_token');
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
            $table->dropColumn(['forgot_password_token', 'forgot_password_token_lifetime']);
        });
    }
}
