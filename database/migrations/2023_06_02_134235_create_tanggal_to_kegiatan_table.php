<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->date('tanggal')->default(Carbon::now()->format('Y-m-d'))->after('jam_selesai');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            //
        });
    }
};
