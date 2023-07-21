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
        Schema::create('tkds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kelurahan');
            $table->string('bidang');
            $table->string('letak');
            $table->string('bukti');
            $table->string('harga_dasar');
            $table->string('luas');
            $table->string('keterangan')->nullable();
            $table->string('nop')->nullable();

            $table->foreign('id_kelurahan')->references('id')->on('kelurahans');
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
        Schema::dropIfExists('tkds');
    }
};
