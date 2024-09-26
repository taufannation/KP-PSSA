<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealisasiAnggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realisasi_anggarans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_transaksi');
            $table->string('kode');
            $table->string('deskripsi');
            $table->string('anggaran');
            $table->string('realisasi');
            $table->string('selisih')->nullable;
            $table->string('persentase')->nullable;
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
        Schema::dropIfExists('realisasi_anggarans');
    }
}
