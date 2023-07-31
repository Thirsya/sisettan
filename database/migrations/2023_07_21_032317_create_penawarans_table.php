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
        Schema::create('penawarans', function (Blueprint $table) {
            $table->id();
            $table->string('id_penawaran')->nullable();
            $table->string('total_luas');
            $table->unsignedBigInteger('idfk_daftar');
            $table->string('id_daftar');
            $table->unsignedBigInteger('idfk_tkd');
            $table->string('id_tkd');
            $table->string('nilai_penawaran');
            $table->string('keterangan')->nullable();

            $table->foreign('idfk_daftar')->references('id')->on('daftars');
            $table->foreign('idfk_tkd')->references('id')->on('tkds');
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
        Schema::dropIfExists('penawarans');
    }
};
