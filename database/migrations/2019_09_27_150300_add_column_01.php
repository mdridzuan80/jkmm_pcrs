<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumn01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('justifikasi', function (Blueprint $table) {
            $table->string('amggota_id')->nullable()->after('user_id');
            $table->string('perkara')->nullable()->after('keterangan');
            $table->dateTime('tarikh_tamat')->after('tarikh');
            $table->string('kategori')->after('basedept_id');
            $table->integer('user_id')->after('pelulus_id');
            $table->renameColumn('tarikh', 'tarikh_mula');
        });

        Schema::rename('justifikasi', 'acara');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acara', function (Blueprint $table) {
            $table->dropColumn('perkara');
            $table->dropColumn('tarikh_tamat');
            $table->dropColumn('kategori');
            $table->dropColumn('user_id');
            $table->renameColumn('tarikh_mula', 'tarikh');
        });

        Schema::rename('acara', 'justifikasi');
    }
}
