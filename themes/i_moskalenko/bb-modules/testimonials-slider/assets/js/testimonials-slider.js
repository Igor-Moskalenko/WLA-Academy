(function ($) {
     $(document).ready(function () {
         $('.testimonials-item').slick({
             arrows: false,
             dots: true,
             infinite: true,
			 fade: true,
             speed: 500,
             slidesToShow: 1,
             slidesToScroll: 1,
         });
     });
 })(jQuery);