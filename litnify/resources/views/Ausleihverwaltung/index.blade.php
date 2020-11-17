@extends('layouts.app')
@section('content')
    <div class="container">
        <h4>Aktive Ausliehen</h4>
        <table class="table table-responsive-lg table-hover table-bordered">
            <thead>
            <tr>
                @foreach($tableBuilderAktiv as $key=>$val)
                    <th>{{$val}}</th>
                @endforeach
                <th>Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ausleihenAktiv as $aus)
            <tr>
                @foreach($tableBuilderAktiv as $key=>$val)
                    @switch($key)
                        @case('medium_id')
                        <td><a class="render-medium-modal" data-id="{{$aus->medium_id}}">{{$aus->attributesToArray()[$key]}}</a></td>
                        @break

                        @case('user_id')
                        <td><a href="{{route('ausleihe.show',$aus->user_id)}}">{{$aus->attributesToArray()[$key]}}</a></td>
                        @break

                        @default
                        <td>{{$aus->attributesToArray()[$key]}}</td>
                    @endswitch
                @endforeach
                <td>...</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="container">
        <h4>Beendete Ausliehen</h4>
        <table class="table table-responsive-lg table-hover table-bordered">
            <thead>
            <tr>
                @foreach($tableBuilderBeendet as $key=>$val)
                    <th>{{$val}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($ausleihenBeendet as $aus)
                <tr>
                    @foreach($tableBuilderBeendet as $key=>$val)
                        @switch($key)
                            @case('medium_id')
                            <td>{{--<a data-toggle="modal" href="{{route('medium.show',$val)}}" data-target="#modal">Click me</a>--}}
                                <a class="render-medium-modal" data-id="{{$aus->medium_id}}">{{$aus->attributesToArray()[$key]}}</a></td>
                            @break

                            @case('user_id')
                            <td><a href="{{route('ausleihe.show',$aus->user_id)}}">{{$aus->attributesToArray()[$key]}}</a></td>
                            @break

                            @default
                            <td>{{$aus->attributesToArray()[$key]}}</td>
                        @endswitch

                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @include('Medienverwaltung.mediumModal')
@endsection
