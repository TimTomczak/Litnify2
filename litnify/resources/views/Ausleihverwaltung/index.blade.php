@extends('layouts.app')
@section('content')
    <div class="container">
        <h4>Aktive Ausliehen</h4>
        <table class="table table-responsive-lg table-hover table-bordered">
            <thead>
            <tr>
                @foreach($ausleihenAktiv->first()->attributesToArray() as $key => $val)
                    <th>{{$key}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($ausleihenAktiv as $aus)
            <tr>
                @foreach($aus->attributesToArray() as $key=>$val)
                    @switch($key)
                        @case('medium_id')
                        <td><a href="{{route('medium.show',$val)}}">{{$val}}</a></td>
                        @break

                        @case('user_id')
                        <td><a href="{{--TODO Link zu Ausleihen des Nutzers ?--}}">{{$val}}</a></td>
                        @break

                        @default
                        <td>{{$val}}</td>
                    @endswitch
                @endforeach
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
                @foreach($ausleihenBeendet->first()->attributesToArray() as $key => $val)
                    <th>{{$key}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($ausleihenBeendet as $aus)
                <tr>
                    @foreach($aus->attributesToArray() as $key=>$val)
                        @switch($key)
                            @case('medium_id')
                            <td><a href="{{route('medium.show',$val)}}">{{$val}}</a></td>
                            @break

                            @case('user_id')
                            <td><a href="{{--TODO Link zu Ausleihen des Nutzers ?--}}">{{$val}}</a></td>
                            @break

                            @default
                            <td>{{$val}}</td>
                        @endswitch

                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
