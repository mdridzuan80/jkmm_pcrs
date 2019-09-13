<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAnggotaShift extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota_shift', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anggota_id')->unsigned();
            $table->integer('shift_id')->unsigned();
            $table->dateTime('tkh_mula');
            $table->dateTime('tkh_tamat');
            $table->timestamps();

            $table->index('anggota_id');
            $table->index('shift_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggota_shift');
    }
}
