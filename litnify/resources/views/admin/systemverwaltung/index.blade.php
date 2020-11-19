@extends('layouts.app')

@section('content')


    PHP: @php
            echo PHP_VERSION;
         @endphp
    <br>
    Laravel: {{ App::VERSION() }}


{{$info}}
@endsection
