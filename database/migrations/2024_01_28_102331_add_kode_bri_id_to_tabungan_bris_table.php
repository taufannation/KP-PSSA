<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeBriIdToTabunganBrisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tabungan_bris', function (Blueprint $table) {
            $table->integer('kode_bri_id')->after('kode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tabungan_bris', function (Blueprint $table) {
            $table->dropForeign(['kode_bri_id']);
            $table->dropColumn('kode_bri_id');
        });
    }
}
