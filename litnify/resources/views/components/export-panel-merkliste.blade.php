<div class="btn-group" role="group" style="display: inline">
    <button id="btnGroupExport" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-floppy-o" aria-hidden="true"></i>
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupExport">
        <a class="dropdown-item" href="{{route('download',['export' => 'merkliste' , 'type' => 'pdf'])}}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF </a>
        <a class="dropdown-item" href="{{route('download',['export' => 'merkliste', 'type' => 'xls'])}}"><i class="fa fa-file-excel-o" aria-hidden="true"></i> XLS </a>
        <a class="dropdown-item" href="{{route('download',['export' => 'merkliste',  'type' => 'csv'])}}"><i class="fa fa-table" aria-hidden="true"></i> CSV </a>
        <a class="dropdown-item" href="{{route('download',['export' => 'merkliste',  'type' => 'bib'])}}"><i class="fa fa-book" aria-hidden="true"></i> BIB</a>
    </div>
</div>
