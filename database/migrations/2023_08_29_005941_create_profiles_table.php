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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_pejabat')->nullable();
            $table->unsignedBigInteger('id_kecamatan')->nullable();
            $table->string('hk');

            $table->foreign('id_kecamatan')->references('id')->on('kecamatans');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_pejabat')->references('id')->on('pejabats');
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
        Schema::dropIfExists('profiles');
    }
};
