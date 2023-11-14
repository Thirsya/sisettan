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
        Schema::create('daerahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kelurahan');
            $table->unsignedBigInteger('id_kecamatan');
            $table->string('noba')->nullable();
            $table->string('periode')->nullable();
            $table->unsignedBigInteger('thn_sts')->nullable();
            $table->date('tanggal_lelang')->nullable();
            $table->boolean('aktif')->default(0);
            $table->string('surat')->nullable();
            $table->string('surat_shp')->nullable();
            $table->softDeletes();

            $table->foreign('id_kelurahan')->references('id')->on('kelurahans')->restrictOnDelete();
            $table->foreign('id_kecamatan')->references('id')->on('kecamatans')->restrictOnDelete();
            $table->foreign('thn_sts')->references('id')->on('tahuns')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daerahs');
    }
};
