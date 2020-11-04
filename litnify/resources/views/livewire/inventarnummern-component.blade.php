<div>
    @if ($message)
        <div id='success_alert' class="alert alert-success">
            {{$message}}
            <button wire:click.prevent="$set('message',null)" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <button wire:click.prevent="$set('message',null)" type="button" class="btn btn-primary">
            Weitere Inventarnummer hinzufügen erstellen
        </button>
    @else
        @if($errors->any())
            <p class="alert alert-danger">FEHLER {{$errors}}</p>
        @endif
        <div wire:loading.remove>
            <form >
                @foreach($inventarliste as $invlst)
                    <label for="inventarnummer{{$loop->index}}">Inventarnummer {{$loop->index}}</label>
                    <div class="form-group input-group">
                        <input type="text"
                               class="form-control @error('inventarnummer'.$loop->index) border-danger @enderror"
                               value="{{$invlst->inventarnummer}}"
                                readonly>
                        <div class="input-group-append"><button wire:click.prevent="destroy({{$invlst->id}})" class="btn btn-danger"><i class="fa fa-minus"></i></button></div>
                    </div>
                    <div class="form-group input-group">
                        <div class="col ml-5">
                            <input type="checkbox"  wire:click.prevent="updateIsb({{$invlst->id}})"
                                   class="form-check-input"
                                   {{$invlst->isb==1 ? 'checked=["checked"]' : ''}}
                                 >
                            <label  class="form-check-label  {{$invlst->isb==1 ? 'active' : ''}}" for="exampleCheck1">ISB</label>
                        </div>
                        <div class="col ml-auto">
                            <input type="checkbox" wire:click.prevent="updateAusleihbar({{$invlst->id}})"
                                   class="form-check-input" {{$invlst->ausleihbar==1 ? 'checked=["checked"]' : ''}}
                                 >
                            <label class="form-check-label {{$invlst->ausleihbar==1 ? 'active' : ''}}" for="exampleCheck1">ausleihbar</label>
                        </div>
                    </div>
                @endforeach
                <hr>
                <button type="button" class="btn btn-primary btn-block" wire:click.prevent="add({{$i}})"><i class="fa fa-plus"></i> Weitere Inventarnummern hinzufügen</button><br>
                @foreach($inputs as $key=>$val)
                    <label for="inventarnummer.{{$val}}">Inventarnummer {{$val}}</label>
                    <div class="form-group input-group">
                        <input wire:model.defer="inventarnummer.{{$val}}" type="text"
                               class="form-control @error('inventarnummer.'.$val) border-danger @enderror"
                               name="inventarnummer.{{$val}}"
                               id="inventarnummer.{{$val}}"
                               value="{{old('inventarnummer.6')}}" >
                        <div class="input-group-append"><button wire:click.prevent="remove({{$key}})" class="btn btn-primary"><i class="fa fa-minus"></i></button></div>
                    </div>
                        <div class="form-group input-group">
                            <div class="col ml-5">
                                <input type="checkbox" wire:model.defer="isb.{{$val}}"
                                       {{old('isb.'.$val)==1 ? 'checked=["checked"]' : ''}}
                                       class="form-check-input" id="isb.{{$val}}" name="isb.{{$val}}">
                                <label class="form-check-label" for="isb.{{$val}}">ISB</label>
                            </div>
                            <div class="col ml-auto">
                                <input type="checkbox" wire:model.defer="ausleihbar.{{$val}}"
                                       {{old('ausleihbar.'.$val)==1 ? 'checked=["checked"]' : ''}}
                                       class="form-check-input" id="ausleihbar.{{$val}}" name="ausleihbar.{{$val}}">
                                <label class="form-check-label" for="ausleihbar.{{$val}}">ausleihbar</label>
                            </div>
                        </div>
                @endforeach
                <div class="d-flex justify-content-end"><button wire:click.prevent="save" type="button" class="btn btn-primary">Speichern</button></div>
            </form>
        </div>
    <div wire:loading class="spinner-border text-dark" style="width: 3rem; height: 3rem;" role="status"></div>
    @endif
</div>




