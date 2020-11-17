@extends('layouts.app')

@section('content')

    <ul>
    @foreach ($ausleihe as $item)
        <li>{{ ($item->hauptsachtitel) }}</li>
    @endforeach
    </ul>

@endsection

{{--

[{
"id":120488,
"literaturart_id":2,
"signatur":"MAT5-GER",
"autoren":"Gerya, Taras V.",
"hauptsachtitel":"Introduction to numerical geodynamic modelling",
"untertitel":"",
"enthalten_in":null,
"erscheinungsort":"Cambridge [u.a.]",
"jahr":"2010",
"verlag":"Cambridge Univ. Press",
"isbn":"978-0-521-88754-0",
"issn":"",
"doi":null,
"inventarnummer":null,
"auflage":" ",
"herausgeber":"",
"schriftenreihe":"",
"zeitschrift_id":null,
"band":"",
"seite":"XI, 345 S.",
"institut":"",
"raum_id":1,
"bemerkungen":"5 Exemplare Interne Studienbibliothek",
"released":1,
"old":0,
"bibtexkuerzel":"",
"deleted":0,
"created_at":null,
"updated_at":null,
"pivot":{"user_id":2,"medium_id":120488,"id":16,"inventarnummer":"3\/176\/10","Ausleihdatum":"2020-11-15","RueckgabeSoll":"2020-12-13","RueckgabeIst":null,"Verlaengerungen":0}}]

--}}
