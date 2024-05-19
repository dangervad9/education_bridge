<?php

/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

use function SocialV\Utility\socialv;

defined('ABSPATH') || exit;

if (!function_exists('wc_get_gallery_image_html')) {
	return;
}

global $product;
$columns           = apply_filters('woocommerce_product_thumbnails_columns', 4);
$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();

$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
		'woocommerce-product-gallery--columns-' . absint($columns),
		'images',
	)
);
?>

<div class="<?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>" data-columns="<?php echo esc_attr($columns); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
	<figure class="woocommerce-product-gallery__wrapper">
		<?php if ($attachment_ids && sizeof($attachment_ids) > 1) {
			socialv()->get_single_product_dependent_script(); ?>
			<div class="swiper product-single-slider image-slider products socialv-main-product">
				<div class="swiper-wrapper socialv-team socialv-team-slider">
					<?php }
				if ($attachment_ids) {
					if ($attachment_ids && $product->get_image_id()) {
						foreach ($attachment_ids as $attachment_id) {

							$html = wc_get_gallery_image_html($attachment_id, true); ?>
							<div class="swiper-slide">
								<?php echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $attachment_id); ?>
							</div>
						<?php
						}
					}
				} else if ($post_thumbnail_id) {
					$html = wc_get_gallery_image_html($post_thumbnail_id, true);
					echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id);
				} else {
					$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
					$html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" loading="lazy" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'socialv'));
					$html .= '</div>';
					echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id);
				}

				if ($attachment_ids) {
					if (sizeof($attachment_ids) > 1) { ?>
				</div>
				<!-- Add Arrows -->
				<?php socialv()->socialv_slider_navigation(); ?>
			</div>
	<?php
					}
				}

				do_action('woocommerce_product_thumbnails');
	?>
	</figure>
</div>