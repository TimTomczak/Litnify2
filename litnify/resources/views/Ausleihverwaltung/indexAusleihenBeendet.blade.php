@extends('layouts.app')
@section('content')
    <div class="container">
        @livewire('search-ausleihen-component',['showAktiv'=>$showAktiv])
{{--        <h4 class="mr-3">Beendete Ausliehen</h4>--}}
{{--        <table id="ausleihenBeendetTable" class="table table-responsive-lg table-hover table-bordered">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                @foreach($tableBuilderBeendet as $key=>$val)--}}
{{--                    <th>{{$val}}</th>--}}
{{--                @endforeach--}}
{{--                <th>Aktionen</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach($ausleihenBeendet as $aus)--}}
{{--                <tr {{$aus->RueckgabeSoll<$aus->RueckgabeIst ? 'style=background-color:#f9d6d5' : ''}}>--}}
{{--                    @foreach($tableBuilderBeendet as $key=>$val)--}}
{{--                        @switch($key)--}}
{{--                            @case('medium_id')--}}
{{--                            <td>--}}{{--<a data-toggle="modal" href="{{route('medium.show',$val)}}" data-target="#modal">Click me</a>--}}
{{--                                <a class="render-medium-modal" data-id="{{$aus->medium_id}}">{{$aus->attributesToArray()[$key]}}</a></td>--}}
{{--                            @break--}}

{{--                            @case('user_id')--}}
{{--                            <td><a href="{{route('ausleihe.show',$aus->user_id)}}">{{$aus->attributesToArray()[$key]}}</a></td>--}}
{{--                            @break--}}

{{--                            @default--}}
{{--                            <td>{{$aus->attributesToArray()[$key]}}</td>--}}
{{--                        @endswitch--}}

{{--                    @endforeach--}}
{{--                    <td>--}}
{{--                        <div class="d-flex border-0 justify-content-around">--}}
{{--                            <a href="{{route('ausleihe.show',$aus->user_id)}}"><button class="{{$aktionenStyles['show']['button-class']}}" title="Ausleihen des Nutzers ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a>--}}

{{--                            @role(3)--}}
{{--                            <a href="{{route('ausleihe.edit',$aus->id)}}"><button class="{{$aktionenStyles['edit']['button-class']}}" title="Ausleihe bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button></a>--}}
{{--                            <form action="{{route('ausleihe.destroy',$aus->id)}}" method="POST">--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Ausleihe löschen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>--}}
{{--                            </form>--}}
{{--                            @endrole--}}
{{--                        </div>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--        <div class="d-flex justify-content-between">--}}
{{--            {{ $ausleihenBeendet->links() }}--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection

