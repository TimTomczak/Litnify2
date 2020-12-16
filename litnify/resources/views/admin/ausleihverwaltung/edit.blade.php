@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h5 class="card-title">Ausleihe von Nutzer:</h5>
                <p class="card-text">{{$user->nachname}}, {{$user->vorname}}</p>
                <p class="card-text">{{$user->email}}</p>
            </div>
        </div>
        <div class="card mt-2 bg-light p-1">
            <div class="container">
                <form action="{{route('ausleihe.update',$ausleihe->id)}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="id">Ausleihe ID</label>
                        <input type="text" class="form-control" name="id" id="id" value="{{$ausleihe->id}}" readonly>
                        @error('id')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="medium_id">Medium ID</label>
                        <button type="button" data-id="{{$ausleihe->medium_id}}" class="btn btn-outline-primary btn-block render-medium-modal">
                            {{$ausleihe->medium_id}}
                        </button>
                        <input type="text" class="form-control bg-primary" name="medium_id" id="medium_id" value="{{$ausleihe->medium_id}}" readonly style="display: none;">
                        @error('medium_id')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id">Nutzer ID</label>
                        <input type="text" class="form-control" name="user_id" id="user_id" value="{{$ausleihe->user_id}}" readonly>
                        @error('user_id')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="inventarnummer">Inventarnummer</label>
                        <select class="form-control" name="inventarnummer" id="inventarnummer">
                            <option>{{$ausleihe->inventarnummer}}</option>
                            @foreach(\App\Models\Medium::findOrFail($ausleihe->medium_id)->getInventarnummernAusleihbar() as $inv)
                                <option value="{{$inv}}">{{$inv}}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="ausleihzeitraum">Ausleihzeitraum</label>
                        <input class="form-control" type="text" name="ausleihzeitraumEdit" data-ausleihdatum="{{$ausleihe->Ausleihdatum}}" data-rueckgabesoll="{{$ausleihe->RueckgabeSoll}}"/>
                        @error('user_id')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Änderung bestätigen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('admin.medienverwaltung.mediumModal')
@endsection
