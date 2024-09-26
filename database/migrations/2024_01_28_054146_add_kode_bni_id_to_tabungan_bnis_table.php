<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeBniIdToTabunganBnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tabungan_bnis', function (Blueprint $table) {
            $table->integer('kode_bni_id')->after('kode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tabungan_bnis', function (Blueprint $table) {
            $table->dropForeign(['kode_bni_id']);
            $table->dropColumn('kode_bni_id');
        });
    }
}
