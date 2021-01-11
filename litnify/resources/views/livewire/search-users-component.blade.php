<div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-prepend"><button disabled type="button" class="btn btn-outline-primary">Nutzer suchen:</button></span>
            <input wire:model.debounce.500ms="searchQuery" type="text" class="form-control" name="searchQuery" id="searchQuery" autofocus>
        </div>
    </div>
    @if($users->isNotEmpty())
        <div wire:loading.remove>
            <table class="{{$tableStyle}}">
                <thead>
                <tr>
                    @foreach($tableBuilder as $key=>$val)
                        <th scope="col" wire:click="sortBy('{{$key}}')">{{$val}}  @if($sortBy===$key)<i class="fa {{$sortDirection==='desc' ? 'fa-sort-alpha-asc' : 'fa-sort-alpha-desc'}}"></i> @endif</th>
                    @endforeach
                    <th>Aktionen</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    @if($user->deleted == 1)
{{--                        <tr style="background: repeating-linear-gradient(135deg,#ff0025,#ff0027 7px,#FFFFFF 7px,#FFFFFF 20px);">--}}
                        <tr>
                    @else
                        <tr>
                    @endif
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
                        @if($nutzerverwaltung==false)
                        <td>
                            <a href="{{route('direktverleih.create',$user->id)}}" class="{{$aktionenStyles['show']['button-class']}}" title="ausleihen"><i class="fa fa-share"></i></a>
                        </td>
                        @else
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
                                <td style="background: repeating-linear-gradient(135deg,#cccccc,#cccccc 10px,#FFFFFF 10px,#FFFFFF 20px);"></td>
                            @else
                                <td>
                                    <a href="{{route('admin.nutzerverwaltung.edit',$user->id)}}" class="{{$aktionenStyles['edit']['button-class']}}" title="Nutzer bearbeiten"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></a>
                                    <a href="{{route('ausleihe.show',$user->id)}}"><button class="{{$aktionenStyles['show']['button-class']}}" title="Ausleihen des Nutzers ansehen"><i class="fa fa-list"></i>
                                        </button></a>
                                    <form action="{{route('admin.nutzerverwaltung.delete',$user->id)}}" method="post" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Nutzer deaktivieren">
                                            <i class="{{$aktionenStyles['delete']['icon-class']}}"></i>
                                        </button>
                                    </form>

                                </td>
                            @endif
                        @endif

                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                {{ $users->links() }}
            </div>
        </div>
        <div wire:loading>
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    @else
        <div class="alert alert-info">Keine Nutzer gefunden.</div>
    @endif
</div>
