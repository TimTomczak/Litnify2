@extends('layouts.app')
@section('content')
    <div class="container">
        <table id="medium" class="table table-striped table-bordered table-responsive-lg">
            <tbody>
            @role(2)
                <tr>
                    <td><b>Aktionen</b></td>
                    <td>
                        <div class="d-flex border-0 justify-content-start">
                            <a href="{{route('medium.edit',$medium->id)}}"><button class="{{$aktionenStyles['edit']['button-class']}} mr-1" title="Medium bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button></a>
                            @if($medium->deleted==0)
                                @role(3)
                                <form action="{{route('medium.destroy',$medium->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Medium löschen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                                </form>
                                @endrole
                            @else
                                <form action="{{route('medium.recover',$medium->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="{{$aktionenStyles['reactivate']['button-class']}}" title="Medium wiederherstellen"><i class="{{$aktionenStyles['reactivate']['icon-class']}}"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endrole
            @foreach($tableBuilder as $key=>$val)
                @if(Helper::showField($key,$medium->literaturart->literaturart))
                    <tr>
                        <td><b>{{$val}}</b></td>
                        @switch($key)
                            @case('autoren')
                            <td>
                                @foreach(explode(';',$medium->autoren) as $autor)
                                    @if(strpos($autor,'et al')!==false)
                                        {{$autor}}<br>
                                    @else
                                        <a href="{{route('autor.show',$autor)}}">{{$autor}}</a><br>
                                    @endif
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
                                    <a href="{{$medium->doi}}" target=”_blank”>{{$medium->doi}}</a>
                                @else
                                    {{$medium->doi}}
                                @endif
                            </td>
                            @break

                            @default
                            <td>{{$medium->attributesToArray()[$key]}}</td>
                        @endswitch
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

