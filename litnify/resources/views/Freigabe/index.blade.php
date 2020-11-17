@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-responsive table-hover table-bordered table-striped text-nowrap">
            <h4>Nicht freigegebene Medien:</h4>
            <thead>
            <tr>
                @foreach($tableBuilder as $key=>$val)
                    <th>{{$val}}</th>
                @endforeach
                <th>Aktionen</th>
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
                            <td class="text-wrap"><a class="render-medium-modal" data-id="{{$med->id}}">{{$med->attributesToArray()[$key]}}</a></td>
                            @break

                            @case('autoren')
                            <td>
                                @foreach(explode(';',$med->autoren) as $autor)
                                    {{$autor}}<br>
                                @endforeach
                            </td>
                            @break

                            @default
                            <td>{{$med->attributesToArray()[$key]}}</td>

                        @endswitch
                    @endforeach
                    <td>{{--Aktionen--}}
                        <form action="{{route('freigabe.update',$med->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-success"><i class="fa fa-share"></i></button>
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            {{ $medien->links() }}
        </div>
    </div>
    @include('Medienverwaltung.mediumModal')
@endsection
