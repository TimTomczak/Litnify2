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
                <tr {{strtotime($aus->RueckgabeSoll)<time() ? 'style=background-color:#f9d6d5' : ''}}>
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
                            <button class="btn btn-secondary btn-sm ausleiheVerlaengern" data-toggle="modal" data-target="#modalAusleiheVerlaengern_{{$aus->id}}" data-id="{{$aus->id}}" data-ausleihdatum="{{$aus->Ausleihdatum}}" data-rueckgabesoll="{{$aus->RueckgabeSoll}}" title="Ausleihe verlängern"><i class="fa fa-clock-o" ></i></button>
                            <!-- Modal -->
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
                                                               class="form-control" name="id" id="id" aria-describedby="helpId" value="{{$aus->id}}" readonly>
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
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            {{ $ausleihenAktiv->links() }}
        </div>
        @else
            <p>Keine aktiven Ausleihen vorhanden.</p>
        @endif
    </div>
    <div class="container">
        <hr>
        <div class="d-flex justify-content-start">
        <h5 class="mr-3">Beendete Ausleihen</h5>
        <button type="button" onclick="$('#ausleihenBeendetTable').toggle(); $('#tableShown').toggle(); $('#tableHidden').toggle()"
                class="btn btn-primary btn-sm">
            <i id="tableShown" class="fa fa-caret-down" style="display: none"></i>
            <i id="tableHidden" class="fa fa-caret-up"></i>
        </button>
        </div>
        @if($ausleihenBeendet->isNotEmpty())
            <table id="ausleihenBeendetTable" class="{{$tableStyle}}" style="display: none;">
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
            <div class="d-flex justify-content-between">
                {{ $ausleihenBeendet->links() }}
            </div>
        @else
            <p>Keine beendeten Ausleihen vorhanden.</p>
        @endif
    </div>
@endsection
@section('javascript.header')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('javascript.footer')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $('.ausleiheVerlaengern').click(function (event){
            var id =  $(this).data('id');
            var rueckgabeSoll =  $(this).data('rueckgabesoll');
            // $('#modalAusleiheVerlaengern').modal('show')

            $(function() {
                $('#verlaengerung_'+id).daterangepicker({

                    // timePicker: true,
                    // timePicker24Hour: true,
                    showDropdowns: true,
                    startDate: rueckgabeSoll,
                    // endDate: rueckgabeSoll,
                    minDate: rueckgabeSoll,
                    opens: "center",
                    drops: "auto",
                    singleDatePicker: true,
                    // applyButtonClasses: "btn-primary",
                    cancelClass: "btn-secondary",
                    locale: {
                        format: 'DD.MM.YYYY',
                        separator: " - ",
                        applyLabel: "Anwenden",
                        cancelLabel: "Abbrechen",
                        fromLabel: "Von",
                        toLabel: "Bis",
                        customRangeLabel: "Custom",
                        weekLabel: "W",
                        daysOfWeek: [
                            "So",
                            "Mo",
                            "Di",
                            "Mi",
                            "Do",
                            "Fr",
                            "Sa"
                        ],
                        monthNames: [
                            "Januar",
                            "Februar",
                            "März",
                            "April",
                            "Mai",
                            "Juni",
                            "Juli",
                            "August",
                            "September",
                            "October",
                            "November",
                            "Dezember"
                        ],
                    }
                });
            });

        });
    </script>
@endsection
