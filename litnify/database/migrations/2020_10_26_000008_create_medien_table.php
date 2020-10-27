<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medien', function (Blueprint $table) {
            $table->id();
            $table->foreignId('literaturart_id')->nullable()->references('id')->on('literaturarten');
            $table->string('signatur')->nullable();
            $table->string('autoren')->nullable();
            $table->string('hauptsachtitel'); //Pflichtfeld, daher nicht nullable
            $table->string('untertitel')->nullable();
            $table->string('enthalten_in')->nullable();
            $table->string('erscheinungsort')->nullable();
            $table->string('jahr'); //Pflichtfeld
            $table->string('verlag')->nullable();
            $table->string('isbn')->nullable();
            $table->string('issn')->nullable();
            $table->string('doi')->nullable();
            $table->string('inventarnummer')->nullable();
            $table->string('auflage')->nullable();
            $table->string('herausgeber')->nullable();
            $table->string('schriftenreihe')->nullable();
            $table->foreignId('zeitschrift_id')->nullable()->references('id')->on('zeitschriften');//"Journal"
            $table->string('band')->nullable();
            $table->string('seite')->nullable();
            $table->string('institut')->nullable();
            $table->foreignId('raum_id')->nullable()->references('id')->on('raeume'); //"Standort"
            $table->text('bemerkungen')->nullable();

            $table->tinyInteger('released')->nullable();
//            $table->timestamp('veroeffentlicht')->nullable(); //ehemals released
            $table->tinyInteger('old')->nullable(); //TODO: noch benötigt ?
//            $table->foreignId('journale')->nullable()->references('id')->on('journale');
            $table->string('bibtexkuerzel')->nullable(); //TODO: noch benötigt ?
            $table->tinyInteger('deleted')->nullable();
//            $table->timestamp('geloescht')->nullable(); //ehemals: deleted

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
        Schema::dropIfExists('medien');
    }
}
