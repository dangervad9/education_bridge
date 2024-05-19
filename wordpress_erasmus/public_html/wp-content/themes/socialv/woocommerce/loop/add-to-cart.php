<?php

/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

namespace SocialV\Utility;

if (!defined('ABSPATH')) {
	exit;
}

global $product;

echo apply_filters(
	'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.

	socialv()->socialv_get_comment_btn($tag = "a",  $label = esc_html__("View Product", "socialv"), $attr = array(
		'href' => esc_url($product->add_to_cart_url()),
		'data-quantity' => esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
		'class' => ' socialv-btn-link',
	)),
	$product,
	$args,
);
