 // start preloader
 $(document).ready(function($) {
    var Body = $('body');
    Body.addClass('preloader-main');
});

$(window).on('load',function(){
   $('.preloader-wrapper').fadeOut();
    $('body').removeClass('preloader-main');
}) 
// end preloader