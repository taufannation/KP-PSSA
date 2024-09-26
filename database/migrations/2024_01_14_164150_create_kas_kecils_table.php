<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasKecilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kas_kecils', function (Blueprint $table) {
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
        Schema::dropIfExists('kas_kecils');
    }
}
















// <?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class CreateKasKecilsTable extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::create('kas_kecils', function (Blueprint $table) {
//             $table->id();
//             $table->date('tanggal_transaksi');
//             $table->string('no_transaksi');
//             $table->string('nama_transaksi');
//             $table->decimal('debet', 15, 2);
//             $table->decimal('kredit', 15, 2);
//             $table->decimal('saldo', 15, 2)->nullable();
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::dropIfExists('kas_kecils');
//     }
// }
