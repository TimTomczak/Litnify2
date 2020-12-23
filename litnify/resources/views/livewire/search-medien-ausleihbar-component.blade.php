<div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <button class="btn btn-outline-primary" type="button" aria-label="">Ausleihbare Medien durchsuchen</button>
            </div>
            <input wire:model.debounce.1000ms="suche" type="text" class="form-control" name="name" id="name" placeholder="" aria-label="">
        </div>
    </div>

    <div wire:loading.remove>
        <table class="{{$tableStyle}}">
            <thead>
            <tr>
                @foreach($tableBuilder as $key=>$val)
                    <th>{{$val}}</th>
                @endforeach
                <th>Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($medien as $med)
                <tr>
                    @foreach($tableBuilder as $key=>$val)
                        @switch($key)
{{--                            @case('literaturart_id')--}}
{{--                            <td>{{$med->literaturart->literaturart}}</td>--}}
{{--                            @break--}}

                            @case('hauptsachtitel')
                            <td class="text-wrap"><a href="#" class="render-medium-modal" data-id="{{$med->id}}">{{$med->attributesToArray()[$key]}}</a></td>
                            @break

                            @case('autoren')
                            <td>
                                @foreach(explode(';',$med->autoren) as $autor)
                                    {{$autor}}<br>
                                @endforeach
                            </td>
                            @break

                            @default
                            <td>{{$med->attributesToArray()[$key]}}</td>

                        @endswitch
                    @endforeach
                    <td>
                        <div class="d-flex border-0 justify-content-around">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modelId{{$med->id}}">
                                <i class="fa fa-calendar-plus-o"></i>
                            </button>
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
                                        <form action="{{route('ausleihe.store',[$user->id,$med->id])}}" method="POST">
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
            {{ $medien->links() }}
        </div>
    </div>
    <div wire:loading>
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    @include('admin.medienverwaltung.mediummodal')
</div>
