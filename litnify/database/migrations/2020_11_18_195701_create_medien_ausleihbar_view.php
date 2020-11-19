<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedienAusleihbarView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW ".env('DB_TABLE_PREFIX','laravel')."medien_ausleihbar AS
                                SELECT inv.*
                                FROM ".env('DB_TABLE_PREFIX','laravel')."ausleihen aus
                                RIGHT JOIN ".env('DB_TABLE_PREFIX','laravel')."inventarliste inv
                                ON aus.medium_id=inv.medium_id AND aus.inventarnummer=inv.inventarnummer
                                WHERE inv.ausleihbar=1
                                AND aus.id is null
                                OR aus.RueckgabeIst IS NOT null
                                AND (aus.medium_id,aus.inventarnummer) NOT IN
                                (SELECT medium_id,inventarnummer
                                    FROM ".env('DB_TABLE_PREFIX','laravel')."ausleihen
                                    WHERE RueckgabeIst IS null)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS ".env('DB_TABLE_PREFIX','laravel')."medien_ausleihbar");
    }
}
