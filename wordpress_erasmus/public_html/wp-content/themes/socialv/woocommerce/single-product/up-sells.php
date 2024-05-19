<?php

/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

use function SocialV\Utility\socialv;

if (!defined('ABSPATH')) {
	exit;
}

if ($upsells) : ?>
	<section class="up-sells upsells products">
		<?php
		$heading = apply_filters('woocommerce_product_upsells_products_heading', esc_html__('You may also like', 'socialv'));
		if ($heading) :
		?>
			<div class="text-center socialv-title-box">
				<h2 class="socialv-title socialv-heading-title">
					<?php echo esc_html($heading); ?>
				</h2>
			</div>
		<?php endif;
		$upsells_count = count($upsells);
		if (class_exists('ReduxFramework') && $upsells_count > 4) {
			socialv()->get_single_product_dependent_script();
		?>
			<div class="swiper product-single-slider upsells-slider socialv-main-product" <?php echo socialv()->socialv_related_product_attr(); ?>>
				<div class="swiper-wrapper socialv-upsells-product product-grid-style ">
				<?php } else { ?>
					<div class="columns-4 products socialv-main-product product-grid-style">
						<?php }
					foreach ($upsells as $upsell) :
						$post_object = get_post($upsell->get_id());
						setup_postdata($GLOBALS['post'] = &$post_object);
						if (class_exists('ReduxFramework') && $upsells_count > 4) { ?>
							<div class="swiper-slide">
								<?php wc_get_template_part('content', 'product'); ?>
							</div>
						<?php
						} else {
							wc_get_template_part('content', 'product');
						}
					endforeach;
					if (class_exists('ReduxFramework') && $upsells_count > 4) { ?>
					</div>
					<!-- Navigation start -->
					<?php if ($socialv_options['related_nav'] == "true") {
							socialv()->socialv_slider_navigation();
						}
						// -- Navigation end -->
						// -- Pagination start -->
						if ($socialv_options['related_dots'] == "true") { ?>
						<div class="swiper-pagination css-prefix-pagination-align"></div>
					<?php } ?>
				</div>
			<?php } else { ?>
			</div>
		<?php } ?>
	</section>

<?php
endif;

wp_reset_postdata();
