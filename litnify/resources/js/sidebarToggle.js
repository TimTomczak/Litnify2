$('#sidebar-toggle').click(function (){
    if ($('#wrapper').hasClass('toggled')){
        $('#wrapper').removeClass('toggled');
    }
    else{
        $('#wrapper').addClass('toggled');
    }
    // $('#wrapper').toggleClass('toggled');
});
