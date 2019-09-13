<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelewatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelewatan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anggota_id');
            $table->integer('shift_id');
            $table->dateTime('check_in');
            $table->integer('send_sms_flag');
            $table->timestamps();

            $table->index('anggota_id');
            $table->index('shift_id');
            $table->index('send_sms_flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelewatan');
    }
}
