@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Admin-Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('medienverwaltung.index')}}">Medienverwaltung</a></li>
            <li class="breadcrumb-item active">Freigabe</li>
        </ol>
        <table class="table table-responsive table-hover table-bordered table-striped text-nowrap">
            <h4>Nicht freigegebene Medien:</h4>
            <thead>
            <tr>
                <th>Aktionen</th>
                @foreach($medien->first()->toArray() as $key=>$val)
                    <th>{{$key}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($medien->toArray() as $med)
                <tr>
                    <td>{{--Aktionen--}}
                        <form action="{{route('freigabe.update',$med['id'])}}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-success"><i class="fa fa-share"></i></button>
                        </form>

                    </td>
                    @foreach($med as $key=>$val)
                        @if($key == 'hauptsachtitel')
                            <td class="text-wrap"><a href="{{route('medium.show',$med['id'])}}">{{$val}}</a></td>
                        @else
                            @if($key == 'autoren')
                                <td>
                                    @foreach(explode(';',$val) as $autor)
                                        {{$autor}}<br>
                                    @endforeach
                                </td>
                            @else
                                <td>{{$val}}</td>
                            @endif
                        @endif


                    @endforeach
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection
