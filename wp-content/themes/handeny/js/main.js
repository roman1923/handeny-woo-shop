( function( $ ) {
	jQuery(document).ready(function($) {
    $('.slick-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        responsive: [
            {
                breakpoint: 1180,
                settings: {
                    slidesToShow: 2,
                },
            },
        ],
        prevArrow: '<a type="button" class="slick-prev"></a>',
        nextArrow: '<a type="button" class="slick-next"></a>'
    });
});
}( jQuery ) );
