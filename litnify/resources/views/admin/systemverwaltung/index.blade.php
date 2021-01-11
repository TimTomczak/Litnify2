@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-7">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Systemübersicht</h5>
                    <p class="card-text">

                        <table class="table">
                            <tbody>
                            <tr>
                                <td><a href="https://www.php.net/" target="_blank"><img src="/storage/images/logo_php.png" height="30px"></a></td>
                                <td>[Programmiersprache]</td>
                                <td>@php
                                        echo PHP_VERSION;
                                    @endphp</td>
                            </tr>
                            <tr>
                                <td><a href="https://laravel.com/" target="_blank"><img src="/storage/images/logo_laravel.png" height="30px"></a></td>
                                <td>[Framework]</td>
                                <td>{{ App::VERSION() }}</td>
                            </tr>
                            </tbody>
                        </table>

                    </p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Design</h5>
                    <p class="card-text">
                        <table class="table">
                        <thead>
                            <tr>
                                <th>Aktuelles Bild</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <form method="post" action="{{route('admin.systemverwaltung.updateLogo')}}" enctype="multipart/form-data">
                                    @csrf
                                    <td>
                                        <img src="{{asset('storage/images/logo.png?')}}
                                        @php
                                            microtime();
                                        @endphp
                                        " height="50px">
                                    </td>
                                    <td>
                                        <input type="file" class="form-control-file" name="logo"/>
                                    </td>
                                    <td>
                                        <button type="submit" name="submit" value="logo" class="btn btn-primary">Hochladen</button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <form method="post" action="{{route('admin.systemverwaltung.updateLogo')}}" enctype="multipart/form-data">
                                    @csrf
                                    <td>
                                        <img src="{{asset('storage/images/sublogo.png?')}}
                                        @php
                                            microtime();
                                        @endphp
                                            " height="50px">
                                    </td>
                                    <td>
                                        <input type="file" class="form-control-file" name="logo"/>
                                    </td>
                                    <td>
                                        <button type="submit" name="submit" value="sublogo" class="btn btn-primary">Hochladen</button>
                                    </td>
                                </form>
                            </tr>
                        </tbody>
                        </table>
                    </p>
                    <p>
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        Ein Ändern der Logos wird ggf. nicht sofort sichtbar, da die Logos sowohl im App-Cache des
                        Servers als auch im Browser des Nutzers zwischengespeichert werden.
                    </p>
                </div>
            </div>


            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Aktionen</h5>
                    <p class="card-text">

                        <button type="button" class="btn btn-primary">
                            App-Cache leeren
                        </button>


                    </p>
                </div>
            </div>




        </div>



        <div class="col-5">
            @livewire('action-log-component')
        </div>
    </div>









@endsection
