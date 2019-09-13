<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldBaseDeptIdFinalAttendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('final_attendances', function (Blueprint $table) {
            $table->integer('basedept_id')->nullable()->after('anggota_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('final_attendances', function (Blueprint $table) {
            $table->dropColumn(['basedept_id']);
        });
    }
}
