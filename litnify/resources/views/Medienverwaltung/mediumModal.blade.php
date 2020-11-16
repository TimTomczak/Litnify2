<!-- Modal -->
<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modalContent" class="modal-body">
                Body
            </div>
            <div class="modal-footer">
                <a id="showMediumBtn" class="btn btn-primary">Öffnen</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@section('javascript.footer')
    <script>
        $(".render-medium-modal").click(function( event) {
            var $mediumId = $(this).data('id');
            $('#modalContent').load('medium/'+$mediumId+' #medium');
            $('#showMediumBtn').attr('href','medium/'+$mediumId)
            $('#mediumModal').modal('show');
        })
    </script>
@endsection
