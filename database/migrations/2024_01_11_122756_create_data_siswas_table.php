<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSiswasTable extends Migration
{
    public function up()
    {
        Schema::create('data_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('pendidikan_terakhir');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_orangtua');
            $table->text('alamat');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->string('status')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_siswas');
    }
}
