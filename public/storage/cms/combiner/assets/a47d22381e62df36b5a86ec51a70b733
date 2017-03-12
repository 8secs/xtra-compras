$(document).ready( function($) {

    /*-----------------------/
     /* PRELOADER
     /*----------------------*/
    $(window).load(function(){
        $('.preloader').fadeOut('slow');
        Stripe.setPublishableKey('pk_test_z8YEe39Hldwsz5ANW3uHCD4R');
    });

    /*------------------------------/
     /* DISPLAY FIXED MENU ON SCROLL
     /*-----------------------------*/

    $(window).on( 'scroll', function() {
        if( $(document).scrollTop() > 600 ) {
            $('.header-home').addClass('active');
        } else {
            $('.header-home').removeClass('active');
        }
    });
    $('header nav').meanmenu();

    /*------------------------/
     /* SMOOTH SCROLLING
     /*-----------------------*/

    $('.scroll-section').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });

    /*------------------------------/
     /* HILIGHT MENU ITEMS ON SCROLL
     /*-----------------------------*/

    jQuery('body').scrollspy({
        target: '.header-home'
    });
});

