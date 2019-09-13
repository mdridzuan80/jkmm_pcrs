<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePegawaiPenilai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai_penilai', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anggota_id')->unsigned();
            $table->integer('pegawai_id')->unsigned();
            $table->integer('pegawai_flag')->unsigned();
            $table->timestamps();

            //indexing
            $table->index('anggota_id');
            $table->index('pegawai_id');
            $table->unique(['anggota_id', 'pegawai_flag']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai_penilai');
    }
}
