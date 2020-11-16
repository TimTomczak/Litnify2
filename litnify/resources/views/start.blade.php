@extends('layouts.app')

@section('content')

    <style>
        header {
            height: 86vh;
            min-height: 500px;
            background-image: url('{{asset('storage/images/background.png')}}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>

    <!-- Header -->
    <header class="bg-dark py-5">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-12 text-center text-wrap text-light">



                    <h1 class="brand">Litnify</h1>
                    <h2>Das Suchportal der Meteorologiebibliothek</h2>
                    <form action="suche" method="get">
                        <div class="form-row">
                            <div class="col-12 col-md-9 mb-2 mb-md-0">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <button id="popover-info" class="btn btn-sm btn-primary fa fa-info-circle rounded-left" data-placement="right" type="button" data-toggle="popover" data-trigger="focus"></button>
                                    </div>
                                    <input type="text" name="q" class="form-control form-control-lg" placeholder="Titel, Autor, DOI, ISBN ..."/>
                                </div>
                                <!-- <a href="suche?extend=true"><i class="fa fa-external-link-alt"></i> Erweiterte Suche</a> -->
                            </div>
                            <div class="col-12 col-md-3">
                                <button class="btn btn-primary btn-block btn-lg" type="submit">Suchen!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>

@section('scripts')
    $(function () {
    $('#popover-info').popover({
    html: true,
    title: ' Infos zur Suche <a href="#" class="close" data-dismiss="alert">&times;</a>',
    content: '<div><p>- Intuitive Suche <br>-> Je mehr Suchbegriffe, desto präziser das Suchergebnis</p> <hr><p>- Jahresintervallbegrenzung: <br>Bspw. 1990 - 2010</p><hr><p>- Filtern nach mehreren Literaturarten möglich:</p><div class="row ml-3 mt-n3"><p>- Buch:</p>&nbsp;<p>@Buch</p></div><div class="row ml-3 mt-n3"><p>- Artikel:</p>&nbsp;<p>@Artikel</p></div><div class="row ml-3 mt-n3"><p>- Unselbst. Werk:</p>&nbsp;<p>@Reihe</p></div><div class="row ml-3 mt-n3"><p>- Graue Literatur:</p>&nbsp;<p>@GrauLit</p></div><div class="row ml-3 mt-n3"><p>- Daten:</p>&nbsp;<p>@Daten</p></div><hr><p>- Befehle für Suche nach ISBN/ISSN: <br>isbn: / issn: </p><hr></div>',
    trigger: 'focus'
    // template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body alert alert-danger"></div></div>'
    })
    });
    $(document).on("click", ".popover .close" , function(){
    $(this).parents(".popover").popover('hide');
    });
@stop


@endsection
