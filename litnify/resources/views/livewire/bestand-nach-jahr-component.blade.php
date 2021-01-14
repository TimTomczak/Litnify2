<div>
    <div class="d-flex justify-content-end">
        @if($result->isNotEmpty())
            <p>{{$result->count()}} Ergebnisse</p>
        @endif
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="literaturart_id">Literaturart</label>
                <select wire:model.lazy="literaturart" class="form-control" name="literaturart_id">
                    <option selected></option>
                    @foreach(\App\Models\Literaturart::all() as $litart)
                        <option value="{{$litart->id}}">{{$litart->literaturart}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="jahr">Jahr</label>
                <input wire:model.lazy="jahr" type="text" class="form-control" name="jahr" id="jahr" aria-describedby="helpId" placeholder="Jahr eingeben ...">
            </div>
        </div>

        <div class="col-md-8 mt-n3">
            <div wire:loading>
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            @if($result->isNotEmpty())
                <div wire:loading.remove class="card border-dark p-1">
                    <div class="overflow-auto" style="height: 50vh">
                        <table class="table table-sm table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Literaturart</th>
                                <th>Signatur</th>
                                <th>Hauptsachtitel</th>
                                <th>Jahr</th>
                                <th>Aktion</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($result as $res)
                                <tr>
                                    <td>{{$res->id}}</td>
                                    <td><i class="{{\App\Helpers\Helper::$literaturartenIcons[$res->literaturart_id]}}"></i></td>
                                    <td>{{$res->signatur}}</td>
                                    <td>{{--<a href="#" class="render-medium-modal" data-id="{{$res->id}}">--}}{{$res->hauptsachtitel}}{{--</a>--}}</td>
                                    <td>{{$res->jahr}}</td>
                                    <td><a href="{{route('medium.show',$res->id)}}"><button class="{{$aktionenStyles['show']['button-class']}}" title="Medium ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
