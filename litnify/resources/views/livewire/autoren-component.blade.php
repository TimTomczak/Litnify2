<div>

    <div class="form-group">
        <label for="autoren">Autoren <button wire:click.prevent="add({{$i}})" class="btn btn-primary btn-sm">Autor hinzufügen <i class="fa fa-plus-square"></i></button></label>
        @if(isset($autoren))
            @foreach($autoren as $aut)
                @if(!empty($aut))
                    <div class="row ">
                        @if($aut == 'et al.')
                            <div class="col">
                                <label id="et_al_label" for="et_al">Et al.</label>
                                <div class="input-group">
                                    <input type="text" wire:init="$set('et_al', true)"
                                           class="form-control @error('et_al') border-danger @enderror" name="et_al" id="et_al" value="{{$aut}}" readonly>
                                    <div class="input-group-append ml-3 rounded-left">
                                        <button wire:click.prevent="$set('et_al', false)" class="btn btn-danger"><i class="fa fa-minus-square"></i></button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col">
                                <label for="nachname{{$loop->index}}">Nachname</label>
                                <input type="text"
                                       class="form-control @error('nachname'.$loop->index) border-danger @enderror" name="nachname{{$loop->index}}" id="nachname{{$loop->index}}" value="{{explode(',',$aut)[0]}}">
                            </div>
                            <div class="col">
                                <label for="vorname{{$loop->index}}">Vorname</label>
                                <div class="input-group">
                                    <input type="text"
                                           class="form-control @error('vorname'.$loop->index) border-danger @enderror" name="vorname{{$loop->index}}" id="vorname{{$loop->index}}" value="{{explode(',',$aut)[1]}}">
                                    <div class="input-group-append ml-3 rounded-left">
                                        <button wire:click.prevent="removeAutor({{$loop->index}})" class="btn btn-danger"><i class="fa fa-minus-square"></i></button>
                                    </div>
                                </div>
                            </div>

                        @endif

                    </div>
                @endif
            @endforeach
        @endif

        @foreach($inputs as $key => $val)
            <div class="row">
                <div class="col">
                    <label for="nachname{{$val}}">Nachname</label>
                    <input type="text"
                           class="form-control @error('autoren') border-danger @enderror" name="nachname{{$val}}" id="nachname{{$val}}">
                </div>
                <div class="col">
                    <label for="vorname{{$val}}">Vorname</label>
                    <div class="input-group">
                        <input type="text"
                               class="form-control @error('autoren') border-danger @enderror" name="vorname{{$val}}" id="vorname{{$val}}">
                        <div class="input-group-append ml-3 rounded-left">
                            <button wire:click.prevent="remove({{$key}})" class="btn btn-danger"><i class="fa fa-minus-square"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if(!$et_al)
            <br>
            <button type="button" wire:click.defer="$set('et_al', true)" class="btn btn-primary btn-sm">Et al. <i class="fa fa-plus-square"></i></button>
        @else
            <label id="et_al_label" for="et_al">Et al.</label>
            <div class="input-group">
                <input class="form-control @error('et_al') border-danger @enderror" type="text" name="et_al" id="et_al" value="et al." readonly>
                <div class="input-group-append ml-3 rounded-left">
                    <button wire:click.prevent="$set('et_al', false)" class="btn btn-danger"><i class="fa fa-minus-square"></i></button>
                </div>
            </div>
        @endif
    </div>

</div>
