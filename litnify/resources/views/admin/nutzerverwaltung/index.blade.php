@extends('layouts.app')

@section('content')

    <div class="container">
        @livewire('search-users-component',['nutzerverwaltung'=>true,'deleted'=>0])
    </div>
@endsection
