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
        Schema::create('tkd', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kelurahan');
            $table->unsignedBigInteger('id_bidang');
            $table->string('bukti');
            $table->string('hd');
            $table->string('keterangan');
            $table->string('nop');

            $table->foreign('id_kelurahan')->references('id')->on('kelurahan');
            $table->foreign('id_bidang')->references('id')->on('bidang');
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
        Schema::dropIfExists('tkd');
    }
};
