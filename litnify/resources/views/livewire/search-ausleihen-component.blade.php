<div>
    <h4>{{$showAktiv==true ? 'Aktive Ausleihen' : 'Beendete Ausleihen'}}</h4>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <button class="btn btn-outline-primary" type="button" aria-label="">Ausleihen durchsuchen</button>
        </div>
        <input wire:model.debounce.500ms="searchQuery" type="text" class="form-control" name="name" id="name" placeholder="" aria-label="">
    </div>

    <table class="table table-responsive-lg table-hover table-bordered">
        <thead>
        <tr>
            @foreach($tableBuilder as $key=>$val)
                <th>{{$val}}</th>
            @endforeach
            <th>Aktionen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($ausleihen as $aus)
            <tr {{strtotime($aus->RueckgabeSoll)<time() ? 'style=background-color:#f9d6d5' : ''}}>
                @foreach($tableBuilder as $key=>$val)
                    @switch($key)
                        @case('medium_id')
                        <td><a href="#" class="render-medium-modal" data-id="{{$aus->medium_id}}">{{$aus->attributesToArray()[$key]}}</a></td>
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
                        @if($deleted==1)
                            <form action="{{route('ausleihe.recover',$aus->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="{{$aktionenStyles['reactivate']['button-class']}}" title="Ausleihe wiederherstellen"><i class="{{$aktionenStyles['reactivate']['icon-class']}}"></i></button>
                            </form>
                        @else
                            <a href="{{route('ausleihe.show',$aus->user_id)}}"><button class="{{$aktionenStyles['show']['button-class']}}" title="Ausleihen des Nutzers ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a>

                            @role(3)
                            <a href="{{route('ausleihe.edit',$aus->id)}}"><button class="{{$aktionenStyles['edit']['button-class']}}" title="Ausleihe bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button></a>
                            <form action="{{route('ausleihe.destroy',$aus->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Ausleihe löschen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                            </form>
                            @if($showAktiv)
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
                            @endif
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex">
        <div class="mr-auto p-2">
            {{ $ausleihen->links() }}
        </div>
        @livewire('export-panel',['withBib'=>false,'exportData'=>$exportData,'downloadName'=>'Ausleihen','cols'=>$tableBuilder])
    </div>

    @include('admin.medienverwaltung.mediummodal')
</div>
