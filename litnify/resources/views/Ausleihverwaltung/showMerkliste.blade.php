@extends('layouts.app')
@section('content')
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>ID Medium</th>
                <th>Hauptsachtitel</th>
                <th>Gemerkt am:</th>
                <th>Aktion</th>
            </tr>
            </thead>
            <tbody>
            @foreach($merkliste as $merk)
            <tr>
                <td>{{$merk->id}}</td>
                <td>{{$merk->hauptsachtitel}}</td>
                <td>{{$merk->created_at}}</td>
                @if($merk->inventarliste->first()) {{--TODO ist ausleihbar prüfen --}}
                <td>{{$merk->inventarliste}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>


    </div>
@endsection
