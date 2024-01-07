<?php
get_header(); 

$main_block_text = get_field('main-block--text');
$main_shop = get_field('main_shop');
$main_view = get_field('main_view');

$girl_block_text = get_field('girl-block--text');
$girl_shop = get_field('girl_shop');
$girl_view = get_field('girl_view');

$products_block_text = get_field('products_title');
$first_product_category = get_field('first_product_category');
$product_count = get_field('product_count');
$second_product_category = get_field('second_product_category');
$product_count_2 = get_field('product_count_2');
?>

<section class="front-main">
    <div class="container">
        <div class="main-block--text">
            <?php
            if ($main_block_text) {
                echo wp_kses_post($main_block_text);
            }
            ?>
        </div>

        <?php
        if (is_array($main_shop)) :
        ?>
            <div class="main-buttons">
                <?php if (isset($main_shop['url'])) : ?>
                    <a href="<?php echo esc_url($main_shop['url']); ?>" target="<?php echo esc_attr($main_shop['target']); ?>" class="shop-btn">
                        <?php echo esc_html($main_shop['title']); ?>
                    </a>
                <?php endif; ?>

                <?php if (is_array($main_view) && isset($main_view['url'])) : ?>
                    <a href="<?php echo esc_url($main_view['url']); ?>" target="<?php echo esc_attr($main_view['target']); ?>" class="view-btn">
                        <?php echo esc_html($main_view['title']); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php
        endif;
        ?>
    </div>
</section>

