@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-lg"></div>
            <div class="col-8">

                <form action="{{route('admin.nutzerverwaltung.update', $user->id)}}" method="post">
                    @csrf
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th scope="row">ID</th>
                            <td><input type="text" id="id" name="id" value="{{$user->id}}"style="width:100%;" disabled></td>
                        </tr>
                        <tr>
                            <th scope="row">Nachname</th>
                            <td><input type="text" id="nachname" name="nachname" value="{{$user->nachname}}" style="width:100%;"></td>
                        </tr>
                        <tr>
                            <th scope="row">Vorname</th>
                            <td><input type="text" id="vorname" name="vorname" value="{{$user->vorname}}"style="width:100%;"></td>
                        </tr>
                        <tr>
                            <th scope="row">E-Mail Adresse</th>
                            <td><input type="text" id="email" name="email" value="{{$user->email}}"style="width:100%;" disabled></td>
                        </tr>
                        <tr>
                            <th scope="row">Berechtigung</th>
                            <td>
                                @foreach($rollen as $rolle)
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="berechtigungsrolle_{{$rolle->id}}" value="{{$rolle->id}}" name="berechtigungsrolle_id" class="custom-control-input"
                                               @if($rolle->id == $user->berechtigungsrolle_id)
                                               checked
                                            @endif
                                        >
                                        <label class="custom-control-label" for="berechtigungsrolle_{{$rolle->id}}"> {{$rolle->berechtigungsrolle}}</label>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <button type="submit" class="btn btn-primary btn-md btn-block">Speichern</button>
                    <button type="reset" class="btn btn-secondary btn-md btn-block">Verwerfen</button>
                </form>


            </div>
            <div class="col-lg"></div>
        </div>
    </div>
@endsection
