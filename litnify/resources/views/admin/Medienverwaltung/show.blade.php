@extends('layouts.app')
@section('content')
    <div class="container">
        <table id="medium" class="table table-striped table-bordered table-responsive-lg">
            <tbody>
            @foreach($tableBuilder as $key=>$val)
            <tr>
                <td><b>{{$val}}</b></td>
                @switch($key)
                    @case('autoren')
                    <td>
                        @foreach(explode(';',$medium->autoren) as $autor)
                            <a href="{{route('autor.show',$autor)}}">{{$autor}}</a><br>
                        @endforeach
                    </td>
                    @break

                    @case('inventarnummer')
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

                    @case('doi')
                    <td>
                        @if(filter_var($medium->doi, FILTER_VALIDATE_URL))
                            <a href="{{$medium->doi}}">{{$medium->doi}}</a>
                        @else
                            {{$medium->doi}}
                        @endif
                    </td>
                    @break

                    @default
                    <td>{{$medium->attributesToArray()[$key]}}</td>
                @endswitch
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

