@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="https://eu.ui-avatars.com/api/?name={{$user['vorname'] .'+'. $user['nachname']}}&background=0F539D&color=fff&bold=true&size=150" class="rounded-circle">
                            <div class="mt-3">
                                <h4>{{ucfirst($user->vorname) ." ". ucfirst($user->nachname)}}</h4>
                                <p class="text-secondary mb-1">
                                    Account: {{ isset($user->guid) ? 'LDAP' : 'DB' }}
                                </p>
                                <hr>
                                <p class="text-secondary mb-1">
                                    <a href="{{url('/user/ausleihen')}}">Ausgeliehene Werke: <h1 class="display-4">{{ count($user->ausleihe) }}</h1></a>
                                </p>
                                <p class="text-secondary mb-1">
                                    <a href="{{url('/user/merkliste')}}">Merkliste: <h1 class="display-4">{{ count($user->medium) }}</h1></a>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Nachname</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$user->nachname}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Vorname</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$user->vorname}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$user->email}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Berechtigung</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$user->berechtigungsrolle->berechtigungsrolle}}
                            </div>
                        </div>
                    </div>
                </div>
                @if($user->guid)
                {{-- LDAP User can't reset password by Litnify --}}
                @else
                    <div class="card mt-3">
                        <a href="{{url('/password/reset')}}" class="btn btn-primary" role="button">Passwort zurücksetzen</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

