@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Admin-Dashboard</a></li>
            <li class="breadcrumb-item active">Medienverwaltung</li>
        </ol>
        <a href="{{route('medium.create','')}}"><button type="submit" class="btn btn-primary">Neues Medium erstellen</button></a>
        <table class="table table-responsive table-hover table-bordered table-striped text-nowrap">
            <thead>
            <tr>
                @foreach($medien->first()->toArray() as $key=>$val)
                <th>{{$key}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($medien->toArray() as $med)
            <tr>
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
