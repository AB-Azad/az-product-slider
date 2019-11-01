(function($) {
	"use strict";
	$('.azpswc-slick-active').each(function () {
        var settings = $(this).data('slick-settings');
        var autoplay = !(settings.autoplay == 'false');
            var autoplaySpeed = parseInt(settings.autoplay_speed);
            var pauseOnFocus = !(settings.pause_on_focus == 'false');
            var pauseOnHover = !(settings.pause_on_hover == 'false');
            var pauseOnDotsHover = !(settings.pause_on_dots_hover == 'false');
        var arrows = !(settings.arrows == 'false');
            var prevArrowClass = settings.prev_arrow_class;
            var nextArrowClass = settings.next_arrow_class;
        var dots = !(settings.dots == 'false');
        var draggable = !(settings.draggable == 'false');
        var infinite = (settings.infinite == 'true');
        var initialSlide = parseInt(settings.initial_slide);
        var rows = parseInt(settings.rows);
        var slidesToShow = parseInt(settings.slides_to_show);
        var slidesToScroll = parseInt(settings.slides_to_scroll);
        var speed = parseInt(settings.speed);
        var swipe = !(settings.swipe == 'false');
        var slides_to_show_xs_mobile = parseInt(settings.slides_to_show_xs_mobile);
        var slides_to_show_mobile = parseInt(settings.slides_to_show_mobile);
        var slides_to_show_tablet = parseInt(settings.slides_to_show_tablet);
        var slides_to_show_md_desktop = parseInt(settings.slides_to_show_md_desktop);
        var xs_mobile_breakpoint = parseInt(settings.xs_mobile_breakpoint);
        var mobile_breakpoint = parseInt(settings.mobile_breakpoint);
        var tablet_breakpoint = parseInt(settings.tablet_breakpoint);
        var md_desktop_breakpoint = parseInt(settings.md_desktop_breakpoint);

        $(this).slick({
          autoplay: autoplay,
            autoplaySpeed: autoplaySpeed,
            pauseOnFocus: pauseOnFocus,
            pauseOnHover: pauseOnHover,
            pauseOnDotsHover: pauseOnDotsHover,
          arrows: arrows,
              prevArrow:  '<div class="azpswc-slick-prev azpswc-slick-arrow"><i class="'+ prevArrowClass +'"></i></div>',
              nextArrow: '<div class="azpswc-slick-next azpswc-slick-arrow"><i class="'+ nextArrowClass +'"></i></div>',
          dots: dots,
          draggable: draggable,
          infinite: infinite,
          initialSlide: initialSlide,
          rows: rows,
          slidesToShow: slidesToShow,
          slidesToScroll: slidesToScroll,
          speed: speed,
          swipe: swipe,
          responsive: [
            {
                /* Large devices (medium desktops, 992px and up) */
                breakpoint: md_desktop_breakpoint,
                settings: {
                    slidesToShow: slides_to_show_md_desktop
                }
            },
            {
                /*Medium devices (tablets, 768px and up)*/
                breakpoint: tablet_breakpoint,
                settings: {
                    slidesToShow: slides_to_show_tablet
                }
            },
            {
                /*Small devices*/
                breakpoint: mobile_breakpoint,
                settings: {
                    slidesToShow: slides_to_show_mobile
                }
            },
            {
                /*Extra small devices*/
                breakpoint: xs_mobile_breakpoint,
                settings: {
                    slidesToShow: slides_to_show_xs_mobile
                }
            }
          ]
        });
    });
})(jQuery);