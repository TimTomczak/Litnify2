@extends('layouts.app')
@section('content')
    <div class="container">
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
