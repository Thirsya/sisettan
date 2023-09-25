<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{

    public function up()
    {
        Schema::create('penawarans', function (Blueprint $table) {
            $table->id();
            $table->string('id_penawaran')->nullable();
            $table->integer('total_luas')->nullable();
            $table->unsignedBigInteger('idfk_daftar');
            $table->string('id_daftar');
            $table->unsignedBigInteger('idfk_tkd');
            $table->string('id_tkd');
            $table->string('nilai_penawaran');
            $table->string('keterangan')->nullable();
            $table->boolean('gugur')->default(0);
            $table->softDeletes();

            $table->foreign('idfk_daftar')->references('id')->on('daftars');
            $table->foreign('idfk_tkd')->references('id')->on('tkds');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penawarans');
    }
};
