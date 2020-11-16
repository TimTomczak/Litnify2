@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h5 class="card-title">Ausleihen von Nutzer:</h5>
                <p class="card-text">{{$user->nachname}}, {{$user->vorname}}</p>
                <p class="card-text">{{$user->email}}</p>
            </div>
        </div>
    </div>


    <div class="container mt-3">
        <h5>Aktive Ausleihen</h5>
        @if($ausleihenAktiv->isNotEmpty())
        <table class="table table-responsive-lg table-responsive table-hover table-bordered">
            <thead>
                <tr>
                    @foreach($ausleihenAktiv->first()->attributesToArray() as $key=>$val)
                        <th>{{$key}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach($ausleihenAktiv as $aus)
                <tr class="{{$aus->RueckgabeSoll<date('Y-m-d', time()) ? 'alert alert-danger' : ''}}">
                    @foreach($aus->attributesToArray() as $key => $val)
                        <td>{{$val}}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
            <p>Keine aktiven Ausleihen vorhanden.</p>
        @endif
    </div>
    <div class="container">
        <hr>

        <h5>Beendete Ausleihen</h5>
        @if($ausleihenBeendet->isNotEmpty())
            <table class="table table-responsive-lg table-responsive table-hover table-bordered">
            <thead>
                <tr>
                    @foreach($ausleihenBeendet->first()->attributesToArray() as $key=>$val)
                        <th>{{$key}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($ausleihenBeendet as $aus)
                    <tr>
                        @foreach($aus->attributesToArray() as $key => $val)
                            <td>{{$val}}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Keine beendeten Ausleihen vorhanden.</p>
        @endif
    </div>
@endsection
@section('javascript.footer')
    <script>
        $( document ).on( "mousemove", function( event ) {
            if (event.pageX<5){
                if ($('#wrapper').hasClass('toggled')){
                    $('#wrapper').removeClass('toggled')
                }
            }
            if (!$('#wrapper').hasClass('toggled')){
                if (event.pageX>240){
                    $('#wrapper').addClass('toggled')
                }
            }
        });
    </script>
@endsection
