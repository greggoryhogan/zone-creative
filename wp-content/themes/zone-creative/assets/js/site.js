(function($) {
	$(document).ready(function() {
        //AOS init
        AOS.init({
            offset: 220,
            duration: 400,
            once: true,
        });

        //mobile nav toggle
        $('.nav-toggle').click(function() {
            $(this).toggleClass('is-active');
            $('#site-navigation,.header').toggleClass('is-active');
        });
        //zone logo animation
        var lastScrollTop = 0; //for checking if up or down scroll
        function scrollLogo(st) {
            if (st > lastScrollTop && st > 60){ //change to st >= last in order to make zone text hidden on page load when reloaded
                //slide is out
                $('.zone-img').addClass('is-hidden');
                //old functionality to slide based on percentage
                /*if(st < 400) {
                    $('.zone-img').css('marginLeft',st * -1);
                } else {
                    $('.zone-img').css('marginLeft','-400px');
                }*/
            } else {
                //slide img back in
                // $('.zone-img').css('marginLeft',0); //Old way to use percentage to slide back in
                $('.zone-img').removeClass('is-hidden');
            }
            lastScrollTop = st;
        }
        //only animate if theme is set to do so
        if($('.site-branding').hasClass('animate-logo')) {
            //trigger on page load in case it is a reload of page and we're halfway down the page
            scrollLogo($(window).scrollTop());
            //scroll event
            $(window).scroll(function (event) {
                var st = $(this).scrollTop();
                scrollLogo(st);
            });      
        }  

        //Works Content-w-image hover effect
        $('.content-w-image .feature-heading a').hover(
            function() {
                $( this ).parent().parent().parent().find('.feature-image').addClass('is-hovered');
            }, function() {
                $( this ).parent().parent().parent().find('.feature-image').removeClass('is-hovered');
            }
        );
    });
})(jQuery); // Fully reference jQuery after this point.