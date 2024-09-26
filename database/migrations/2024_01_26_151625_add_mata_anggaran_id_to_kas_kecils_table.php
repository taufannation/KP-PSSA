<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMataAnggaranIdToKasKecilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kas_kecils', function (Blueprint $table) {
            $table->integer('mata_anggaran_id')->after('kode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kas_kecils', function (Blueprint $table) {
            $table->dropForeign(['mata_anggaran_id']);
            $table->dropColumn('mata_anggaran_id');
        });
    }
}
