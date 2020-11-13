@extends('layouts.app')

@section('content')


    <form action="{{route('admin.systemverwaltung.logs')}}">
        <input type="date" name="date" value="{{$date ? $date->format('Y-m-d') : today()->format('Y-m-d')}}">
        <button class="btn btn-primary" type="submit">Auswählen</button>
    </form>

    <hr>

    @if(empty($data['file']))
    <div>
        <h3>Keine Logs gefunden</h3>
    </div>
    @else
        <div>
            <h5>Letzte Änderung: <b>{{ $data['lastModified']->format('Y-m-d H:i') }}</b></h5>
            <h5>Dateigrösse: <b>{{ (round($data['size']/1024))}} KB</b></h5>
            <br>
            <pre>
                {{ $data['file'] }}
            </pre>
        </div>
    @endif


@endsection
