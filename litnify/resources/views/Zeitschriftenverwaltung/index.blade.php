@extends('layouts.app')


@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{route('zeitschrift.create')}}">Neue Zeitschrift erstellen</a>
        <table class="table table-bordered table-responsive table-striped">
            <thead>
            <tr>
                @foreach($zeitschriften->first()->attributestoArray() as $key => $val)
                    <th>{{$key}}</th>
                @endforeach
                <th>Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($zeitschriften as $zeitschrift)
            <tr>
                @foreach($zeitschrift->attributestoArray() as $key => $val)
                    <td>{{$val}}</td>
                @endforeach
                <td>{{--Aktionen--}}
                    <div class="d-flex justify-content-around">
                        <a class="btn btn-primary" href="{{route('zeitschrift.edit',$zeitschrift->id)}}"><i class="fa fa-edit"></i></a>
                        <form action="{{route('zeitschrift.destroy',$zeitschrift->id)}}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Löschen</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div >
            {!! $zeitschriften->links() !!}
        </div>


    </div>



@endsection
