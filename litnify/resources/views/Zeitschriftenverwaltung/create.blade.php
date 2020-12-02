@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
{{--                <livewire:create-zeitschrift-component />--}}
                <form action="{{route('zeitschrift.store')}}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="id">ID</label>
                        <input type="text"
                               class="form-control @error('id') border-danger @enderror " name="id" id="id" value="{{$nextId}}" readonly>
                        @error('id')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text"
                               class="form-control @error('name') border-danger @enderror" name="name" id="name" value="{{old('name')}}">
                        @error('name')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>
                    {{--<livewire:zeitschrift-name-input />--}}
                    <div class="form-group">
                        <label for="shortcut">Kürzel (shortcut)</label>
                        <input type="text"
                               class="form-control @error('shortcut') border-danger @enderror" name="shortcut" id="shortcut" value="{{old('shortcut')}}">
                        @error('shortcut')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn @if($errors->any()) btn-danger @elseif(session()->has('message')) btn-success @else btn-primary @endif">
                            <i class="fa @if($errors->any()) fa-times @elseif(session()->has('message')) fa-check @endif"></i> Erstellen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
