@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{route('zeitschrift.update', $zeitschrift->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input type="text"
                               class="form-control @error('id') border-danger @enderror " name="id" id="id" aria-describedby="helpId" value="{{$zeitschrift->id}}" readonly>
                        @error('id')
                            <small id="helpId" class="form-text text-muted">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text"
                               class="form-control @error('name') border-danger @enderror" name="name" id="name" aria-describedby="helpName" value="{{$zeitschrift->name}}">
                        @error('name')
                            <small id="helpName" class="form-text text-muted">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="shortcut">Kürzel (shortcut)</label>
                        <input type="text"
                               class="form-control @error('shortcut') border-danger @enderror" name="shortcut" id="shortcut" aria-describedby="helpShortcut" value="{{$zeitschrift->shortcut}}">
                        @error('shortcut')
                        <small id="helpShortcut" class="form-text text-muted">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Ändern</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
