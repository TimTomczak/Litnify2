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

        <!-- Ausleihbare Medien -->
        <h4 class="mt-2">Ausleihbare Medien auf Nutzer-Merkliste:</h4>
        <table class="{{$tableStyle}}">
            <thead>
            <tr>
                <th>ID Medium</th>
                <th>Hauptsachtitel</th>
                <th>Gemerkt am:</th>
                <th>Aktion</th>
            </tr>
            </thead>
            <tbody>
            @foreach($merklisteAusleihbar as $merk)
                <tr>
                    <td>{{$merk->id}}</td>
                    <td class="text-wrap"><a href="#" class="render-medium-modal" data-id="{{$merk->id}}">{{$merk->hauptsachtitel}}</a></td>
                    <td>{{$merk->pivot->created_at==null ? '-' : $merk->pivot->created_at->format("d.m.Y")}}</td>
                    <td>
                        <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modelId{{$merk->id}}" title="Ausleihe verlängern">
                                <i class="fa fa-calendar-plus-o"></i>
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
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            {{ $merkliste->links() }}
        </div>
        <!-- / Ausleihbare Medien -->

        <hr>

        <!-- Nicht ausleihbare Medien -->
        <h4 class="mt-2">Nicht ausleihbare Medien auf Nutzer-Merkliste:</h4>
        <table class="{{$tableStyle}}">
            <thead>
            <tr>
                <th>ID Medium</th>
                <th>Hauptsachtitel</th>
                <th>Gemerkt am:</th>
            </tr>
            </thead>
            <tbody>
            @foreach($merkliste as $merk)
                <tr>
                    <td>{{$merk->id}}</td>
                    <td class="text-wrap"><a href="#" class="render-medium-modal" data-id="{{$merk->id}}">{{$merk->hauptsachtitel}}</a></td>
                    <td>{{$merk->pivot->created_at==null ? '-' : $merk->pivot->created_at->format("d.m.Y")}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            {{ $merkliste->links() }}
        </div>
        <!-- / Nicht ausleihbare Medien -->

    </div>
    @include('admin.medienverwaltung.mediumModal')

@endsection
