<?php

/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

namespace SocialV\Utility;

if (!defined('ABSPATH')) {
	exit;
}
global $wp_query;

if (!is_singular()) {
	if ($wp_query->max_num_pages > 1) {
		socialv()->socialv_ajax_load_scripts();
		socialv()->socialv_ajax_product_load_scripts();
		echo '<div class="loader-container"><div class="load-more"><span class="socialv-loader"></span></div></div>';
	}
}
