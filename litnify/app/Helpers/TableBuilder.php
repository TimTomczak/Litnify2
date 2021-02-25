<?php

namespace App\Helpers;

/**
 * Class TableBuilder
 * @package App\Helpers
 *
 *  Statische Deklaration der anzuzeigenden Spalten der Tabellen
 *  !!!     Die Anzeige erfolgt in der Reihenfolge des Arrays   !!!
 *
 *  Namen entsprechen den Routen/Controllern, in denen die jeweiligen Views mit Tabellen aufgerufen werden
 */
class TableBuilder
{
    public static $tableStyle='table table-bordered table-hover table-responsive-lg table-striped text-nowrap';

    public static $aktionenStyles=[
        'show' => ['button-class'=>'btn btn-primary btn-sm','icon-class'=>'fa fa-search'],
        'edit' => ['button-class'=>'btn btn-success btn-sm','icon-class'=>'fa fa-edit'],
        'delete' => ['button-class'=>'btn btn-danger btn-sm','icon-class'=>'fa fa-minus-circle'],
        'release' => ['button-class'=>'btn btn-info btn-sm','icon-class'=>'fa fa-share'],
        'reactivate' => ['button-class'=>'btn btn-secondary btn-sm border-secondary','icon-class'=>'fa fa-refresh'],
    ];

    public static $logAktionen=[
        'recover' => 'fa fa-refresh',
        'store' => 'fa fa-plus',
        'wakeUp' => 'fa fa-refresh',
        'destroy' => 'fa fa-trash-o',
        'update' => 'fa fa-pencil',
        'createUser' => 'fa fa-plus',
    ];

    public static $medienverwaltungIndex=[
        'id' => 'ID',
        'literaturart_id'=> 'Literaturart',
        'signatur' => 'Signatur',
        'hauptsachtitel' => 'Hauptsachtitel',
        'autoren' => 'Autoren',
        'jahr' => 'Jahr'
    ];

    public static $mediumShow=[
        'id' => 'ID',
        'literaturart_id' => 'Literaturart',
        'signatur' => 'Signatur',
        'autoren' => 'Autoren',
        'hauptsachtitel' => 'Hauptsachtitel',
        'untertitel' => 'Untertitel',
        'enthalten_in' => 'Enthalten in',
        'erscheinungsort' => 'Erscheinungsort',
        'jahr' => 'Jahr',
        'verlag' => 'Verlag',
        'inventarnummer' => 'Inventarnummern',
        'isbn' => 'ISBN',
        'issn' => 'ISSN',
        'doi' => 'DOI',
        'auflage' => 'Auflage',
        'herausgeber' => 'Herausgeber',
        'schriftenreihe' => 'Schriftenreihe',
        'zeitschrift_id' => 'Zeitschrift',
        'band' => 'Band',
        'seite' => 'Seite',
        'institut' => 'Institut',
        'raum_id' => 'Raum',
        'bemerkungen' => 'Bemerkungen',
    ];

    public static $showAutor=[
        'literaturart_id'=> 'Literaturart',
        'signatur' => 'Signatur',
        'hauptsachtitel' => 'Hauptsachtitel',
        'autoren' => 'Autoren',
        'jahr' => 'Jahr'
    ];

    public static $sucheIndex=[
        'literaturart_id'=> 'Literaturart',
        'signatur' => 'Signatur',
        'hauptsachtitel' => 'Hauptsachtitel',
        'autoren' => 'Autoren',
        'jahr' => 'Jahr'
    ];

    public static $zeitschrifenverwaltungIndex=[
        'id' => 'ID',
        'name' => 'Zeitschriftenname',
        'shortcut' => 'Kürzel',
    ];

    public static $ausleihverwaltungIndex_AktiveAusleihen=[
        'id' => 'ID',
        'user_id' => 'ID Nutzer',
        'medium_id' => 'ID Medium',
        'inventarnummer' => 'Inventarnummer',
        'Ausleihdatum' => 'Ausleihdatum',
        'RueckgabeSoll' => 'Rueckgabe-Soll',
        'RueckgabeIst' => 'Rueckgabe-Ist',
        'Verlaengerungen' => 'Verlängerungen',
    ];

    public static $ausleihverwaltungIndex_BeendeteAusleihen=[
        'id' => 'ID',
        'medium_id' => 'ID Medium',
        'user_id' => 'ID Nutzer',
        'Ausleihdatum' => 'Ausleihdatum',
        'RueckgabeSoll' => 'Rueckgabe-Soll',
        'RueckgabeIst' => 'Rueckgabe-Ist',
        'Verlaengerungen' => 'Verlängerungen',
    ];

    // public static $merklistenverleihIndex; ->Manuell erstellte Tabelle
    // public static $merklistenverleiShow; ->Manuell erstellte Tabelle

    public static $direktverleihIndex=[
//        'id' => 'ID',
//        'literaturart_id'=> 'Literaturart',
        'signatur' => 'Signatur',
        'hauptsachtitel' => 'Hauptsachtitel',
        'autoren' => 'Autoren',
        'jahr' => 'Jahr'
    ];

    public static $nutzerverwaltungIndex=[
        'id' => 'ID',
        'nachname' => 'Nachname',
        'vorname' => 'Vorname',
        'email' => 'E-Mail-Adresse',
        'berechtigungsrolle_id' => 'Rolle',
        'created_at' => 'erstellt',
    ];

    public static $top_ausleihen=[
        'anzahl' => 'Häufigkeit',
        'id' => 'ID',
        'literaturart_id'=> 'Literaturart',
        'signatur' => 'Signatur',
        'hauptsachtitel' => 'Hauptsachtitel',
        'autoren' => 'Autoren',
        'jahr' => 'Jahr',
    ];
}
