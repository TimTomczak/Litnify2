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
    public static $medienverwaltungIndex=[
        'id' => 'ID',
        'signatur' => 'Signatur',
        'hauptsachtitel' => 'Hauptsachtitel',
    ];

    public static $zeitschrifenverwaltungIndex=[
        'id' => 'ID',
        'name' => 'Zeitschriftenname',
        'shortcut' => 'Kürzel',
    ];

    public static $ausleihverwaltungIndex_AktiveAusleihen=[
        'id' => 'ID',
        'medium_id' => 'ID Medium',
        'user_id' => 'ID Nutzer',
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

    public static $nutzerverwaltungIndex=[
        'id' => 'ID',
        'nachname' => 'Nachname',
        'vorname' => 'Vorname',
        'email' => 'E-Mail-Adresse',
        'berechtigungsrolle_id' => 'Rolle',
        'created_at' => 'erstellt',
    ];
}
