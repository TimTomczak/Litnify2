@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-lg"></div>
            <div class="col-8">

                <form action="{{route('admin.nutzerverwaltung.createUser')}}" method="post">
                    @csrf
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th scope="row">ID</th>
                            <td><input type="text" id="id" name="id" value="[wird vom System generiert]"style="width:100%;" disabled></td>
                        </tr>
                        <tr>
                            <th scope="row">Nachname</th>
                            <td><input type="text" id="nachname" name="nachname" value="" style="width:100%;"></td>
                        </tr>
                        <tr>
                            <th scope="row">Vorname</th>
                            <td><input type="text" id="vorname" name="vorname" value=""style="width:100%;"></td>
                        </tr>
                        <tr>
                            <th scope="row">E-Mail Adresse</th>
                            <td><input type="email" id="email" name="email" value=""style="width:100%;"></td>
                        </tr>
                        <tr>
                            <th scope="row">Berechtigung</th>
                            <td>
                                Standardberechtigung: Benutzer
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <button type="submit" class="btn btn-primary btn-md btn-block">Erstellen</button>
                    <button type="reset" class="btn btn-secondary btn-md btn-block">Verwerfen</button>
                </form>


            </div>
            <div class="col-lg"></div>
        </div>
    </div>
@endsection
