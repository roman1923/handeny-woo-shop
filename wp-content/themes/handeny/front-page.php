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

$video_text = get_field('video_text');
$video_button = get_field('video_button');

$discont_text = get_field('discont_text');
$shop_button = get_field('shop_button');
$view_more = get_field('view_more');

$offer_text = get_field('offer_text');
$offer_link = get_field('offer_link');
$offer_category = get_field('offer_category');
$offer_category_2 = get_field('offer_category_2');

$blog_text = get_field('blog_heading');
$posts = get_field('posts');
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
<section class="video-section">
	<div class="container">
        <div class="row">
			<div class="col-md-6">
				<div class="video-block">
					<img src="<?php echo get_template_directory_uri() . '/assets/img/video-img.png'; ?>" alt="future-video"/>
				</div>
			</div>
			<div class="col-md-6">
				<div class="video-content">
					<div class="text">
						<?php echo wp_kses_post($video_text); ?>
					</div>
					<div class="link">
						<a href="<?php echo esc_url($video_button['url']); ?>" target="<?php echo esc_attr($video_button['target']); ?>">
							<?php echo esc_html($video_button['title']); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="discount-section">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="discount-text">
					<div class="text">
						<?php echo wp_kses_post($discont_text); ?>
					</div>
					<div class="benefits">
						<?php
							if( have_rows('benefits') ):
								while( have_rows('benefits') ) : the_row();
									$image = get_sub_field('image');
									$benefit = get_sub_field('benefit');
									?>
									<div class="benefit">
										<img src="<?php echo esc_url($image); ?>" alt="benefit-img"/>
										<p><?php echo esc_html($benefit); ?></p>
									</div>
									<?php
								endwhile;
							endif;
						?>
					</div>
					<div class="buttons">
						<?php if (isset($shop_button['url'])) : ?>
						<a href="<?php echo esc_url($shop_button['url']); ?>" target="<?php echo esc_attr($shop_button['target']); ?>" class="shop-btn">
							<?php echo esc_html($shop_button['title']); ?>
						</a>
						<?php endif; ?>
						<?php if (isset($view_more['url'])) : ?>
							<a href="<?php echo esc_url($view_more['url']); ?>" target="<?php echo esc_attr($view_more['target']); ?>" class="view-more">
								<?php echo esc_html($view_more['title']); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="discount-image">
					<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/discount.png'); ?>" alt="discount">
				</div>
			</div>
		</div>
	</div>
</section>
<div class="offer-section">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="offer-left">
					<div class="text">
						<?php echo wp_kses_post($offer_text); ?>
						<a href="<?php echo esc_url($offer_link['url']); ?>" target="<?php echo esc_attr($offer_link['target']); ?>" class="button">
							<?php echo esc_html($offer_link['title']); ?>
						</a>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="products-block">
					<div class="first-cat">
						<h3 class='product-name'><?php echo esc_html($offer_category); ?></h3>
						<?php
						$category = get_term_by('name', $offer_category, 'product_cat');

						if ($category) {
							$category_id = $category->term_id;

							$args = array(
								'post_type'      => 'product',
								'posts_per_page' => 3,
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
								while ($products->have_posts()) : $products->the_post();
								// Output product information
								echo '<div class="products">';
								
								// Display product image
								echo '<a href="' . esc_url(get_permalink($product->ID)) . '">';
								echo '<img src="' . esc_url(get_the_post_thumbnail_url($product->ID, 'thumbnail')) . '" alt="' . esc_attr(get_the_title($product->ID)) . '" />';
								echo '<div>';
								// Display product name
								echo '<h3>' . esc_html(get_the_title($product->ID)) . '</h3>';
								
								// Display product price
								echo '<span class="price">' . $product->get_price_html() . '</span>';
								echo '</div>';
								echo '</a>';	
								// Close the product link container
								echo '</div>';

							endwhile;
							echo '</div>';
							wp_reset_postdata();
						endif;
						}
						?>
						<div class="second-cat">
						<h3 class='product-name'><?php echo esc_html($offer_category_2); ?></h3>
						<?php
						$category = get_term_by('name', $offer_category_2, 'product_cat');

						if ($category) {
							$category_id = $category->term_id;

							$args = array(
								'post_type'      => 'product',
								'posts_per_page' => 3,
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
								while ($products->have_posts()) : $products->the_post();
								// Output product information
								echo '<div class="products">';
								
								// Display product image
								echo '<a href="' . esc_url(get_permalink($product->ID)) . '">';
								echo '<img src="' . esc_url(get_the_post_thumbnail_url($product->ID, 'thumbnail')) . '" alt="' . esc_attr(get_the_title($product->ID)) . '" />';
								echo '<div>';
								// Display product name
								echo '<h3>' . esc_html(get_the_title($product->ID)) . '</h3>';
								
								// Display product price
								echo '<span class="price">' . $product->get_price_html() . '</span>';
								echo '</div>';
								echo '</a>';	
								// Close the product link container
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
		</div>
	</div>
</div>
<section class="blog-section">
    <div class="container">
        <div class="row">
			<div class="blog-title">
				<?php
					if ($blog_text) {
						echo wp_kses_post($blog_text);
					}
				?>
			</div>
			<div class="blog-slider">
			<?php
			$postsArr = array_map('trim', explode(',', $posts));
			$args = array(
				'post_type'      => 'post',
				'post__in'       => $postsArr,
				'posts_per_page' => count($postsArr),
			);

			// Get the posts
			$specific_posts = new WP_Query($args);

			// Display the posts in a slick slider
			if ($specific_posts->have_posts()) :
				echo '<div class="slick-slider">';
				while ($specific_posts->have_posts()) : $specific_posts->the_post();

					// Output post information
					echo '<div class="post-slide">';
					
					// Display featured image
					echo '<a href="' . esc_url(get_permalink()) . '">';
					if (has_post_thumbnail()) {
						echo '<div class="post-thumbnail">';
						echo '<div class="post-date"><span>'
						 . get_the_date('j') . '</span><span>'
						 . get_the_date('M') . '</span></div>';
						the_post_thumbnail('thumbnail');
						echo '<div class="hover-overlay"></div>'; // Overlay for hover effect
            			echo '<div class="dots-container"><div class="dot dot-1"></div><div class="dot dot-2"></div><div class="dot dot-3"></div></div>';
						$categories = get_the_category();
						if ($categories) {
							echo '<span class="post-category">' . esc_html($categories[0]->name) . '</span>';
						}
						echo '</div>';
					}
					echo '</a>';
					echo '<h2 class="post-title">' . esc_html(get_the_title()) . '</h2>';
					// Display author's name and avatar
					echo '<div class="author-info">';
					echo '<p>Posted by</p>';
					echo '<div class="author-avatar">' . get_avatar(get_the_author_meta('ID'), 32) . '</div>';
					echo '<span class="author-name">' . esc_html(get_the_author()) . '</span>';
					echo '</div>';
					
					echo '<div class="post-content">';
					the_content();
					echo '</div>';

					echo '<a class="read-more-link" href="' . esc_url(get_permalink()) . '">Continue reading</a>';

					echo '</div>'; // Close post-slide

				endwhile;
				echo '</div>'; // Close slick-slider
				wp_reset_postdata();
			else :
				echo 'No posts found.';
			endif;
			?>
			</div>
		<div>
	</div>
</section>		
<?php get_footer(); ?>
