<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPengajarsTable extends Migration
{
    public function up()
    {
        Schema::create('data_pengajars', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->string('no_ktp')->nullable(); // No KTP diizinkan bernilai null
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->integer('usia');
            $table->text('alamat')->nullable(); // Alamat diizinkan bernilai null
            $table->string('jabatan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_pengajars');
    }
}
