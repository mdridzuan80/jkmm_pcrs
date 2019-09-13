<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFlowAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flow_anggota', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anggota_id');
            $table->string('flag')->default('INHERIT'); // status 'INHERIT' ikut Flow Jabatan, 'BIASA' Flow biasa, 'KETUA' Flow ketua bahagian/ Unit
            $table->string('ubah_user_id');
            $table->timestamps();

            $table->index('anggota_id');
            $table->index('flag');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flow_anggota');
    }
}
