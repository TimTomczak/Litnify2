@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nachname</th>
                        <th scope="col">Vorname</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">Rolle</th>
                        <th scope="col">Erstellt</th>
                        <th scope="col">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->nachname }}</td>
                            <td>{{ $user->vorname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->berechtigungsrolle->berechtigungsrolle }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" title="VIEW"><i class="fa fa-search"></i></button>
                                <button class="btn btn-success btn-sm" title="EDIT"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm" title="DELETE"><i class="fa fa-minus-circle"></i></button>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
@endsection
