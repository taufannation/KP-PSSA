<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKategoriTabunganIdToMataAnggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tabungans', function (Blueprint $table) {
            $table->integer('kategori_tabungan_id')->after('kode');
            // $table->foreign('kategori_tabungan_id')->references('id')->on('tabungans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tabungans', function (Blueprint $table) {
            $table->dropForeign(['kategori_tabungan_id']);
            $table->dropColumn('kategori_tabungan_id');
        });
    }
}
