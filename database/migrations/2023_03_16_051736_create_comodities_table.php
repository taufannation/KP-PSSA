<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comodities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comodity_locations_id');
            $table->foreign('comodity_locations_id')->references('id')->on('comodity_locations')->onDelete('cascade');
            $table->string('item_code', 20);
            $table->string('name', 50);
            $table->string('brand', 50)->nullable();
            $table->string('material', 75)->nullable();
            $table->string('date_of_purchase', 50);
            $table->tinyInteger('condition');
            $table->bigInteger('quantity');
            $table->string('price')->nullable();
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('comodities');
    }
}
