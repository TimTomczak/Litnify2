<div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-prepend"><button disabled type="button" class="btn btn-outline-primary">Nutzer suchen:</button></span>
            <input wire:model.debounce.500ms="searchQuery" type="text" class="form-control" name="searchQuery" id="searchQuery" autofocus>
        </div>
    </div>
    @if($users->isNotEmpty())
        <table class="{{$tableStyle}}">
            <thead>
            <tr>
                @foreach($tableBuilder as $key=>$val)
                    <th scope="col" wire:click="sortBy('{{$key}}')">{{$val}} @if($sortBy===$key)<i class="fa {{$sortDirection==='desc' ? 'fa-sort-alpha-asc' : 'fa-sort-alpha-desc'}}"</i> @endif</th>
                @endforeach
                <th>Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr
                @if($user->deleted == 1)
                    class="table-danger"
                @endif
                 >
                    @foreach($tableBuilder as $key=>$val)
                        @switch($key)
                            @case('id')
                            <td scope="row">{{$user->attributesToArray()[$key]}}</td>
                            @break

                            @case('berechtigungsrolle_id')
                            <td>{{$user->berechtigungsrolle->berechtigungsrolle}}</td>
                            @break

                            @case('created_at')
                            <td>{{$user->attributesToArray()[$key]!=null ? $user->created_at->format('d.m.Y  G:i') : ''}}</td>
                            @break

                            @default
                            <td>{{$user->attributesToArray()[$key]}}</td>
                        @endswitch
                    @endforeach

                        @if($user->deleted == 1)
                            <td>
                                <form action="{{route('admin.nutzerverwaltung.wakeup',$user->id)}}" method="post" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="{{$aktionenStyles['reactivate']['button-class']}}" title="Aktivieren">
                                        <i class="{{$aktionenStyles['reactivate']['icon-class']}}"></i>
                                    </button>
                                </form>
                            </td>
                        @elseif($user->id == Auth::user()->id)
                            <td></td>
                        @else
                            <td>
                                <a href="{{route('admin.nutzerverwaltung.edit',$user->id)}}" class="{{$aktionenStyles['edit']['button-class']}}" title="Bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></a>

                                <form action="{{route('admin.nutzerverwaltung.delete',$user->id)}}" method="post" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Deaktivieren">
                                        <i class="{{$aktionenStyles['delete']['icon-class']}}"></i>
                                    </button>
                                </form>

                            </td>
                        @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            {{ $users ->links() }}
        </div>
    @else
        <div class="alert alert-info">Keine Nutzer gefunden.</div>
    @endif
</div>
