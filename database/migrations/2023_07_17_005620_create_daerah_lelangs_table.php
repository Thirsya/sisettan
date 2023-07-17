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
        Schema::create('daerah_lelangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kelurahan');
            $table->unsignedBigInteger('id_kecamatan');
            $table->date('tanggal_lelang')->nullable();

            $table->foreign('id_kelurahan')->references('id')->on('kelurahans')->restrictOnDelete();
            $table->foreign('id_kecamatan')->references('id')->on('kecamatans')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daerah_lelangs');
    }
};
