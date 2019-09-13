<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anggota_id');
            $table->dateTime('tarikh');
            $table->integer('shift_id');
            $table->dateTime('check_in')->nullable();
            $table->dateTime('check_out')->nullable();
            $table->dateTime('check_in_mid')->nullable();
            $table->dateTime('check_out_mid')->nullable();
            $table->text('kesalahan')->nullable();
            $table->string('tatatertib_flag');
            $table->timestamps();

            $table->index('anggota_id');
            $table->index('shift_id');
            $table->index('tatatertib_flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('final_attendances');
    }
}
