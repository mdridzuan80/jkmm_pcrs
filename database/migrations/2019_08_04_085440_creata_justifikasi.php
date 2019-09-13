<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreataJustifikasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('justifikasi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('final_attendance_id');
            $table->integer('basedept_id');
            $table->datetime('tarikh');
            $table->text('keterangan');
            $table->string('medan_kesalahan');
            $table->string('flag_justifikasi')->default('XSAMA');
            $table->string('flag_kelulusan')->default('MOHON');
            $table->integer('pelulus_id')->nullable();
            $table->timestamps();

            $table->unique(['final_attendance_id', 'tarikh', 'medan_kesalahan']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('justifikasi');
    }
}
