<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gugurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penawaran');
            $table->unsignedBigInteger('id_daftar');
            $table->unsignedBigInteger('id_tkd');
            $table->string('nilai_penawaran');
            $table->string('keterangan');

            $table->softDeletes();
            $table->foreign('id_penawaran')->references('id')->on('penawarans');
            $table->foreign('id_daftar')->references('id')->on('daftars');
            $table->foreign('id_tkd')->references('id')->on('tkds');
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
        Schema::dropIfExists('gugurs');
    }
};
