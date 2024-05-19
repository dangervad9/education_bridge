<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version      4.1.1
 */

namespace SocialV\Utility;

if (!defined('ABSPATH')) {
	exit;
}
if ($related_products) :
	$socialv_options = get_option('socialv-options');
	if (isset($socialv_options['socialv_show_related_product']) && $socialv_options['socialv_show_related_product'] == 'no' && is_product()) {
		return false;
	}
?>

	<section class="related products container-fluid">
		<?php
		$heading = apply_filters('woocommerce_product_related_products_heading', isset($args['name']) ? $args['name'] : esc_html__('Related Products', 'socialv'));
		if ($heading) :
		?>
			<div class="text-center socialv-title-box">
				<h2 class="socialv-title socialv-heading-title">
					<?php echo esc_html($heading); ?>
				</h2>
			</div>
		<?php endif;
		$related_count = count($related_products);
		if (class_exists('ReduxFramework') && $related_count > 4) {
			socialv()->get_single_product_dependent_script();
		?>
			<div class="swiper product-single-slider related-slider socialv-main-product" <?php echo socialv()->socialv_related_product_attr(); ?>>
				<div class="swiper-wrapper socialv-related-product product-grid-style ">
				<?php } else { ?>
					<div class="columns-4 products product-grid-style socialv-main-product">
					<?php }
				foreach ($related_products as $related_product) :
					if (!$related_product) continue;
					$post_object = get_post($related_product->get_id());
					setup_postdata($GLOBALS['post'] = &$post_object);
					if (class_exists('ReduxFramework') && $related_count > 5) {
						echo '<div class=swiper-slide>';
						get_template_part('template-parts/wocommerce/entry');
						echo '</div>';
					} else {
						$args = array('is_related_product' => 'true');
						get_template_part('template-parts/wocommerce/entry', '', $args);
					}
				endforeach;
				if (class_exists('ReduxFramework') && $related_count > 4) { ?>
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
			<?php
					// -- Pagination end -->
				} else { ?>
			</div>
		<?php } ?>
	</section>
<?php
endif;

wp_reset_postdata();
