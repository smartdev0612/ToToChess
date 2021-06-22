$(document).ready(function(){ 
    $('.num_only').css('imeMode','disabled').keypress(function(event) {
        if(event.which && (event.which < 48 || event.which > 57) ) {
            event.preventDefault();
        }
    }).keyup(function(){
        if( $(this).val() != null && $(this).val() != '' ) {
            $(this).val( $(this).val().replace(/[^0-9]/g, '') );
        }
    });

    $('.text-input').css('imeMode','disabled').keypress(function(event) {
        if(event.which && (event.which < 48 || event.which > 57) ) {
            event.preventDefault();
        }
    }).keyup(function(){
        if( $(this).val() != null && $(this).val() != '' ) {
            //var tmps = $(this).val().replace(/[^0-9]/g, '');
            var tmps = $(this).val().replace(/[^0-9]/g, '');
            var tmps2 = tmps.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            $(this).val(tmps2);
    }
    });
});