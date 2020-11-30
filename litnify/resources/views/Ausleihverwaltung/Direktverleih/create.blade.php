@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card text-center bg-light mb-3">
            <div class="card-body">
                <h5 class="card-title">Direktverleih für Nutzer</h5>
                <p class="card-text">{{$user->nachname}}, {{$user->vorname}}</p>
                <p class="card-text">{{$user->email}}</p>
            </div>
        </div>
        @livewire('search-medien-ausleihbar-component',['medien'=>$medien,'user'=>$user])
{{--        <table class="{{$tableStyle}}">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                @foreach($tableBuilder as $key=>$val)--}}
{{--                    <th>{{$val}}</th>--}}
{{--                @endforeach--}}
{{--                <th>Aktionen</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach($medien as $med)--}}
{{--                <tr>--}}
{{--                    @foreach($tableBuilder as $key=>$val)--}}
{{--                        @switch($key)--}}
{{--                            @case('id')--}}
{{--                            <td>{{$med->medium_id}}</td>--}}
{{--                            @break--}}

{{--                            @case('literaturart_id')--}}
{{--                            <td>{{\App\Models\Literaturart::find($med->literaturart_id)->literaturart}}</td>--}}
{{--                            @break--}}

{{--                            @case('hauptsachtitel')--}}
{{--                            <td class="text-wrap"><a class="render-medium-modal" data-id="{{$med->medium_id}}">{{$med->attributesToArray()[$key]}}</a></td>--}}
{{--                            @break--}}

{{--                            @case('autoren')--}}
{{--                            <td>--}}
{{--                                @foreach(explode(';',$med->autoren) as $autor)--}}
{{--                                    {{$autor}}<br>--}}
{{--                                @endforeach--}}
{{--                            </td>--}}
{{--                            @break--}}

{{--                            @default--}}
{{--                            <td>{{$med->attributesToArray()[$key]}}</td>--}}

{{--                        @endswitch--}}
{{--                    @endforeach--}}
{{--                    <td>--}}
{{--                        <div class="d-flex border-0 justify-content-around">--}}
{{--                            <a href="{{route('medium.show',$med->medium_id)}}"><button class="{{$aktionenStyles['show']['button-class']}}" title="Medium ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a>--}}
{{--                            <a href="{{route('medium.edit',$med->medium_id)}}"><button class="{{$aktionenStyles['edit']['button-class']}}" title="Medium bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button></a>--}}
{{--                            <form action="{{route('medium.destroy',$med->medium_id)}}" method="POST">--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Medium löschen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>--}}
{{--                            </form>--}}
{{--                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelId{{$med->id}}">--}}
{{--                                    <i class="fa fa-calendar-plus-o"></i> ausleihen--}}
{{--                                </button>--}}

{{--                            <!-- Modal -->--}}
{{--                            <div class="modal fade" id="modelId{{$med->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">--}}
{{--                                <div class="modal-dialog" role="document">--}}
{{--                                    <div class="modal-content">--}}
{{--                                        <div class="modal-header">--}}
{{--                                            <h5 class="modal-title">Ausleihe</h5>--}}
{{--                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                                <span aria-hidden="true">&times;</span>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                        <form action="{{route('ausleihe.store',[$user,$med->medium_id])}}" method="POST">--}}
{{--                                            @csrf--}}

{{--                                            <div class="modal-body">--}}

{{--                                                <div class="form-group">--}}
{{--                                                    <label for="inventarnummer">Inventarnummer</label>--}}
{{--                                                    <select class="form-control" name="inventarnummer">--}}
{{--                                                        <option>{{old('inventarnummer')}}</option>--}}
{{--                                                        @foreach(\App\Models\Medium::find($med->medium_id)->getInventarnummernAusleihbar() as $invAus)--}}
{{--                                                            <option value="{{$invAus}}">{{$invAus}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                    <small class="form-text text-muted">Für das Medium ausleihbare Inventarnummern</small>--}}
{{--                                                    @error('inventarnummer')--}}
{{--                                                    <div class="invalid-feedback d-block">{{$message}}</div>--}}
{{--                                                    @enderror--}}
{{--                                                </div>--}}
{{--                                                <br>--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <label for="ausleihzeitraum">Ausleihzeitraum (voreingestellt: <strong>{{$ausleihdauerDefault}}</strong> Tage)</label>--}}
{{--                                                    <input class="form-control" type="text" name="ausleihzeitraum" data-ausleihdauer="{{$ausleihdauerDefault}}" value="{{old('ausleihzeitraum')}}"/>--}}
{{--                                                    @error('Ausleihdatum')--}}
{{--                                                    <div class="invalid-feedback d-block">{{$message}}</div>--}}
{{--                                                    @enderror--}}
{{--                                                    @error('RueckgabeSoll')--}}
{{--                                                    <div class="invalid-feedback d-block">{{$message}}</div>--}}
{{--                                                    @enderror--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="modal-footer">--}}
{{--                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                                                <button type="submit" class="btn btn-primary">Save</button>--}}
{{--                                            </div>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}

{{--            </tbody>--}}
{{--        </table>--}}
{{--        <div class="d-flex justify-content-between">--}}
{{--            {{ $medien->links() }}--}}
{{--        </div>--}}
    </div>
    @include('Medienverwaltung.mediumModal')
@endsection

@include('Ausleihverwaltung.dateTimePicker')
