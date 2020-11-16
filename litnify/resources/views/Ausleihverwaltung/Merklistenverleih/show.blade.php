@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h5 class="card-title">Merkliste von:</h5>
                <p class="card-text">{{$user->nachname}}, {{$user->vorname}}</p>
                <p class="card-text">{{$user->email}}</p>
            </div>
        </div>
        <table class="table table-responsive-lg table-bordered table-hover">
            <thead>
            <tr>
                <th>ID Medium</th>
                <th>Hauptsachtitel</th>
                <th>Gemerkt am:</th>
                <th>ausleihbar</th>
                <th>Aktion</th>
            </tr>
            </thead>
            <tbody>
            @foreach($merkliste as $merk)
                <tr>
                    <td>{{$merk->id}}</td>
                    <td>{{$merk->hauptsachtitel}}</td>
                    <td>{{$merk->pivot->created_at==null ? '-' : $merk->pivot->created_at->format("d.m.Y")}}</td>
                    <td>{{$merk->isAusleihbar()==true ? 'Ja' : 'Nein'}}</td>
                    <td>
                        @if($merk->isAusleihbar()==true)
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelId{{$merk->id}}">
                            <i class="fa fa-calendar-plus-o"></i> ausleihen
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="modelId{{$merk->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ausleihe</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('ausleihe.store',[$user,$merk])}}" method="POST">
                                        @csrf

                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label for="inventarnummer">Inventarnummer</label>
                                                <select class="form-control" name="inventarnummer">
                                                    <option>{{old('inventarnummer')}}</option>
                                                    @foreach($merk->getInventarnummernAusleihbar() as $invAus)
                                                        <option value="{{$invAus}}">{{$invAus}}</option>
                                                    @endforeach
                                                </select>
                                                <small class="form-text text-muted">Für das Medium ausleihbare Inventarnummern</small>
                                                @error('inventarnummer')
                                                    <div class="invalid-feedback d-block">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label for="ausleihzeitraum">Ausleihzeitraum (voreingestellt: <strong>{{$ausleihdauerDefault}}</strong> Tage)</label>
                                                <input class="form-control" type="text" name="ausleihzeitraum" data-ausleihdauer="{{$ausleihdauerDefault}}" value="{{old('ausleihzeitraum')}}"/>
                                                @error('Ausleihdatum')
                                                    <div class="invalid-feedback d-block">{{$message}}</div>
                                                @enderror
                                                @error('RueckgabeSoll')
                                                    <div class="invalid-feedback d-block">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @else
                           -
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>

        $(function() {
            var ausleihdauer=$('input[name="ausleihzeitraum"]').data('ausleihdauer')
            $('input[name="ausleihzeitraum"]').daterangepicker({

                // timePicker: true,
                // timePicker24Hour: true,
                showDropdowns: true,
                startDate: moment(),
                endDate: moment().add(ausleihdauer, 'day'),
                opens: "center",
                drops: "auto",
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

    </script>
@endsection


