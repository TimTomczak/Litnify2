@extends('layouts.app')

@section('metadescription')
    @switch($title)
        @case('oeffnungszeiten')
            "Öffnungszeiten der Bibliothek der meteorologischen Abteilung des Instituts für Geowissenschaften der Uni Bonn | bib | Universität Bonn"
            @break
        @case('faq')
            "FAQ - Fragen und Antworten zu den am häufigsten gestellten fragen an die Bibliothek der meteorologischen Abteilung des Instituts für Geowissenschaften der Uni Bonn | bib | Universität Bonn"
            @break
        @case('impressum')
            "Impressum der Bibliothek der meteorologischen Abteilung des Instituts für Geowissenschaften der Uni Bonn | bib"
            @break
        @case('faq')
            "Kontakt - E-Mail-Adresse - Anschrift - Ansprechpartner - Telefonnummer - Bibliothek der meteorologischen Abteilung des Instituts für Geowissenschaften der Uni Bonn | bib | Universität Bonn"
            @break
        @default
            "Litnify2 - Bibliothek der meteorologischen Abteilung des Instituts für Geowissenschaften der Uni Bonn | bib | Universität Bonn"
    @endswitch
@endsection


@section('content')

{!! $content !!}

@endsection

