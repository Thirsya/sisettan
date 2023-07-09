<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kelurahan');
            $table->string('no_urut');
            $table->string('nama');
            $table->string('no_kk');
            $table->string('no_wp');
            $table->timestamp('tgl_perjanjian')->nullable();

            $table->foreign('id_kelurahan')->references('id')->on('kelurahan');
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
        Schema::dropIfExists('daftar');
    }
};
