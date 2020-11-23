@extends('layouts.app')
@section('content')
    <div class="container">
        @livewire('search-users-component')
{{--        <div class="card">--}}
{{--            <div class="card-body">--}}
{{--                <h5 class="card-title">Nutzer für Direktverleih auswählen</h5>--}}
{{--                <form action="{{route('direktverleih.create')}}" method="GET">--}}

{{--                    <div class="form-group">--}}
{{--                        <label for="user_id"></label>--}}
{{--                        <select class="form-control" name="user_id" id="user_id">--}}
{{--                            <option></option>--}}
{{--                            @foreach($users as $user)--}}
{{--                                <option value="{{$user->id}}">{{$user->nachname}}, {{$user->vorname}} ({{$user->email}})</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    @csrf--}}
{{--                    <button type="submit" class="btn btn-primary">Bestätigen</button>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
