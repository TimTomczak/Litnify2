@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Admin-Dashboard</a></li>
            <li class="breadcrumb-item active">Medienverwaltung</li>
        </ol>
        <a href="{{route('medium.create','')}}"><button type="submit" class="btn btn-primary">Neues Medium erstellen</button></a>
        @if($medien->count()==0)
            <div class="alert alert-info m-2">INFO: Derzeit sind keine Medien in der Datenbank vorhanden !</div>
        @else
            <table class="table table-responsive table-hover table-bordered table-striped text-nowrap">
                <thead>
                <tr>
                    @foreach($medien->first()->attributesToArray() as $key=>$val)
                    <th>{{$key}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($medien as $med)
                <tr>
                    @foreach($med->attributesToArray() as $key=>$val)
                        @switch($key)
                            @case('hauptsachtitel')
                                <td class="text-wrap"><a class="render-medium-modal" data-id="{{$med->id}}">{{$val}}</a></td>
                            @break

                            @case('autoren')
                                <td>
                                    @foreach(explode(';',$val) as $autor)
                                        {{$autor}}<br>
                                    @endforeach
                                </td>
                            @break

                            @default
                                <td>{{$val}}</td>

                        @endswitch

                    @endforeach
                </tr>
                @endforeach

                </tbody>
            </table>
        @endif
    </div>
    @include('Medienverwaltung.mediumModal')
@endsection
