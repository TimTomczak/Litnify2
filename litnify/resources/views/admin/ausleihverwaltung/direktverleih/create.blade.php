@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card text-center bg-light mb-3">
            <div class="card-body">
                <h5 class="card-title">Direktverleih für Nutzer</h5>
                <p class="card-text">{{$user->nachname}}, {{$user->vorname}}</p>
                <p class="card-text">{{$user->email}}</p>
            </div>
        </div>
        @livewire('search-medien-ausleihbar-component',['medien'=>$medien,'user'=>$user])
    </div>
    @include('admin.medienverwaltung.mediumModal')

@endsection
