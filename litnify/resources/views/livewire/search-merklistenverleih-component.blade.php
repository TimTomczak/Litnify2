<div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <button type="button" class="btn btn-outline-primary" type="button" aria-label="">Merklisten durchsuchen</button>
        </div>
        <input wire:model.debounce.500ms="searchQuery" type="text" class="form-control" name="name" id="name" placeholder="" aria-label="">
    </div>

    @if($merklisten->count()==0)
        <div class="alert alert-info m-2">Keine Merklisten gefunden</div>
    @else
        <div wire:loading.remove>
            <table class="{{$tableStyle}}">
                <thead>
                <tr>
                    @foreach($tableBuilder as $key=>$val)
                        <th wire:click="sortBy('{{$key}}')">{{$val}} @if($sortBy===$key)<i class="fa {{$sortDirection==='desc' ? 'fa-sort-alpha-asc' : 'fa-sort-alpha-desc'}}"</i> @endif</th>
                    @endforeach
                    <th>Aktion</th>
{{--                    <th wire:click="sortBy('id')">ID Nutzer @if($sortBy==='id')<i class="fa {{$sortDirection==='desc' ? 'fa-sort-alpha-asc' : 'fa-sort-alpha-desc'}}"</i> @endif</th>--}}
{{--                    <th wire:click="sortBy('email')">E-Mail-Adresse @if($sortBy==='email')<i class="fa {{$sortDirection==='desc' ? 'fa-sort-alpha-asc' : 'fa-sort-alpha-desc'}}"</i> @endif</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($merklisten as $merk)
                    <tr>
                        @foreach($tableBuilder as $key=>$val)
                            <td>{{$merk->attributesToArray()[$key]}}</td>
                        @endforeach
{{--                        <td>{{$merk->user_id}}</td>--}}
{{--                        <td>{{$merk->email}}</td>--}}
{{--                        <td>{{$merk->name}}</td>--}}
{{--                        <td>{{\App\Models\Merkliste::where('user_id',$merk->user_id)->count()}}</td>--}}
{{--                        <td>--}}
{{--                            {{\App\Models\Merkliste::where('user_id',$merk->user_id)->get()->filter(function($med){--}}
{{--                                if ($med->medium->isAusleihbar()){--}}
{{--                                    return $med->medium;--}}
{{--                                }--}}
{{--                                })->count()}}--}}
{{--                        </td>--}}
                        <td>
                            <a href="{{route('merklistenverleih.show',$merk->user_id)}}" class="btn btn-primary btn-sm">zum Verleih</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                {{ $merklisten->links() }}
            </div>
        </div>
    @endif
    <div wire:loading>
        <div  class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    @include('admin.medienverwaltung.mediummodal')

</div>
