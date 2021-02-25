<div>
    <div class="m-2">
        <div class="input-group">
            <div class="input-group-append">
                <button type="button" class="btn btn-outline-primary" type="button" aria-label="">Zeitschriften duchsuchen</button>
            </div>
            <input wire:model.debounce.500ms="searchQuery" type="text" class="form-control" name="zeitschtift" placeholder="" aria-label="">
        </div>
    </div>
    @if($zeitschriften->isNotEmpty())
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
            @foreach($zeitschriften as $zeitschrift)
                <tr>

                    @foreach($tableBuilder as $key=>$val)
                        <td>{{$zeitschrift->attributesToArray()[$key]}}</td>
                    @endforeach
                    <td>{{--Aktionen--}}
                        <div class="d-flex border-0 justify-content-around">
                            @role(3)
                            <a href="{{route('zeitschrift.edit',$zeitschrift->id)}}"><button class="{{$aktionenStyles['edit']['button-class']}}" title="Medium bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button></a>
                            @endrole
                            @if($deleted==0)
                                @role(3)
                                    <form action="{{route('zeitschrift.destroy',$zeitschrift->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Medium löschen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                                    </form>
                                @endrole
                            @else
                                <form action="{{route('zeitschrift.recover',$zeitschrift->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="{{$aktionenStyles['reactivate']['button-class']}}" title="Medium löschen"><i class="{{$aktionenStyles['reactivate']['icon-class']}}"></i></button>
                                </form>
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
                {{ $zeitschriften->links() }}
            </div>
            <div class="p-2">
                <a href="{{route('zeitschrift.create')}}"><button class="btn btn-primary">Neue Zeitschrift erstellen</button></a>
            </div>
            <div class="p-2">
                @livewire('export-panel',['withBib'=>false,'exportData'=>$exportData,'downloadName'=>'Zeitschriften','cols'=>$tableBuilder])
            </div>
        </div>

    </div>
    @endif
    <div wire:loading>
        <div  class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
