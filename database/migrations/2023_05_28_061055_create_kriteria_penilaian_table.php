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
        Schema::create('kriteria_penilaian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id')->nullable();
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('cascade')->onUpdate('cascade');
            $table->char('inovasi',1)->nullable();
            $table->char('kerja_sama',1)->nullable();
            $table->char('disiplin',1)->nullable();
            $table->char('inisiatif',1)->nullable();
            $table->char('kerajinan',1)->nullable();
            $table->char('sikap',1)->nullable();
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
        Schema::dropIfExists('kriteria_penilaian');
    }
};
