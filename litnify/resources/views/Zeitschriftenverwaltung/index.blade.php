@extends('layouts.app')


@section('content')
    <div class="container">
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
            @foreach($zeitschriften as $zeitschrift)
            <tr>

                @foreach($tableBuilder as $key=>$val)
                    <td>{{$zeitschrift->attributesToArray()[$key]}}</td>
                @endforeach
                <td>{{--Aktionen--}}
                    <div class="d-flex border-0 justify-content-around">
                        <a href="{{route('zeitschrift.edit',$zeitschrift->id)}}"><button class="{{$aktionenStyles['edit']['button-class']}}" title="Medium bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button></a>
                        <form action="{{route('zeitschrift.destroy',$zeitschrift->id)}}" method="POST">
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

        {{-- Pagination --}}
        <div class="d-flex justify-content-between">
            {{ $zeitschriften->links() }}
            <a href="{{route('zeitschrift.create')}}"><button class="btn btn-primary">Neue Zeitschrift erstellen</button></a>
        </div>


    </div>



@endsection
