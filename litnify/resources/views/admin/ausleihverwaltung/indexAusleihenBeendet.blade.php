@extends('layouts.app')
@section('content')
    <div class="container">
        @livewire('search-ausleihen-component',['showAktiv'=>$showAktiv])
@endsection

