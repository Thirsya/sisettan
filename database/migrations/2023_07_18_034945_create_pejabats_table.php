<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('pejabats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jabatan');
            $table->unsignedBigInteger('id_opd');
            $table->string('nama_pejabat')->unique()->nullable();;
            $table->string('nip_pejabat');
            $table->string('no_sk');

            $table->foreign('id_jabatan')->references('id')->on('jabatans');
            $table->foreign('id_opd')->references('id')->on('opds');
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
        Schema::dropIfExists('pejabats');
    }
};
