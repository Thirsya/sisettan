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
        Schema::create('temp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_daftar');
            $table->unsignedBigInteger('id_tkd');
            $table->unsignedBigInteger('id_penawaran');
            $table->string('keterangan');

            $table->foreign('id_daftar')->references('id')->on('daftar');
            $table->foreign('id_tkd')->references('id')->on('tkd');
            $table->foreign('id_penawaran')->references('id')->on('penawaran');
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
        Schema::dropIfExists('temp');
    }
};
