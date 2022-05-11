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
        //load more posts via ajax in Posts module
        var loading = false;
        $(document).on('click','.btn.load-more',function() {
            let $this = $(this);
            if(!loading) {
              loading = true;
              let default_text = $this.attr('data-default-text');
              let containerID = $this.attr('data-container-ID');
              let dataArray = $this.data();
              let page = $('#posts-'+containerID).attr('data-page');
              $this.text('Loading');
              $.ajax({
                  url: theme_js.ajax_url,
                  type: 'post',
                  data: {
                    action: 'load_zone_posts',
                    data: dataArray,
                    page : page
                  },
                  success: function( data ) {
                    let response = JSON.parse(data);
                    if(response.status == 'success') {
                      $('#posts-'+containerID).append(response.data);
                      setTimeout(function() {
                          $('.has-aos').each(function(){
                              $(this).addClass('aos-animate');
                          });
                      }, 100);
                      loading = false;
                      $this.text(default_text);
                      $('#posts-'+containerID).attr('data-page',response.page);
                      //history.pushState(null, "", url+'?pg='+response.page);
                      window.history.replaceState(null, null, '?pg='+response.page);
                      popPosts();
                      if(response.loadmore == 0) {
                          $this.hide();
                      }
                    }
                  }
              });
            }
        });

        //function to load posts after 'load more' button has been pressed
        var popped = false;
        function popPosts() {
          if($('.posts.show-pagination').length) {
            if(!popped) {
              let queryString = window.location.search;
              let urlParams = new URLSearchParams(queryString);
              if(urlParams.has('pg')) {
                let page = parseInt(urlParams.get('pg'));
                $('.post.show-pagination').attr('data-page',page);
                setInterval(function() {
                  if ( !loading && page > 1) {
                      page = page - 1;
                      $('.btn.load-more').trigger('click');
                  }
                }, 100);
              }
              popped = true;
            }
          }
        }
        //trigger post loading on page load
        popPosts();
        //trigger post loading on page pop
        $(window).on("popstate", function() {
          popPosts();
        });

        //play videos on hover
        var nowPlaying = 'none';
        $('.responsive-video').hover(function(){
            nowPlaying = $(this).find('iframe').attr('src');
            let autoplay = '?autoplay=1&mute=1';
            if (nowPlaying.indexOf('?') >= 0) {
              autoplay = '&autoplay=1&mute=1';
            } 
            $(this).find('iframe').attr('src',nowPlaying+autoplay);
        }, function(){
            $(this).find('iframe').attr('src',nowPlaying);
        });
    });
})(jQuery); // Fully reference jQuery after this point.