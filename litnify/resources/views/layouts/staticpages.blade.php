@extends('layouts.app')

@section('content')

{!! $content !!}

    @if($title == 'impressum')
        <hr>
        @include('layouts.credits')
    @endif



@endsection

