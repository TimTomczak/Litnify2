@extends('layouts.app')

@section('content')
    <div class="sidebar">
        Jahr<br>
        ---<br>
        Format<br>
        ---<br>
        Journal<br>
        ---<br>
    </div>

    <!-- Page content -->
    <div class="content">
        Suchwort: {{ ($request['q']) ?? '-' }}

        <br>

        Result: {{ ($result) ?? '/' }}
    </div>

@endsection
