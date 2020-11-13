@extends('layouts.app')
@section('content')
    <div class="container">
        <h4 class="">Merkliste von [{{$user->nachname}}, {{$user->vorname}} (ID: {{$user->id}})]</h4>
        <table class="table">
            <thead>
            <tr>
                <th>ID Medium</th>
                <th>Hauptsachtitel</th>
                <th>Gemerkt am:</th>
                <th>ausleihbar</th>
                <th>Aktion</th>
            </tr>
            </thead>
            <tbody>
            @foreach($merkliste as $merk)
                <tr>
                    <td>{{$merk->id}}</td>
                    <td>{{$merk->hauptsachtitel}}</td>
                    <td>{{$merk->pivot->created_at==null ? '-' : $merk->pivot->created_at->format("d.m.Y")}}</td>
                    <td>{{$merk->isAusleihbar()==true ? 'Ja' : 'Nein'}}</td>
                    <td>
                        @if($merk->isAusleihbar()==true)
                            @livewire('ausleihe-component', ['medium'=>$merk])
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

<!-- Button trigger modal -->



