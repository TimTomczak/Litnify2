<div>
    @if($aufMerkliste==false)
        <button wire:loading.remove type="button" wire:click="add2Merkliste()" class="btn btn-{{$isAusleihbar==false ? 'primary' : 'success'}} btn-sm"><i class="fa {{$isAusleihbar==false ? 'fa-star-o' : 'fa-star'}}"></i></button>
        <div wire:loading class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    @endif
</div>



