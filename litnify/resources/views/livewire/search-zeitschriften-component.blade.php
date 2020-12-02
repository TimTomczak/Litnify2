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
        <table  class="{{$tableStyle}}">
            <thead>
            <tr>
                @foreach($tableBuilder as $key=>$val)
                    <th>{{$val}}</th>
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
                            <form action="{{route('zeitschrift.destroy',$zeitschrift->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Medium löschen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                            </form>
                            @endrole
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-between">
            {{ $zeitschriften->links() }}
            <a href="{{route('zeitschrift.create')}}"><button class="btn btn-primary">Neue Zeitschrift erstellen</button></a>
        </div>
    </div>
    @endif
    <div wire:loading>
        <div  class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
