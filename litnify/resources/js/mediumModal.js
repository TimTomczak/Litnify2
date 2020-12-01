$( document ).ready(function() {
    $(".render-medium-modal").click(function( event) {
        var $mediumId = $(this).data('id');
        $('#modalContent').empty();
        var spinnerDiv = "<div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>"
        $('#modalContent').append(spinnerDiv);
        $('#modalContent').load('/medium/'+$mediumId+' #medium');
        $('#showMediumBtn').attr('href','/medium/'+$mediumId)
        $('#mediumModal').modal('show');
    })
});
