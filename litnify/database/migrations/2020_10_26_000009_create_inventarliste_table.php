<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarlisteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarliste', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('medium_id');
            $table->string('inventarnummer');
            $table->tinyInteger('isb')->default(0);
            $table->tinyInteger('ausleihbar')->default(0);
            $table->tinyInteger('deleted')->default(0);
            $table->timestamps();
            $table->unique(['medium_id','inventarnummer']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventarliste');
    }
}
