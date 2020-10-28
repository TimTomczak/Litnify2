@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card p-4 bg-light">
            <form action="{{route('medium.store')}}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text"
                           class="form-control @error('id') border-danger @enderror" name="id" id="id"
                           value="{{$medium->id}}"
                           readonly>
                    @error('id')
                    <div class="invalid-feedback">ID nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="literaturart_id">Literaturart</label>
                    <input type="text"
                           class="form-control @error('literaturart_id') border-danger @enderror" name="literaturart_id" id="literaturart_id"
                           value="{{$medium->literaturart_id}}"
                           readonly>
                    @error('literaturart_id')
                    <div class="invalid-feedback">Literaturart nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="signatur">Signatur</label>
                    <input type="text"
                           class="form-control @error('signatur') border-danger @enderror" name="signatur" id="signatur"
                           value="{{$medium->signatur}}">
                    @error('signatur')
                    <div class="invalid-feedback">signatur nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="autoren">Autoren</label>
                    @foreach(explode(';',$medium->autoren) as $aut)
                    <div class="row">
                        @if($aut == 'et al.')
                            <div class="col">
                                <label for="et_al">Et al.</label>
                                <input type="text"
                                       class="form-control @error('autoren') border-danger @enderror" name="et_al" id="et_al" value="{{$aut}}">
                            </div>
                        @else
                            <div class="col">
                                <label for="nachname{{$loop->index}}">Nachname</label>
                                <input type="text"
                                       class="form-control @error('autoren') border-danger @enderror" name="nachname{{$loop->index}}" id="nachname{{$loop->index}}" value="{{explode(',',$aut)[0]}}">
                            </div>
                            <div class="col">
                                <label for="vorname{{$loop->index}}">Vorname</label>
                                <input type="text"
                                       class="form-control @error('autoren') border-danger @enderror" name="vorname{{$loop->index}}" id="vorname{{$loop->index}}" value="{{explode(',',$aut)[1]}}">
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <label for="hauptsachtitel">Hauptsachtitel</label>
                    <textarea type="text"
                           class="form-control @error('hauptsachtitel') border-danger @enderror" name="hauptsachtitel" id="hauptsachtitel">
                        {{$medium->hauptsachtitel}}
                    </textarea>
                    @error('hauptsachtitel')
                    <div class="invalid-feedback">hauptsachtitel nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="untertitel">Untertitel</label>
                    <input type="text"
                           class="form-control @error('untertitel') border-danger @enderror" name="untertitel" id="untertitel"
                           value="{{$medium->untertitel}}">
                    @error('untertitel')
                    <div class="invalid-feedback">untertitel nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="enthalten_in">Enthalten in</label>
                    <input type="text"
                           class="form-control @error('enthalten_in') border-danger @enderror" name="enthalten_in" id="enthalten_in" aria-describedby="helpId"
                           value="{{$medium->enthalten_in}}">
                    @error('enthalten_in')
                    <div class="invalid-feedback">enthalten_in nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="erscheinungsort">Erscheinungsort</label>
                    <input type="text"
                           class="form-control @error('erscheinungsort') border-danger @enderror" name="erscheinungsort" id="erscheinungsort"
                           value="{{$medium->erscheinungsort}}">
                    @error('erscheinungsort')
                    <div class="invalid-feedback">erscheinungsort nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jahr">Jahr</label>
                    <input type="text"
                           class="form-control @error('jahr') border-danger @enderror" name="jahr" id="jahr"
                           value="{{$medium->jahr}}">
                    @error('jahr')
                    <div class="invalid-feedback">jahr nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="verlag">Verlag</label>
                    <input type="text"
                           class="form-control @error('verlag') border-danger @enderror" name="verlag" id="verlag"
                           value="{{$medium->verlag}}">
                    @error('verlag')
                    <div class="invalid-feedback">verlag nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text"
                           class="form-control @error('isbn') border-danger @enderror" name="isbn" id="isbn"
                           value="{{$medium->isbn}}">
                    @error('isbn')
                    <div class="invalid-feedback">isbn nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="issn">ISSN</label>
                    <input type="text"
                           class="form-control @error('issn') border-danger @enderror" name="issn" id="issn"
                           value="{{$medium->issn}}">
                    @error('issn')
                    <div class="invalid-feedback">issn nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inventarnummer">Inventarnummer</label>
                    <input type="text"
                           class="form-control @error('inventarnummer') border-danger @enderror" name="inventarnummer" id="inventarnummer"
                           value="{{$medium->inventarnummer}}">
                    @error('inventarnummer')
                    <div class="invalid-feedback">inventarnummer nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="auflage">Auflage</label>
                    <input type="text"
                           class="form-control @error('auflage') border-danger @enderror" name="auflage" id="auflage"
                           value="{{$medium->auflage}}">
                    @error('auflage')
                    <div class="invalid-feedback">auflage nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="herausgeber">Herausgeber</label>
                    <input type="text"
                           class="form-control @error('herausgeber') border-danger @enderror" name="herausgeber" id="herausgeber"
                           value="{{$medium->herausgeber}}">
                    @error('herausgeber')
                    <div class="invalid-feedback">herausgeber nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="schriftenreihe">Schriftenreihe</label>
                    <input type="text"
                           class="form-control @error('schriftenreihe') border-danger @enderror" name="schriftenreihe" id="schriftenreihe"
                           value="{{$medium->schriftenreihe}}">
                    @error('schriftenreihe')
                    <div class="invalid-feedback">schriftenreihe nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="band">Band</label>
                    <input type="text"
                           class="form-control @error('band') border-danger @enderror" name="band" id="band"
                           value="{{$medium->band}}">
                    @error('band')
                    <div class="invalid-feedback">band nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="seite">Seite</label>
                    <input type="text"
                           class="form-control @error('seite') border-danger @enderror" name="seite" id="seite"
                           value="{{$medium->seite}}">
                    @error('seite')
                    <div class="invalid-feedback">seite nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="standort">Standort</label>
                    <select class="form-control" id="standort">
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
                    @error('standort')
                    <div class="invalid-feedback">standort nicht korrekt.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bemerkungen">Bemerkungen</label>
                    <input type="text"
                           class="form-control @error('bemerkungen') border-danger @enderror" name="bemerkungen" id="bemerkungen"
                           value="{{$medium->bemerkungen}}">
                    @error('bemerkungen')
                    <div class="invalid-feedback">bemerkungen nicht korrekt.</div>
                    @enderror
                </div>

            </form>
        </div>
    </div>
@endsection
