<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAusleihenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ausleihen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medium_id')->references('id')->on('medien');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('inventarnummer');
            $table->date('Ausleihdatum');
            $table->date('RueckgabeSoll');
            $table->date('RueckgabeIst')->nullable();
            $table->integer('Verlaengerungen')->default(0);
            $table->tinyInteger('deleted')->default(0);
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
        Schema::dropIfExists('ausleihen');
    }
}
