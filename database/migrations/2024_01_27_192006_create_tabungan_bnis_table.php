<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabunganBnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabungan_bnis', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_transaksi');
            $table->string('kode')->nullable();
            $table->string('nama_transaksi');
            $table->string('debet');
            $table->string('kredit');
            $table->string('saldo')->nullable();
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
        Schema::dropIfExists('tabungan_bnis');
    }
}
