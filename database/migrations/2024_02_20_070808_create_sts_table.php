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
        Schema::create('sts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penawaran');
            $table->string('surat_tanda_setor');
            $table->string('surat_pernyataan');
            $table->string('surat_perjanjian');
            $table->string('berita_acara');
            $table->foreign('id_penawaran')->references('id')->on('penawarans');
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
        Schema::dropIfExists('sts');
    }
};
