@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{route('medium.edit',$medium->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
        <table class="table table-striped table-bordered">
            <tbody>
            @foreach($medium->toArray() as $key=>$val)
            <tr>
                <td><b>{{$key}}</b></td>
                <td>{{$val}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
