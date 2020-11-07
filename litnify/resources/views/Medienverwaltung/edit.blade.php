@extends('layouts.app')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin-Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('medienverwaltung.index')}}">Medienverwaltung</a></li>
                <li class="breadcrumb-item"><a href="{{route('medium.show', $medium->id)}}">Medium anzeigen</a></li>
                <li class="breadcrumb-item active" aria-current="page">Medium bearbeiten</li>
            </ol>
        </nav>
        <div class="card p-4 bg-light">
            <form action="{{route('medium.update',$medium->id)}}" method="POST" id="form">
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text"
                           class="form-control @error('id') border-danger @enderror" name="id" id="id"
                           value="{{$medium->id}}"
                           readonly>
                    @error('id')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="literaturart_id">Literaturart</label>
                    <input type="text"
                           class="form-control @error('literaturart_id') border-danger @enderror" name="literaturart_id" id="literaturart_id"
                           value="{{$medium->literaturart_id}}"
                           readonly>
                    @error('literaturart_id')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="signatur">Signatur</label>
                    <input type="text"
                           class="form-control @error('signatur') border-danger @enderror" name="signatur" id="signatur"
                           value="{{$medium->signatur}}">
                    @error('signatur')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <livewire:autoren-component :medium="$medium" />

                <div class="form-group">
                    <label for="hauptsachtitel">Hauptsachtitel</label>
                    <textarea type="text"
                           class="form-control @error('hauptsachtitel') border-danger @enderror" name="hauptsachtitel"
                              id="hauptsachtitel">{{$medium->hauptsachtitel}}</textarea>
                    @error('hauptsachtitel')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="untertitel">Untertitel</label>
                    <input type="text"
                           class="form-control @error('untertitel') border-danger @enderror" name="untertitel" id="untertitel"
                           value="{{$medium->untertitel}}">
                    @error('untertitel')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="enthalten_in">Enthalten in</label>
                    <input type="text"
                           class="form-control @error('enthalten_in') border-danger @enderror" name="enthalten_in" id="enthalten_in" aria-describedby="helpId"
                           value="{{$medium->enthalten_in}}">
                    @error('enthalten_in')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="erscheinungsort">Erscheinungsort</label>
                    <input type="text"
                           class="form-control @error('erscheinungsort') border-danger @enderror" name="erscheinungsort" id="erscheinungsort"
                           value="{{$medium->erscheinungsort}}">
                    @error('erscheinungsort')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jahr">Jahr</label>
                    <input type="text"
                           class="form-control @error('jahr') border-danger @enderror" name="jahr" id="jahr"
                           value="{{$medium->jahr}}">
                    @error('jahr')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="verlag">Verlag</label>
                    <input type="text"
                           class="form-control @error('verlag') border-danger @enderror" name="verlag" id="verlag"
                           value="{{$medium->verlag}}">
                    @error('verlag')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text"
                           class="form-control @error('isbn') border-danger @enderror" name="isbn" id="isbn"
                           value="{{$medium->isbn}}">
                    @error('isbn')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="issn">ISSN</label>
                    <input type="text"
                           class="form-control @error('issn') border-danger @enderror" name="issn" id="issn"
                           value="{{$medium->issn}}">
                    @error('issn')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <label for="inventarnummern ">Inventarnummern</label>
                <button id="inventarnummern" type="button" class="btn btn-outline-secondary btn-block mb-3" data-toggle="modal" data-target="#modelId">Inventarnummern</button>

                <!-- Modal -->

                <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Inventarnummern</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <livewire:inventarnummern-component :medium="$medium" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fenster schließen</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--<div class="form-group">
                    <label for="inventarnummer">Inventarnummer</label>
                    <input type="text"
                           class="form-control @error('inventarnummer') border-danger @enderror" name="inventarnummer" id="inventarnummer"
                           value="{{$medium->inventarnummer}}">
                    @error('inventarnummer')
                        <div class="invalid-feedback d-block">{{$message}}
                    @enderror
                </div>--}}

                <div class="form-group">
                    <label for="auflage">Auflage</label>
                    <input type="text"
                           class="form-control @error('auflage') border-danger @enderror" name="auflage" id="auflage"
                           value="{{$medium->auflage}}">
                    @error('auflage')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="herausgeber">Herausgeber</label>
                    <input type="text"
                           class="form-control @error('herausgeber') border-danger @enderror" name="herausgeber" id="herausgeber"
                           value="{{$medium->herausgeber}}">
                    @error('herausgeber')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="zeitschrift_id">Zeitschrift</label>
                    {{--TODO mit Datalist austauschen--}}
                    <select class="form-control" name="zeitschrift_id" id="zeitschrift_id">
                        @foreach(App\Models\Zeitschrift::all() as $zeitschrift)
                            @if($medium->zeitschrift_id==$zeitschrift->name)
                                <option value="{{$zeitschrift->name}}" selected>{{$zeitschrift->name}} [{{$zeitschrift->shortcut}}]</option>
                            @else
                                <option value="{{$zeitschrift->name}}">{{$zeitschrift->name}} [{{$zeitschrift->shortcut}}]</option>
                            @endif
                        @endforeach
                    </select>
{{--                    <input type="text"--}}
{{--                           class="form-control @error('zeitschrift_id') border-danger @enderror" name="zeitschrift_id" id="zeitschrift_id" aria-describedby="helpId"--}}
{{--                           value="{{$medium->zeitschrift_id}}">--}}
                    @error('zeitschrift_id')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="schriftenreihe">Schriftenreihe</label>
                    <input type="text"
                           class="form-control @error('schriftenreihe') border-danger @enderror" name="schriftenreihe" id="schriftenreihe"
                           value="{{$medium->schriftenreihe}}">
                    @error('schriftenreihe')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="band">Band</label>
                    <input type="text"
                           class="form-control @error('band') border-danger @enderror" name="band" id="band"
                           value="{{$medium->band}}">
                    @error('band')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="seite">Seite</label>
                    <input type="text"
                           class="form-control @error('seite') border-danger @enderror" name="seite" id="seite"
                           value="{{$medium->seite}}">
                    @error('seite')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="raum_id">Standort</label>
                    <select class="form-control" name="raum_id" id="raum_id">
                        @foreach(App\Models\Raum::all()->pluck('raum') as $raum)
                            @if($medium->raum_id==$raum)
                                <option selected>{{$raum}}</option>
                            @else
                                <option>{{$raum}}</option>
                            @endif
                        @endforeach
                    </select>
{{--                    <label for="standort">Standort</label>--}}
{{--                    <input type="text"--}}
{{--                           class="form-control @error('standort') border-danger @enderror" name="standort" id="standort"--}}
{{--                           value="{{$medium->standort}}">--}}
                    @error('raum_id')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bemerkungen">Bemerkungen</label>
                    <textarea type="text"
                           class="form-control @error('bemerkungen') border-danger @enderror" name="bemerkungen"
                              id="bemerkungen">{{$medium->bemerkungen}}</textarea>
                    @error('bemerkungen')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <button form="form" type="submit" class="btn btn-primary">Änderung bestätigen</button>
                </div>
            </form>
        </div>
    </div>
@endsection
