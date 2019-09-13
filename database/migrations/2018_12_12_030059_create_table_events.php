<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acara', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anggota_id');
            $table->datetime('tarikh_terlibat');
            $table->string('perkara');
            $table->string('jenis_acara');
            $table->dateTime('masa_mula');
            $table->dateTime('masa_tamat');
            $table->text('keterangan');
            $table->integer('kelulusan_anggota_id')->unsigned()->nullable();
            $table->datetime('kelulusan_tarikh')->nullable();
            $table->string('status_permohonan')->default('MOHON'); // status 'M' Mohon, 'L' Lulus, 'T' Tolak, 'B' Batal
            $table->softDeletes();
            $table->timestamps();

            $table->index('anggota_id');
            $table->index('jenis_acara');
            $table->index('status_permohonan');
            $table->index('tarikh_terlibat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acara');
    }
}
