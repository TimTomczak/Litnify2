@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h5 class="card-title">Direktverleih für Nutzer</h5>
                <p class="card-text">{{$user->nachname}}, {{$user->vorname}}</p>
                <p class="card-text">{{$user->email}}</p>
            </div>
        </div>
        {{--    TODO Suche statt Tabelle einfügen --}}

        <table class="table table-responsive-lg table-responsive table-hover table-bordered table-striped text-nowrap">
            <thead>
            <tr>
                <th>Aktion</th>
                @foreach($medien->first()->attributesToArray() as $key=>$val)
                    <th>{{$key}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($medien as $med)
                <tr>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelId{{$med->id}}">
                            <i class="fa fa-calendar-plus-o"></i> ausleihen
                        </button>
                    </td>

                    <!-- Modal -->
                    <div class="modal fade" id="modelId{{$med->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ausleihe</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('ausleihe.store',[$user,$med])}}" method="POST">
                                    @csrf

                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label for="inventarnummer">Inventarnummer</label>
                                            <select class="form-control" name="inventarnummer">
                                                <option>{{old('inventarnummer')}}</option>
                                                @foreach($med->getInventarnummernAusleihbar() as $invAus)
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

                    @foreach($med->attributesToArray() as $key=>$val)
                        @switch($key)
                            @case('hauptsachtitel')
                            <td class="text-wrap"><a href="{{route('medium.show',$med['id'])}}">{{$val}}</a></td>
                            @break

                            @case('autoren')
                            <td>
                                @foreach(explode(';',$val) as $autor)
                                    {{$autor}}<br>
                                @endforeach
                            </td>
                            @break

                            @default
                            <td>{{$val}}</td>

                        @endswitch

                    @endforeach
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection

@include('Ausleihverwaltung.dateTimePicker')
