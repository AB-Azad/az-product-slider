(function($) {
	"use strict";
	
	$(".azp-slick-active").slick({
	  dots: true,
	  infinite: false,
	  slidesToShow: 3,
	  slidesToScroll: 1,
      arrows: true,
      // prevArrow: '<i class="htmegavc-testimonial-arrow-prev">'+ prev_content +'</i >',
      // nextArrow: '<i class="htmegavc-testimonial-arrow-next">'+ next_content +'</i >',
      prevArrow: $('.fa-angle-left'),
      nextArrow: $('.fa-angle-right')
	});
})(jQuery);