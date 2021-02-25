<div>
    <div wire:loading.remove>
        <div class="btn-group" role="group" style="display: inline">
            <button id="btnGroupExport" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-floppy-o" aria-hidden="true"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupExport">
                <a wire:click="exportPdf" href="#" class="dropdown-item"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF </a>
                <a wire:click="exportXls" class="dropdown-item" href="#"><i class="fa fa-file-excel-o" aria-hidden="true"></i> XLS </a>
                <a wire:click="exportCsv" class="dropdown-item" href="#"><i class="fa fa-table" aria-hidden="true"></i> CSV </a>
                @if($withBib===true)
                    <a wire:click="exportBib" class="dropdown-item" href="#"><i class="fa fa-book" aria-hidden="true"></i> BIB</a>
                @endif
            </div>
        </div>
    </div>
    <div wire:loading>
        <button type="button" class="btn btn-primary" >
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </button>
    </div>

</div>
