@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <table class="table table-responsive table-bordered table-striped">
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
                    @if($key === 'hauptsachtitel')
                        <td><a href="{{route('medium.show',$med['id'])}}">{{$val}}</a></td>
                    @else
                        <td>{{$val}}</td>
                    @endif
                @endforeach
            </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection
