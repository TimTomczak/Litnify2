<div>

    <div class="form-group">
        <label for="autoren">Autoren <button wire:click.prevent="add({{$i}})" class="btn btn-primary btn-sm">Weiteren Autor hinzufügen <i class="fa fa-plus-square"></i></button></label>
        @foreach($autoren as $aut)
            @if(!empty($aut))
                <div class="row ">
                    @if($aut == 'et al.')
                        <div class="col">
                            <label for="et_al">Et al.</label>
                            <input type="text"
                                   class="form-control @error('autoren'){{--TODO Error korrigieren--}} border-danger @enderror" name="et_al" id="et_al" value="{{$aut}}">
                        </div>
                    @else
                        <div class="col">
                            <label for="nachname{{$loop->index}}">Nachname {{$loop->index}} </label>
                            <input type="text"
                                   class="form-control @error('autoren') border-danger @enderror" name="nachname{{$loop->index}}" id="nachname{{$loop->index}}" value="{{explode(',',$aut)[0]}}">
                        </div>
                        <div class="col">
                            <label for="vorname{{$loop->index}}">Vorname</label>
                            <div class="input-group">
                                <input type="text"
                                       class="form-control @error('autoren') border-danger @enderror" name="vorname{{$loop->index}}" id="vorname{{$loop->index}}" value="{{explode(',',$aut)[1]}}">
                                <div class="input-group-append ml-3 rounded-left">
                                    <button wire:click.prevent="removeAutor({{$loop->index}})" class="btn btn-danger"><i class="fa fa-minus-square"></i></button>
                                </div>
                            </div>
                        </div>

                    @endif

                </div>
            @endif
        @endforeach

        @foreach($inputs as $key => $val)
            <div class="row">
                <div class="col">
                    <label for="nachname{{$val}}">Nachname {{$val}}</label>
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
    </div>

</div>
