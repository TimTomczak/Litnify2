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
        <table class="{{$tableStyle}}">
            <thead>
                <tr>
                    @foreach($tableBuilderAktiv as $key=>$val)
                        <th>{{$val}}</th>
                    @endforeach
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
            @foreach($ausleihenAktiv as $aus)
                <tr class="{{$aus->RueckgabeSoll<date('Y-m-d', time()) ? 'alert alert-danger' : ''}}">
                    @foreach($tableBuilderAktiv as $key=>$val)
                        <td>{{$aus->attributesToArray()[$key]}}</td>
                    @endforeach
                    <td> {{--Aktionen--}}
                        <div class="d-flex border-0 justify-content-around">
                            <a href="{{route('ausleihe.edit',$aus->id)}}"><button class="{{$aktionenStyles['edit']['button-class']}}" title="Ausleihe bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button></a>
                            <form action="{{route('ausleihe.destroy',$aus->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Ausleihe löschen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                            </form>
                        </div>
                    </td>
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
            <table class="{{$tableStyle}}">
            <thead>
                <tr>
                    @foreach($tableBuilderBeendet as $key=>$val)
                        <th>{{$val}}</th>
                    @endforeach
                    <th>Aktionen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ausleihenBeendet as $aus)
                    <tr>
                        @foreach($tableBuilderBeendet as $key=>$val)
                            <td>{{$aus->attributesToArray()[$key]}}</td>
                        @endforeach
                        <td> {{--Aktionen--}}
                            <div class="d-flex border-0 justify-content-around">
                                <a href="{{route('ausleihe.edit',$aus->id)}}"><button class="{{$aktionenStyles['edit']['button-class']}}" title="Ausleihe bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button></a>
                                <form action="{{route('ausleihe.destroy',$aus->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Ausleihe löschen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                                </form>
                            </div>
                        </td>
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
