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
jQuery(document).ready(function($) {
    // Handle click event on the add to cart button
    $('.ajax_add_to_cart').on('click', function(e) {
        e.preventDefault();

        // Get the URL for adding the product to the cart
        var addToCartUrl = $(this).attr('href');

        // Perform an AJAX request
        $.ajax({
            type: 'POST',
            url: addToCartUrl,
            data: { quantity: 1 }, // You can adjust this value based on your requirements
            success: function(response) {
                // Simulate a click on .wc-block-mini-cart__quantity-badge
                $('.wc-block-mini-cart__quantity-badge').click();
            }
        });
    });

    // Prevent click on "View Cart" link after adding a product
    $(document).on('click', '.added_to_cart.wc-forward', function(e) {
        e.preventDefault();
    });
});
}( jQuery ) );
