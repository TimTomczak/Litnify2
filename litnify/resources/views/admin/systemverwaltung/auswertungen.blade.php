@extends('layouts.app')

@section('content')

    Auswertungen


    <h4>AUSLEIHEN OFFEN</h4>
    <table class="table table-responsive">
        <thead>
        <tr>
            @foreach($ausleihen_offen->first()->toArray() as $key=>$val)
                <th>{{$key}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($ausleihen_offen as $aus)
        <tr>
            @foreach($aus->toArray() as $key=>$val)
                <td>{{$val}}</td>
            @endforeach
        </tr>
        @endforeach
        </tbody>
    </table>


    {{--
    <h4>TOP AUSLEIHEN</h4>
    <table class="table table-responsive">
        <thead>
        <tr>
            <th>Häufigkeit</th>
            @foreach($top_ausleihen->first()->toArray() as $key=>$val)
                <th>{{$key}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($top_ausleihen as $aus)
        <tr>
            <td scope="row">{{$aus->anzahl}}</td>
            @foreach($aus->toArray() as $key=>$val)
                <td>{{$val}}</td>
            @endforeach
        </tr>
        @endforeach
        </tbody>
    </table>
    --}}
@endsection
