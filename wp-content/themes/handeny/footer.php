<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package handeny
 */

?>

<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
				<img src="<?php the_field('footer_logo', 'option'); ?>" alt="footer-logo">
				<div class="desc">
					<?php the_field('description', 'option'); ?>
				</div>
				<div class="location">
					<img src="<?php the_field('location_logo', 'option'); ?>" alt="location-logo">
					<?php the_field('location_text', 'option'); ?>
				</div>
				<div class="phone">
					<img src="<?php the_field('phone_logo', 'option'); ?>" alt="phone-logo">
					<?php the_field('phone_text', 'option'); ?>
				</div>
				<div class="mail">
					<img src="<?php the_field('mail_logo', 'option'); ?>" alt="mail-logo">
					<?php the_field('mail_text', 'option'); ?>
				</div>

            </div>
            <div class="col-md-3">
				<div class="posts">
					<div class="posts-title mt-2">
						<?php the_field('posts', 'option'); ?>
					</div>
					<?php
						$args = array(
							'post_type'      => 'post',
							'posts_per_page' => 2, // Change this to 2 to get the last two products
							'orderby'        => 'date',
							'order'          => 'DESC',
						);

						$products = new WP_Query($args);

						if ($products->have_posts()) :
							// Open the products container before the loop
							echo '<div class="products">';

							while ($products->have_posts()) : $products->the_post();
								// Output product information
								echo '<div class="product">';

								// Display product image
								echo '<a href="' . esc_url(get_permalink()) . '">';
								echo '<img src="' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')) . '" alt="' . esc_attr(get_the_title()) . '" />';
								echo '<div>';
								// Display product name
								echo '<h3>' . esc_html(get_the_title()) . '</h3>';

								// Display product price
								echo '<span class="price date">' . get_the_date() . '</span>';
								echo '</div>';
								echo '</a>';
								// Close the product link container
								echo '</div>';

							endwhile;
							// Close the products container after the loop
							echo '</div>';
							wp_reset_postdata();
						endif;
						?>
				</div>
            </div>
            <div class="col-md-3">
					<div class="stores-title mt-2">
						<?php the_field('stores', 'option'); ?>
					</div>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer_menu_1',
						'menu_class'     => 'menu-class',
						// Add other parameters as needed
					) );
					?>
            </div>
            <div class="col-md-3">
					<div class="links-title mt-2">
						<?php the_field('links', 'option'); ?>
					</div>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer_menu_2',
						'menu_class'     => 'menu-class',
						// Add other parameters as needed
					) );
					?>
            </div>
        </div>
    </div>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
