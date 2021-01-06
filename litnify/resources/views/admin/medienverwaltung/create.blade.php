@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card p-4 bg-light">
            @if($literaturart=='')
            <div class="form-group">
                <label for="literaturart_id">Literaturart</label>
                <select  class="form-control" name="literaturart_id" id="literaturart_id">
                    <option></option>
                    @foreach($literaturarten as $litart)
                        <option>{{$litart}}</option>
                    @endforeach
                </select>
                @error('literaturart_id')
                <div class="invalid-feedback d-block">{{$message}}</div>
                @enderror
            </div>
            <a id="litart_link" class="btn btn-info" style="display: none">Literaturart auswählen</a>
            <script>
                /* Macht Erstellt einen Link für die Literaturart */
                $('select').on('change', function(e){
                    $val= $(this).find("option:selected").val();
                    $('#litart_link').attr('href','/admin/medienverwaltung/medium/create/'+$val)
                    $('#litart_link').show();
                });
            </script>
            @else
                <form id="createMediumForm" action="{{route('medium.store')}}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="id">ID</label>
                        <input type="text"
                               class="form-control @error('id') border-danger @enderror"
                               value="{{$nextMediumId}}"
                               readonly>
                        @error('id')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="literaturart_id">Literaturart</label>
                        {{--<select class="form-control" name="literaturart_id" id="literaturart_id" readonly>
                            @foreach(App\Models\Literaturart::all()->pluck('literaturart') as $litart)
                    @if(Helper::showField('schriftenreihe',$literaturart))
                            @endforeach
                        </select>--}}
                        <input type="text"
                               class="form-control @error('literaturart_id') border-danger @enderror" name="literaturart_id" id="literaturart_id"
                               placeholder=""
                               value="{{$literaturart}}"
                               readonly
                        >
                        @error('literaturart_id')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    @if(Helper::showField('signatur',$literaturart))
                        <div class="form-group">
                            <label for="signatur">Signatur</label>
                            <input type="text"
                                   class="form-control @error('signatur') border-danger @enderror" name="signatur" id="signatur"
                                   placeholder=""
                                   value="{{old('signatur')}}"
                            >
                            @error('signatur')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    @endif

                    <livewire:autoren-component :autorenOld="old('autoren')"/>

                    <div class="form-group">
                        <label for="hauptsachtitel">Hauptsachtitel</label>
                        <textarea type="text"
                                  class="form-control @error('hauptsachtitel') border-danger @enderror" name="hauptsachtitel" id="hauptsachtitel"
                                  placeholder="">{{old('hauptsachtitel')}}</textarea>
                        @error('hauptsachtitel')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="untertitel">Untertitel</label>
                        <input type="text"
                               class="form-control @error('untertitel') border-danger @enderror" name="untertitel" id="untertitel"
                               placeholder=""
                               value="{{old('untertitel')}}"
                        >
                        @error('untertitel')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    @if(Helper::showField('enthalten_in',$literaturart))
                        <div class="form-group">
                            <label for="enthalten_in">Enthalten in</label>
                            <input type="text"
                                   class="form-control @error('enthalten_in') border-danger @enderror" name="enthalten_in" id="enthalten_in" aria-describedby="helpId"
                                   placeholder=""
                                   value="{{old('enthalten_in')}}"
                            >
                            @error('enthalten_in')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    @endif
                    @if(Helper::showField('erscheinungsort',$literaturart))
                        <div class="form-group">
                            <label for="erscheinungsort">Erscheinungsort</label>
                            <input type="text"
                                   class="form-control @error('erscheinungsort') border-danger @enderror" name="erscheinungsort" id="erscheinungsort"
                                   placeholder=""
                                   value="{{old('erscheinungsort')}}"
                            >
                            @error('erscheinungsort')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="jahr">Jahr</label>
                        <input type="text"
                               class="form-control @error('jahr') border-danger @enderror" name="jahr" id="jahr"
                               placeholder=""
                               value="{{old('jahr')}}"
                        >
                        @error('jahr')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    @if(Helper::showField('verlag',$literaturart))
                        <div class="form-group">
                            <label for="verlag">Verlag</label>
                            <input type="text"
                                   class="form-control @error('verlag') border-danger @enderror" name="verlag" id="verlag"
                                   placeholder=""
                                   value="{{old('verlag')}}"
                            >
                            @error('verlag')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    @endif

                    @if(Helper::showField('isbn',$literaturart))
                        <div class="form-group">
                            <label for="isbn">ISBN</label>
                            <input type="text"
                                   class="form-control @error('isbn') border-danger @enderror" name="isbn" id="isbn"
                                   placeholder=""
                                   value="{{old('isbn')}}"
                            >
                            @error('isbn')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="issn">ISSN</label>
                        <input type="text"
                               class="form-control @error('issn') border-danger @enderror" name="issn" id="issn"
                               placeholder=""
                               value="{{old('issn')}}"
                        >
                        @error('issn')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    @if(Helper::showField('doi',$literaturart))
                        <div class="form-group">
                            <label for="doi">DOI</label>
                            <input type="text"
                                   class="form-control @error('doi') border-danger @enderror" name="doi" id="doi"
                                   placeholder=""
                                   value="{{old('doi')}}"
                            >
                            @error('doi')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    @endif

                    @if(Helper::showField('inventarnummern',$literaturart))
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
                                            <livewire:inventarnummern-component :medium="new \App\Models\Medium()" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fenster schließen</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    @if(Helper::showField('auflage',$literaturart))
                        <div class="form-group">
                            <label for="auflage">Auflage</label>
                            <input type="text"
                                   class="form-control @error('auflage') border-danger @enderror" name="auflage" id="auflage"
                                   placeholder=""
                                   value="{{old('auflage')}}"
                            >
                            @error('auflage')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    @endif

                    @if(Helper::showField('herausgeber',$literaturart))
                        <div class="form-group">
                            <label for="herausgeber">Herausgeber</label>
                            <input type="text"
                                   class="form-control @error('herausgeber') border-danger @enderror" name="herausgeber" id="herausgeber"
                                   placeholder=""
                                   value="{{old('herausgeber')}}"
                            >
                            @error('herausgeber')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    @endif

                    @if(Helper::showField('zeitschrift_id',$literaturart))
                        <div class="form-group">
                            <label for="zeitschrift_id">Zeitschrift</label>
                            {{--TODO mit Datalist austauschen ??--}}
                            <select class="form-control @error('zeitschrift_id') border-danger @enderror" name="zeitschrift_id" id="zeitschrift_id">
                                <option></option>
                                @foreach(App\Models\Zeitschrift::all() as $zeitschrift)
                                    <option value="{{$zeitschrift->name}}" @if(old('zeitschrift_id')==$zeitschrift->id) selected @endif>{{$zeitschrift->name}} [{{$zeitschrift->shortcut}}]</option>
                                @endforeach
                            </select>
                            {{--                    <input type="text"--}}
                            {{--                           class="form-control @error('zeitschrift_id') border-danger @enderror" name="zeitschrift_id" id="zeitschrift_id" aria-describedby="helpId"--}}
                            {{--                           value="{{$medium->ze itschrift_id}}">--}}
                            @error('zeitschrift_id')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    @endif

                    @if(Helper::showField('schriftenreihe',$literaturart))
                        <div class="form-group">
                            <label for="schriftenreihe">Schriftenreihe</label>
                            <input type="text"
                                   class="form-control @error('schriftenreihe') border-danger @enderror" name="schriftenreihe" id="schriftenreihe"
                                   placeholder=""
                                   value="{{old('schriftenreihe')}}"
                            >
                            @error('schriftenreihe')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="band">Band</label>
                        <input type="text"
                               class="form-control @error('band') border-danger @enderror" name="band" id="band"
                               placeholder=""
                               value="{{old('band')}}"
                        >
                        @error('band')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="seite">Seite</label>
                        <input type="text"
                               class="form-control @error('seite') border-danger @enderror" name="seite" id="seite"
                               placeholder=""
                               value="{{old('seite')}}"
                        >
                        @error('seite')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    @if(Helper::showField('institut',$literaturart))
                        <div class="form-group">
                            <label for="institut">Institut</label>
                            <input type="text"
                                   class="form-control @error('institut') border-danger @enderror" name="institut" id="institut"
                                   placeholder=""
                                   value="{{old('seite')}}"
                            >
                            @error('institut')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="raum_id">Standort</label>
                        <select class="form-control" name="raum_id" id="raum_id">
                            @foreach(App\Models\Raum::all()->pluck('raum') as $raum)
                                <option  @if(old('raum_id')==App\Models\Raum::where('raum',$raum)->first()->id) selected @endif>{{$raum}}</option>
                            @endforeach
                        </select>
                        @error('raum_id')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="bemerkungen">Bemerkungen</label>
                        <textarea type="text"
                                  class="form-control @error('bemerkungen') border-danger @enderror" name="bemerkungen"
                                  id="bemerkungen">{{old('bemerkungen')}}</textarea>
                        @error('bemerkungen')
                        <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" form="createMediumForm" class="btn btn-primary" onclick="$('#inventarnummernForm').submit()">Erstellen</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
