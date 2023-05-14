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
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->unsignedBigInteger('pembimbing_lapangan_id')->nullable()->after('lokasi_id');
            $table->foreign('pembimbing_lapangan_id')->references('id')->on('pembimbing_lapangan')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('dosen_pembimbing_id')->nullable()->after('pembimbing_lapangan_id');
            $table->foreign('dosen_pembimbing_id')->references('id')->on('dosen_pembimbing')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            //
        });
    }
};
