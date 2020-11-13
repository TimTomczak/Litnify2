@extends('layouts.app')

@section('content')

    @foreach ($merkliste as $item)
        <p>{{ ($item->hauptsachtitel) }}</p>
    @endforeach


    {{--
    "id" => 43127
    "literaturart_id" => 1
    "signatur" => ""
    "autoren" => "Hense"
    "hauptsachtitel" => "Recent fluctuat. of troposph. temp. and water vapour content in the tropics."
    "untertitel" => ""
    "enthalten_in" => null
    "erscheinungsort" => ""
    "jahr" => "1988"
    "verlag" => ""
    "isbn" => ""
    "issn" => ""
    "doi" => null
    "inventarnummer" => null
    "auflage" => ""
    "herausgeber" => ""
    "schriftenreihe" => ""
    "zeitschrift_id" => 48
    "band" => "38"
    "seite" => "215"
    "institut" => ""
    "raum_id" => 0
    "bemerkungen" => ""
    "released" => 1
    "old" => 1
    "bibtexkuerzel" => ""
    "deleted" => 0
    "created_at" => null
    "updated_at" => null
    --}}

@endsection

