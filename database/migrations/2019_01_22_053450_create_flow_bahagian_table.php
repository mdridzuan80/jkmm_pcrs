<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowBahagianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flow_bahagian', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dept_id');
            $table->string('flag')->default('BIASA'); // status 'BIASA' Flow biasa, 'KETUA' Flow ketua bahagian/ Unit
            $table->string('ubah_user_id');
            $table->timestamps();

            $table->index('dept_id');
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
        Schema::dropIfExists('flow_bahagian');
    }
}
