<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableXtraUserinfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xtra_userinfo', function (Blueprint $table) {
            $table->integer('anggota_id')->unsigned();
            $table->integer('basedept_id')->nullable()->unsigned();
            $table->string('email')->unique();
            $table->string('nama');
            $table->string('nokp')->unique();
            $table->string('jawatan')->nullable();
            $table->string('dept_id')->nullable()->unsigned();
            $table->string('nohp')->nullable();
            $table->timestamps();

            $table->primary('anggota_id');
            $table->index('basedept_id');
            $table->index('dept_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xtra_userinfo');
    }
}
