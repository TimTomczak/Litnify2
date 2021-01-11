@extends('layouts.app')

@section('content')

    <!-- Header -->
    <header class="bg-dark py-5" style="background-image: url('{{asset('storage/images/background.png')}}');height: 86vh;min-height: 500px;
        background-size: cover;background-position: center;background-repeat: no-repeat;">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-12 text-center text-wrap text-light">

                    <h1 class="brand">Litnify</h1>
                    <h2>Das Suchportal der Meteorologiebibliothek</h2>
                    <form action="suche" method="get">

                        <div class="form-row ">
                            <div class="col-md-9">
                                <div class="row no-gutters">
                                    <div class="col-md-9 input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary fa fa-search rounded-left" type="button"></button>
                                        </div>
                                        <input type="text" name="q" class="form-control form-control-lg rounded-0" placeholder="Bitte Suchbegriff eingeben..." autofocus />
                                    </div>
                                    <div class="col-md-3">
                                        <select class="custom-select custom-select-lg rounded-0" name="filter">
                                            @foreach ($auswahl as $item)
                                                <option value="{{($item['short'])}}">{{($item['full'])}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-block btn-lg" type="submit"> <i class="fa fa-search"></i> Suchen</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </header>

@endsection
