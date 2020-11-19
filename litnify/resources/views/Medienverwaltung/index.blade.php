@extends('layouts.app')

@section('content')
    <div class="container">

        @if($medien->count()==0)
            <div class="alert alert-info m-2">INFO: Derzeit sind keine Medien in der Datenbank vorhanden !</div>
        @else
            <table class="{{$tableStyle}}">
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
                        <td>
                            <div class="d-flex border-0 justify-content-around">
                                <a href="{{route('medium.show',$med->id)}}"><button class="{{$aktionenStyles['show']['button-class']}}" title="Medium ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a>
                                <a href="{{route('medium.edit',$med->id)}}"><button class="{{$aktionenStyles['edit']['button-class']}}" title="Medium bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button></a>
                                <form action="{{route('medium.destroy',$med->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Medium löschen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                {{ $medien->links() }}
                <a href="{{route('medium.createEmpty','')}}"><button type="submit" class="btn btn-primary">Neues Medium erstellen</button></a>
            </div>
{{--            <table class="table table-responsive table-hover table-bordered table-striped text-nowrap">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    @foreach($medien->first()->attributesToArray() as $key=>$val)--}}
{{--                        @if(array_key_exists( $key,\App\Helpers\TableBuilder::$mediumIndex))--}}
{{--                            <th>{{\App\Helpers\TableBuilder::$mediumIndex[$key]}}</th>--}}
{{--                        @endif--}}
{{--                    --}}{{--<th>{{$key}}</th>--}}
{{--                    @endforeach--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach($medien as $med)--}}
{{--                <tr>--}}
{{--                    @foreach($med->attributesToArray() as $key=>$val)--}}
{{--                        @if(array_key_exists( $key,\App\Helpers\TableBuilder::$mediumIndex))--}}
{{--                            @switch($key)--}}
{{--                                @case('literaturart_id')--}}
{{--                                    <td>{{$med->literaturart->literaturart}}</td>--}}
{{--                                @break--}}

{{--                                @case('zeitschrift_id')--}}
{{--                                    <td>{{$med->zeitschrift!=null ? $med->zeitschrift->name : ''}}</td>--}}
{{--                                @break--}}

{{--                                @case('raum_id')--}}
{{--                                    <td>{{$med->raum!=null ? $med->raum->raum : ''}}</td>--}}
{{--                                @break--}}

{{--                                @case('hauptsachtitel')--}}
{{--                                    <td class="text-wrap"><a class="render-medium-modal" data-id="{{$med->id}}">{{$val}}</a></td>--}}
{{--                                @break--}}

{{--                                @case('autoren')--}}
{{--                                    <td>--}}
{{--                                        @foreach(explode(';',$val) as $autor)--}}
{{--                                            {{$autor}}<br>--}}
{{--                                        @endforeach--}}
{{--                                    </td>--}}
{{--                                @break--}}

{{--                                @default--}}
{{--                                    <td>{{$val}}</td>--}}

{{--                            @endswitch--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </tr>--}}
{{--                @endforeach--}}

{{--                </tbody>--}}
{{--            </table>--}}
        @endif
    </div>
    @include('Medienverwaltung.mediumModal')
@endsection
