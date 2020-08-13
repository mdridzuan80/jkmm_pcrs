<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShiftConfs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_confs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anggota_id');
            $table->string('jenis');
            $table->string('pilihan');
            $table->integer('puasa_id')->nullable();
            $table->dateTime('tkh_mula')->nullable();
            $table->dateTime('tkh_tamat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shift_confs');
    }
}
