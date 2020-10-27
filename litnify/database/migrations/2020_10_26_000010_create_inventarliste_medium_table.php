<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarlisteMediumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarliste_medium', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medium_id')->references('id')->on('medien');
            $table->foreignId('inventarliste_id')->references('id')->on('inventarliste');
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
        Schema::dropIfExists('inventarliste_medium');
    }
}
