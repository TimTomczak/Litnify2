@extends('layouts.app')
@section('content')
    {{--@foreach($merklisten as $merk)
        <p>{{$merk->user_id}}: {{$merk->user->nachname}},{{$merk->user->vorname}}  {{\App\Models\Merkliste::where('user_id',$merk->user_id)->count()}}</p>
    @endforeach--}}
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>ID Nutzer</th>
                <th>Name</th>
                <th>Anzahl Medien auf Merkliste</th>
            </tr>
            </thead>
            <tbody>
            @foreach($merklisten as $merk)
                <tr>
                    <td><a href="{{route('merklistenverleih.show',$merk->user_id)}}">{{$merk->user_id}}</a></td>
                    <td>{{$merk->user->nachname}}, {{$merk->user->vorname}}</td>
                    <td>{{\App\Models\Merkliste::where('user_id',$merk->user_id)->count()}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
