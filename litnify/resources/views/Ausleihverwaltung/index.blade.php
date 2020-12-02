@extends('layouts.app')
@section('content')
    <div class="container">
        <h4>Aktive Ausliehen</h4>
        <table class="table table-responsive-lg table-hover table-bordered">
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
            <tr {{strtotime($aus->RueckgabeSoll)<time() ? 'style=background-color:#f9d6d5' : ''}}>
                @foreach($tableBuilderAktiv as $key=>$val)
                    @switch($key)
                        @case('medium_id')
                        <td><a class="render-medium-modal" data-id="{{$aus->medium_id}}">{{$aus->attributesToArray()[$key]}}</a></td>
                        @break

                        @case('user_id')
                        <td><a href="{{route('ausleihe.show',$aus->user_id)}}">{{$aus->attributesToArray()[$key]}}</a></td>
                        @break

                        @default
                        <td>{{$aus->attributesToArray()[$key]}}</td>
                    @endswitch
                @endforeach
                <td>
                    <div class="d-flex border-0 justify-content-around">
                        <a href="{{route('ausleihe.show',$aus->user_id)}}"><button class="{{$aktionenStyles['show']['button-class']}}" title="Ausleihen des Nutzers ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a>

                        @role(3)
                        <a href="{{route('ausleihe.edit',$aus->id)}}"><button class="{{$aktionenStyles['edit']['button-class']}}" title="Ausleihe bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button></a>
                        <form action="{{route('ausleihe.destroy',$aus->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Ausleihe löschen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                        </form>
                        <!-- Button trigger modal Verlängerung -->
                        <button class="btn btn-secondary btn-sm ausleiheVerlaengern" data-toggle="modal" data-target="#modalAusleiheVerlaengern_{{$aus->id}}" data-id="{{$aus->id}}" data-ausleihdatum="{{$aus->Ausleihdatum}}" data-rueckgabesoll="{{$aus->RueckgabeSoll}}" title="Ausleihe verlängern"><i class="fa fa-clock-o" ></i></button>
                        <!-- Button trigger modal Rückgabe -->
                        <button class="btn btn-info btn-sm ausleiheRueckgabe" data-toggle="modal" data-target="#modalRueckgabe_{{$aus->id}}" data-id="{{$aus->id}}" data-ausleihdatum="{{$aus->Ausleihdatum}}" data-rueckgabesoll="{{$aus->RueckgabeSoll}}" title="Rückgabe verbuchen"><i class="fa fa-undo" ></i></button>

                        <!-- Modal Verlängerung -->
                        <div class="modal fade modalAusleiheVerlaengern"  id="modalAusleiheVerlaengern_{{$aus->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ausleihe verlängern</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('ausleihe.extend',$aus->id)}}" method="POST">
                                        <div class="modal-body">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <input type="text" style="display: none"
                                                           class="form-control" name="id" aria-describedby="helpId" value="{{$aus->id}}" readonly>
                                                </div>
                                                <p class="card-text">Bisheriger Ausleihzeitraum: {{$aus->Ausleihdatum}} - {{$aus->RueckgabeSoll}} ({{(strtotime($aus->RueckgabeSoll)-strtotime($aus->Ausleihdatum))/ 86400}} Tage)</p>
                                                <p class="card-text">Bisherigerige Verlängerungen: {{$aus->Verlaengerungen}}</p>
                                                <input type="text"
                                                       class="form-control" name="verlaengerung" id="verlaengerung_{{$aus->id}}" aria-describedby="helpId">
                                                <small id="helpId" class="form-text text-muted">Wählen Sie ein neues Datum für das Ausleih-Ende</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                                            <button type="submit" class="btn btn-primary">Speichern</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- Modal Verlängerung -->
                        <div class="modal fade modalAusleiheRueckgabe"  id="modalRueckgabe_{{$aus->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Rückgabe durchführen</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('ausleihe.return',$aus->id)}}" method="POST">
                                        <div class="modal-body">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <input type="text" style="display: none"
                                                           class="form-control" name="id" aria-describedby="helpId" value="{{$aus->id}}" readonly>
                                                </div>
                                                <p class="card-text">Bisheriger Ausleihzeitraum: {{$aus->Ausleihdatum}} - {{$aus->RueckgabeSoll}} ({{(strtotime($aus->RueckgabeSoll)-strtotime($aus->Ausleihdatum))/ 86400}} Tage)</p>
                                                <p class="card-text">Bisherigerige Verlängerungen: {{$aus->Verlaengerungen}}</p>
                                                <input type="text"
                                                       class="form-control" name="rueckgabe" id="rueckgabe_{{$aus->id}}" aria-describedby="helpId">
                                                <small id="helpId" class="form-text text-muted">Wählen Sie ein Datum für die Rückgabe</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                                            <button type="submit" class="btn btn-primary">Speichern</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        @endrole
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            {{ $ausleihenAktiv->links() }}
        </div>
    </div>
    <div class="container">
        <hr>

        <div class="d-flex justify-content-start">
            <h4 class="mr-3">Beendete Ausliehen</h4>
            <button type="button" onclick="$('#ausleihenBeendetTable').toggle(); $('#tableShown').toggle(); $('#tableHidden').toggle()"
                    class="btn btn-primary btn-sm">
                <i id="tableShown" class="fa fa-caret-down" style="display: none"></i>
                <i id="tableHidden" class="fa fa-caret-up"></i>
            </button>
        </div>
        <table id="ausleihenBeendetTable" class="table table-responsive-lg table-hover table-bordered" style="display: none;">
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
                <tr {{$aus->RueckgabeSoll<$aus->RueckgabeIst ? 'style=background-color:#f9d6d5' : ''}}>
                    @foreach($tableBuilderBeendet as $key=>$val)
                        @switch($key)
                            @case('medium_id')
                            <td>{{--<a data-toggle="modal" href="{{route('medium.show',$val)}}" data-target="#modal">Click me</a>--}}
                                <a class="render-medium-modal" data-id="{{$aus->medium_id}}">{{$aus->attributesToArray()[$key]}}</a></td>
                            @break

                            @case('user_id')
                            <td><a href="{{route('ausleihe.show',$aus->user_id)}}">{{$aus->attributesToArray()[$key]}}</a></td>
                            @break

                            @default
                            <td>{{$aus->attributesToArray()[$key]}}</td>
                        @endswitch

                    @endforeach
                    <td>
                        <div class="d-flex border-0 justify-content-around">
                            <a href="{{route('ausleihe.show',$aus->user_id)}}"><button class="{{$aktionenStyles['show']['button-class']}}" title="Ausleihen des Nutzers ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a>

                            @role(3)
                            <a href="{{route('ausleihe.edit',$aus->id)}}"><button class="{{$aktionenStyles['edit']['button-class']}}" title="Ausleihe bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button></a>
                            <form action="{{route('ausleihe.destroy',$aus->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Ausleihe löschen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                            </form>
                            @endrole
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            {{ $ausleihenBeendet->links() }}
        </div>
    </div>
    @include('Medienverwaltung.mediumModal')

@endsection
{{--@section('javascript.header')--}}
{{--    <link rel="stylesheet" type="text/css" href="{{asset('storage/css/daterangepicker/daterangepicker.css')}}" />--}}
{{--@endsection--}}
{{--@section('javascript.footer')--}}
{{--    <script type="text/javascript" src="{{asset('storage/js/daterangepicker/moment.js')}}"></script>--}}
{{--    <script type="text/javascript" src="{{asset('storage/js/daterangepicker/daterangepicker.js')}}"></script>--}}
{{--    <script type="text/javascript" src="{{asset('storage/js/daterangepicker/custom/verlaengerungDaterangepicker.js')}}"></script>--}}
{{--    <script type="text/javascript" src="{{asset('storage/js/daterangepicker/custom/rueckgabeDaterangepicker.js')}}"></script>--}}
{{--@endsection--}}