<section class="girl-section">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="girl-image--block">
                    <?php
                    $girl_image_url = get_template_directory_uri() . '/assets/img/girl.png';
                    if ($girl_image_url) {
                        echo '<img src="' . wp_kses($girl_image_url, 'url') . '" alt="girl" />';
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-5">
                <div class="girl-block--text">
                    <?php
                    if ($girl_block_text) {
                        echo wp_kses_post($girl_block_text);
                    }
                    ?>

                    <?php
                    if (is_array($girl_shop)) :
                    ?>
                        <div class="girl-buttons">
                            <a href="<?php echo esc_url($girl_shop['url']); ?>" target="<?php echo esc_attr($girl_shop['target']); ?>" class="shop-btn">
                                <?php echo esc_html($girl_shop['title']); ?>
                            </a>

                            <?php if (is_array($girl_view) && isset($girl_view['url'])) : ?>
                                <a href="<?php echo esc_url($girl_view['url']); ?>" target="<?php echo esc_attr($girl_view['target']); ?>" class="view-btn">
                                    <?php echo esc_html($girl_view['title']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="feature-products">
    <div class="container">
        <div class="row">
			<div class="products-title">
				<?php
					if ($products_block_text) {
						echo wp_kses_post($products_block_text);
					}
				?>
			</div>
			<div class="col-md-5 col-lg-4 col-xl-3">
                <div class="product-image--block">
				<?php
				$category = get_term_by('name', $first_product_category, 'product_cat');

				if ($category) {
					$category_id = $category->term_id;
					$category_image = get_term_meta($category_id, 'thumbnail_id', true);
					$image_url = wp_get_attachment_url($category_image);
					$category_link = get_term_link($category_id, 'product_cat');

					if ($image_url) {
						echo '<div class="category-wrapper">';
						echo '<a href="' . esc_url($category_link) . '">';
						echo '<img class="product-category" src="' . esc_url($image_url) . '" alt="' . esc_attr($category->name) . '" />';
						echo '<h3>' . esc_html($category->name) . '</h3>';
						echo '<p>' . esc_html($category->description) . '</p>';
						echo '<p>SHOP NOW</p>';
						echo '</a>';
						echo '</div>';
					}
				}
				?>
                </div>
			</div>
            <div class="col-md-7 col-lg-8 col-xl-9">
                <div class="product-block--slider">
				<?php
				$category = get_term_by('name', $first_product_category, 'product_cat');

				if ($category) {
					$category_id = $category->term_id;

					$args = array(
						'post_type'      => 'product',
						'posts_per_page' => $product_count,
						'tax_query'      => array(
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'term_id',
								'terms'    => $category_id,
							),
						),
						'orderby'        => 'date', 
        				'order'          => 'DESC',
					);

					$products = new WP_Query($args);

					if ($products->have_posts()) :
						echo '<div class="slick-slider">';
						while ($products->have_posts()) : $products->the_post();
							echo '<div class="category-wrapper">';
							// Display product image
							echo '<img src="' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')) . '" alt="' . esc_attr(get_the_title()) . '" />';

							echo '<div class="link-block">';
							echo '<div class="links">';
										// Display "Add to Cart" button
										echo apply_filters('woocommerce_loop_add_to_cart_link',
										sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s"></a>',
											esc_url($product->add_to_cart_url()),
											esc_attr($product->get_id()),
											esc_attr($product->get_sku()),
											$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
											esc_attr($product->product_type),
										),
										$product
									);
							echo '<a href="' . esc_url(get_permalink()) . '">';
							echo '</a>';
							echo '</div>';
							echo '</div>';

							// Display product title
							echo '<h2>' . esc_html(get_the_title()) . '</h2>';

							// Display product description
							echo '<p>' . esc_html(get_the_excerpt()) . '</p>';

							// Display product price
							echo '<span class="price">' . $product->get_price_html() . '</span>';

							echo '</div>';
						endwhile;
						echo '</div>';
						wp_reset_postdata();
					endif;
				}
				?>
          </div>
            </div>
			<div class="col-md-5 col-lg-4 col-xl-3">
                <div class="product-image--block">
				<?php
				$category = get_term_by('name', $second_product_category, 'product_cat');

				if ($category) {
					$category_id = $category->term_id;
					$category_image = get_term_meta($category_id, 'thumbnail_id', true);
					$image_url = wp_get_attachment_url($category_image);
					$category_link = get_term_link($category_id, 'product_cat');

					if ($image_url) {
						echo '<div class="category-wrapper">';
						echo '<a href="' . esc_url($category_link) . '">';
						echo '<img class="product-category" src="' . esc_url($image_url) . '" alt="' . esc_attr($category->name) . '" />';
						echo '<h3 class="title2">' . esc_html($category->name) . '</h3>';
						echo '<p class="desc2">' . esc_html($category->description) . '</p>';
						echo '<p class="shop2">SHOP NOW</p>';
						echo '</a>';
						echo '</div>';
					}
				}
				?>
                </div>
			</div>
            <div class="col-md-7 col-lg-8 col-xl-9">
                <div class="product-block--slider">
				<?php
				$category = get_term_by('name', $second_product_category, 'product_cat');

				if ($category) {
					$category_id = $category->term_id;

					$args = array(
						'post_type'      => 'product',
						'posts_per_page' => $product_count_2,
						'tax_query'      => array(
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'term_id',
								'terms'    => $category_id,
							),
						),
						'orderby'        => 'date', 
        				'order'          => 'DESC',
					);

					$products = new WP_Query($args);

					if ($products->have_posts()) :
						echo '<div class="slick-slider">';
						while ($products->have_posts()) : $products->the_post();
							echo '<div class="category-wrapper">';
							// Display product image
							echo '<img src="' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')) . '" alt="' . esc_attr(get_the_title()) . '" />';

							echo '<div class="link-block">';
							echo '<div class="links">';
										// Display "Add to Cart" button
										echo apply_filters('woocommerce_loop_add_to_cart_link',
										sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s"></a>',
											esc_url($product->add_to_cart_url()),
											esc_attr($product->get_id()),
											esc_attr($product->get_sku()),
											$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
											esc_attr($product->product_type),
										),
										$product
									);
							echo '<a href="' . esc_url(get_permalink()) . '">';
							echo '</a>';
							echo '</div>';
							echo '</div>';

							// Display product title
							echo '<h2>' . esc_html(get_the_title()) . '</h2>';

							// Display product description
							echo '<p>' . esc_html(get_the_excerpt()) . '</p>';

							// Display product price
							echo '<span class="price">' . $product->get_price_html() . '</span>';

							echo '</div>';
						endwhile;
						echo '</div>';
						wp_reset_postdata();
					endif;
				}
				?>
          	</div>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>
