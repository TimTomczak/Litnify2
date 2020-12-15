@extends('layouts.app')
@section('content')

    <div class="container">
        @livewire('search-ausleihen-component',['showAktiv'=>$showAktiv])
    </div>

    @include('admin.ausleihverwaltung.resources.views.admin.meedienverwaltung.mediumModal')
@endsection
