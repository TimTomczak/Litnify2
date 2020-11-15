@extends('layouts.app')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin-Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('medienverwaltung.index')}}">Medienverwaltung</a></li>
                <li class="breadcrumb-item active" aria-current="page">Medium anzeigen</li>
            </ol>
        </nav>

        <div class="row">
            <a href="{{route('medium.edit',$medium->id)}}" class="btn btn-primary">Bearbeiten <i class="fa fa-edit"></i></a>
            <form action="{{route('medium.destroy',$medium->id)}}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger">Löschen <i class="fa fa-trash"></i></button>
            </form>
        </div>

        <table id="medium" class="table table-striped table-bordered table-responsive-lg">
            <tbody>
            @foreach($medium->attributestoArray() as $key=>$val)
            <tr>
                @switch($key)
                    @case('autoren')
                    <td><b>{{$key}}</b></td>
                    <td>
                        @foreach(explode(';',$val) as $autor)
                            {{$autor}}<br>
                        @endforeach
                    </td>
                    @break

                    @case('inventarnummer')
                        <td><b>{{$key}}</b></td>
                        <td>
                            @if($medium->inventarliste->isNotEmpty())
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Inventarnummer</th>
                                        <th>Ausleihbar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($medium->inventarliste as $mediumAufInventarliste)
                                    <tr>
                                        <td>{{$mediumAufInventarliste->inventarnummer}}</td>
                                        <td>{{$inventarnummernAusleihbar->contains($mediumAufInventarliste->inventarnummer) ? 'Ja' : 'Nein'}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </td>
                    @break

                    @default
                    <td><b>{{$key}}</b></td>
                    <td>{{$val}}</td>
                @endswitch
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
