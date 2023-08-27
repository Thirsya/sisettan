<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daftars', function (Blueprint $table) {
            $table->id();
            $table->string('id_daftar')->nullable();
            $table->unsignedBigInteger('id_kelurahan');
            $table->string('no_urut');
            $table->string('nama');
            $table->string('alamat');
            $table->string('no_kk');
            $table->string('no_wp')->nullable();
            $table->date('tgl_perjanjian')->nullable();
            $table->softDeletes();
            $table->foreign('id_kelurahan')->references('id')->on('kelurahans');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daftars');
    }
};
