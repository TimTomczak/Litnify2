<div>
     <div wire:loading.remove class="col-sm-10">
        <label>Systematikgruppen</label>
        @foreach($inputs as $key => $val)
            <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control" name="sysgrp{{$val}}" id="sysgrp{{$val}}" list="sysgrps" placeholder="ANW-0, BMA3 ...">
                    <div class="input-group-append rounded-left">
                        <button wire:click.prevent="remove({{$key}})" class="btn btn-danger"><i class="fa fa-minus-square"></i></button>
                    </div>
                </div>
            </div>
        @endforeach
        <button wire:click.prevent="add({{$i}})" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i></button>
    </div>
    <datalist id="sysgrps">
        @foreach($systematikgruppen as $sysgrp)
            <option value="{{$sysgrp}}"></option>
        @endforeach
    </datalist>

    <div wire:loading>
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
