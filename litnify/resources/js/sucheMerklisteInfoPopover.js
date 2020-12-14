$('#addToMerklisteInfoButton').click(function (event){
    $(this).popover({
        html: true,
        trigger: 'focus',
        placement: 'bottom',
        title: 'Zur Merkliste hinzufügen',
        content: '<p class="mb-1">Medien können zur Merkliste hinzugefügt werden.</p>' +
            '<p class="mb-1"><span class="btn btn-primary btn-sm"><i class="fa fa-star-o"></i></span>&ensp;Medium nicht ausleihbar</p>' +
            '<p><span class="btn btn-success btn-sm"><i class="fa fa-star"></i></span>&ensp;Medium ausleihbar</p>'
    })
    $(this).popover('show')
});
