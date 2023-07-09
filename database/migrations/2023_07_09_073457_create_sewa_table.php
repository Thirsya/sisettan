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
        Schema::create('sewa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kelurahan');
            $table->unsignedBigInteger('id_periode');
            $table->unsignedBigInteger('id_tahunSts');
            $table->unsignedBigInteger('id_aktif');
            $table->string('noba');

            $table->foreign('id_kelurahan')->references('id')->on('kelurahan');
            $table->foreign('id_periode')->references('id')->on('periode');
            $table->foreign('id_tahunSts')->references('id')->on('tahun_sts');
            $table->foreign('id_aktif')->references('id')->on('aktif');
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
        Schema::dropIfExists('sewa');
    }
};
