<div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <button type="button" class="btn btn-outline-primary" type="button" aria-label="">Medien durchsuchen</button>
        </div>
        <input wire:model.debounce.500ms="searchQuery" type="text" class="form-control" name="name" id="name" placeholder="" aria-label="">
    </div>

    @if($medien->count()==0)
        <div class="alert alert-info m-2">INFO: Derzeit sind keine Medien in der Datenbank vorhanden !</div>
    @else
        <div wire:loading.remove>
        <table class="{{$tableStyle}}">
            <thead>
            <tr>
                @foreach($tableBuilder as $key=>$val)
                    <th wire:click="sortBy('{{$key}}')">{{$val}} @if($sortBy===$key)<i class="fa {{$sortDirection==='desc' ? 'fa-sort-alpha-asc' : 'fa-sort-alpha-desc'}}"</i> @endif</th>
                @endforeach
                <th>Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($medien as $med)
                <tr>
                    @foreach($tableBuilder as $key=>$val)
                        @switch($key)
                            @case('literaturart_id')
                            <td>{{$med->literaturart->literaturart}}</td>
                            @break

                            @case('zeitschrift_id')
                            <td>{{$med->zeitschrift!=null ? $med->zeitschrift->name : ''}}</td>
                            @break

                            @case('raum_id')
                            <td>{{$med->raum!=null ? $med->raum->raum : ''}}</td>
                            @break

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
                            <a href="{{route('medium.show',$med->id)}}"><button class="{{$aktionenStyles['show']['button-class']}}" title="Medium ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a>
                            <a href="{{route('medium.edit',$med->id)}}"><button class="{{$aktionenStyles['edit']['button-class']}}" title="Medium bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button></a>
                            @if($deleted==0)
                                @role(3)
                                <form action="{{route('medium.destroy',$med->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Medium löschen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                                </form>
                                @endrole
                            @else
                                <form action="{{route('medium.recover',$med->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="{{$aktionenStyles['reactivate']['button-class']}}" title="Medium wiederherstellen"><i class="{{$aktionenStyles['reactivate']['icon-class']}}"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            {{ $medien->links() }}
            <a href="{{route('medium.createEmpty','')}}"><button type="submit" class="btn btn-primary">Neues Medium erstellen</button></a>
        </div>
        </div>
    @endif
    <div wire:loading>
        <div  class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    @include('admin.Medienverwaltung.mediumModal')

</div>
