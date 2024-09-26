<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisTransaksitabunganIdKeTabungans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tabungans', function (Blueprint $table) {
            $table->integer('jenis_transaksitabungan_id')->after('kategori_tabungan_id');
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
            $table->dropForeign(['jenis_transaksitabungan_id']);
            $table->dropColumn('jenis_transaksitabungan_id');
        });
    }
}
