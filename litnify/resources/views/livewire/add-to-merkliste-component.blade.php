<div>
    @if($aufMerkliste==false)
        <button wire:loading.remove type="button" wire:click="add2Merkliste()" class="btn btn-primary btn-sm"><i class="fa fa-star"></i></button>
        <div wire:loading class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    @endif
</div>
