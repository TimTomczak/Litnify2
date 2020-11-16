@extends('layouts.app')


@section('content')
    <div class="container">
        <table class="table table-bordered table-responsive-lg table-striped">
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
                    <div class="d-flex justify-content-around">
                        <a class="btn btn-primary btn-sm" href="{{route('zeitschrift.edit',$zeitschrift->id)}}"><i class="fa fa-edit"></i></a>
                        <form action="{{route('zeitschrift.destroy',$zeitschrift->id)}}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger">Löschen</button>
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
