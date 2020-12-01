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
                    <th scope="col">{{$val}}</th>
                @endforeach
                <th>Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
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
                    <td>
                        <a href="{{route('admin.nutzerverwaltung.edit',$user->id)}}" class="{{$aktionenStyles['edit']['button-class']}}" title="Bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></a>
                        <a href="{{route('admin.nutzerverwaltung.delete',$user->id)}}" class="{{$aktionenStyles['delete']['button-class']}}" title="Deaktivieren"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></a>
                    </td>

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
