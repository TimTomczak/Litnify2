@extends('layouts.app')

@section('content')
    @livewire('search-ausleihen-component',['showAktiv'=>true, 'deleted'=>1])
    <hr>
    <br>
    @livewire('search-ausleihen-component',['showAktiv'=>false, 'deleted'=>1])
@endsection
