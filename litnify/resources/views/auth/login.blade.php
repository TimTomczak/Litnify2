@extends('layouts.app')
@section('metadescription')"Anmeldung/Login - Im Portal zur Literaturrecherche der Bibliothek der meteorologischen Abteilung des Instituts für Geowissenschaften der Universität Bonn anmelden | Uni Bonn | bib" @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">

                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Hinweis</strong>
                        <hr>
                        Um das Suchportal der Meteorologiebibliothek mit allen Funktionen nutzen zu können benötigen Sie einen Benutzerkonto.<br>
                        Angehörige der Meteorologie können sich direkt mit ihrer Meteo-ID anmelden. Gäste und Interessierte wenden
                        sich für ein Benutzerkonto bitte an <a href="{{url('/kontakt')}}" class="alert-link" target="_blank">Kontakt</a>.
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="login" class="col-md-4 col-form-label text-md-right">UNI-ID / E-Mail-Adresse</label>

                            <div class="col-md-6">
                                <input id="login" type="text"
                                       class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}"
                                       name="login" value="{{ old('login') }}" required autofocus autocomplete="username">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Passwort') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Angemeldet bleiben') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Anmelden') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
