<?php


namespace SocialV\Utility;

global $product;
global $post;
$socialv_options = get_option('socialv-options');
$product = wc_get_product($post->ID);
if (!$product) {
	return '';
}
$is_quickview = (class_exists('WPCleverWoosq') && class_exists('ReduxFramework') && $socialv_options['socialv_display_product_quickview_icon'] == "yes") ? true : false;
$is_wishlist = (class_exists('YITH_WCWL') && class_exists('ReduxFramework') &&  $socialv_options['socialv_display_product_wishlist_icon'] == "yes") ? true : false;
$is_addtocart = (class_exists('ReduxFramework') && $socialv_options['socialv_display_product_addtocart_icon'] == "yes") ? true : false;
$is_prod_name = (class_exists('ReduxFramework') &&  $socialv_options['socialv_display_product_name'] == "yes") ? true : false;
$is_prod_price = (class_exists('ReduxFramework') &&  $socialv_options['socialv_display_price'] == "yes") ? true : false;
$is_prod_rating = (class_exists('ReduxFramework') &&  $socialv_options['socialv_display_product_rating'] == "yes") ? true : false;
?>
<div <?php wc_product_class('socialv-sub-product', get_the_ID()); ?>>
	<div class="socialv-inner-box ">
		<a href="<?php the_permalink(); ?>"></a>
		<div class="row m-0">
			<div class="col-md-4 p-0">
				<div class="socialv-product-block">
					<?php
					$newness_days = 30;
					$created = strtotime($product->get_date_created());
					if (!$product->is_in_stock()) { ?>
						<span class="onsale socialv-sold-out"><?php esc_html_e('Sold!', 'socialv') ?></span>
					<?php } else if ($product->is_on_sale()) { ?>
						<span class="onsale socialv-on-sale"><?php esc_html_e('Sale!', 'socialv') ?></span>
					<?php } else if ((time() - (60 * 60 * 24 * $newness_days)) < $created) { ?>
						<span class="onsale socialv-new"><?php esc_html_e('New!', 'socialv'); ?></span>
					<?php } ?>
					<div class="socialv-image-wrapper">
						<?php
						// Image Start
						if ($product->get_image_id()) {
							$product->get_image('shop_catalog');
							$image = wp_get_attachment_image_src($product->get_image_id(), 'medium');
						?>
							<a href="<?php echo get_the_permalink($product->get_id()); ?>" class="socialv-product-title-link ">
								<?php echo '<div class="socialv-product-image">' . woocommerce_get_product_thumbnail() . '</div>'; ?>
							</a><?php } else { ?>
							<a href="<?php echo get_the_permalink($product->get_id()); ?>" class="socialv-product-title-link ">
								<?php echo sprintf('<div class="socialv-product-image"><img src="%s" alt="%s" class="wp-post-image" loading="lazy"/></div>', esc_url(wc_placeholder_img_src()), esc_attr__('Awaiting product image', 'socialv')); ?>
							</a>
						<?php }
							// Image End

							//  Button Start
							if ($is_quickview == true || $is_wishlist == true) : ?>
							<div class="socialv-woo-buttons-holder">
								<ul>
									<?php
									if ($is_quickview == true) :  ?>
										<?php if (class_exists('WPCleverWoosq')) { ?>
											<li><?php echo do_shortcode('[woosq id="' . $product->get_id() . '"]') ?></li>
										<?php
										}
									endif;
									if ($is_wishlist == true) :
										?>
										<li>
											<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
										</li>
									<?php
									endif; ?>
								</ul>
							</div>
						<?php
							endif;
						?>
						<!-- Button End -->
					</div>
				</div>
			</div>
			<div class="col-md-8 p-0 socialv-woo-list-content">
				<div class="product-caption">
					<?php if ($is_prod_name == true) : ?>
						<h4 class="woocommerce-loop-product__title th13">
							<a href="<?php the_permalink(); ?>" class="socialv-product-title-link ">
								<?php echo esc_html($product->get_name()); ?>
							</a>
						</h4>
					<?php endif;
					if ($is_prod_price == true) : ?>
						<div class="price-detail">
							<span class="price">
								<?php echo wp_kses($product->get_price_html(), 'socialv'); ?>
							</span>
						</div>
					<?php endif;
					if ($is_prod_rating == true) : ?>
						<div class="container-rating">
							<?php
							$rating_count = $product->get_rating_count();
							if ($rating_count >= 0) {
								$average      = $product->get_average_rating();
							?>
								<div class="star-rating">
									<?php echo wc_get_rating_html($average, $rating_count); ?>
								</div>
							<?php } ?>
						</div>
					<?php
					endif;

					// Button  Start 
					if ($is_addtocart = true) : ?>
						<div class="socialv-btn-cart">
							<?php
							if ($product->get_id()) {
								if ($product->is_type('variable')) { ?>
									<a href="<?php echo esc_url($product->get_permalink()); ?>" class="socialv-button socialv-add-to-cart " data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
										<?php esc_html_e('Select Options', 'socialv'); ?>
									</a>
								<?php } elseif ($product->is_type('grouped')) { ?>
									<a href="<?php echo esc_url($product->get_permalink()); ?>" class="socialv-button socialv-add-to-cart " data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
										<?php esc_html_e('View products', 'socialv'); ?>
									</a>
								<?php } elseif ($product->is_type('external')) { ?>
									<a rel="nofollow" href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="socialv-button socialv-add-to-cart " data-quantity="<?php echo esc_attr(isset($quantity) ? $quantity : 1); ?>'" data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" target="_blank">
										<?php esc_html_e('Our Product', 'socialv'); ?>
									</a>
								<?php } else {	?>
									<a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="ajax_add_to_cart add_to_cart_button socialv-button socialv-add-to-cart " data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
										<?php esc_html_e('Add to Cart', 'socialv'); ?>
									</a>
								<?php }
							} else { ?>
								<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="added_to_cart socialv-button wc-forward socialv-button socialv-add-to-cart " title="View cart">
									<?php esc_html_e('View cart', 'socialv'); ?>
									<i class="iconly-Arrow-Right-2 icli ms-2"></i>
								</a>
							<?php
							}
							?>
						</div>
					<?php
					endif;
					// Button End 

					if (!empty(get_the_excerpt())) { ?>
						<div class="socialv-product-description">
							<?php
							the_excerpt();
							?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>