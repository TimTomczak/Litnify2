@extends('layouts.app')

@section('content')

        <div class="container d-flex justify-content-center">
            <div class="row">
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Login</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $user['uid'] }}" disabled>
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nachname</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $user['nachname'] }}" disabled>
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Vorname</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $user['vorname'] }}" disabled>
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Email</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $user['email'] }}" disabled>
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nutzerrolle</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $rolle }}" disabled>
                    </div>


                </div>

            </div>


@endsection

