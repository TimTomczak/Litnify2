@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <h4>Medien für Autor: {{$autor}}</h4>
            <p></p>
        </div>
        <table class="table table-responsive table-hover table-bordered table-striped text-nowrap">
            <thead>
            <tr>
                @foreach($tableBuilder as $key=>$val)
                    <th>{{$val}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($medien as $med)
                <tr>
                    @foreach($tableBuilder as $key=>$val)
                        @switch($key)
                            @case('literaturart_id')
                            <td>{{$med->literaturart->literaturart}}</td>
                            @break

                            @case('zeitschrift_id')
                            <td>{{$med->zeitschrift!=null ? $med->zeitschrift->name : ''}}</td>
                            @break

                            @case('raum_id')
                            <td>{{$med->raum!=null ? $med->raum->raum : ''}}</td>
                            @break

                            @case('hauptsachtitel')
                            <td class="text-wrap"><a href="#" class="render-medium-modal" data-id="{{$med->id}}">{{$med->attributesToArray()[$key]}}</a></td>
                            @break

                            @case('autoren')
                            <td>
                                @foreach(explode(';',$med->autoren) as $aut)
                                        @if(strpos($aut,$autor)!==false)
                                            <mark><em>{{$aut}}</em></mark>
                                        @else
                                            <a href="{{route('autor.show',$aut)}}">{{$aut}}</a>
                                        @endif
                                    <br>
                                @endforeach
                            </td>
                            @break

                            @default
                            <td>{{$med->attributesToArray()[$key]}}</td>

                        @endswitch
                    @endforeach
                </tr>
            @endforeach

            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            {{ $medien->links() }}
        </div>
    </div>
    @include('admin.medienverwaltung.mediummodal')

@endsection
