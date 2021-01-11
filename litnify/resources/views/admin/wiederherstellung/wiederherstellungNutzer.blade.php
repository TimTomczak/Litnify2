@extends('layouts.app')

@section('content')
    @livewire('search-users-component',['nutzerverwaltung'=>true,'deleted'=>1])
@endsection
