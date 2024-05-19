<?php
/**
 * Single Product Sale Flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
$newness_days = 30;
$created = strtotime($product->get_date_created());

if (!$product->is_in_stock()) { ?>
    <span class="onsale socialv-sold-out"><?php esc_html_e('Sold!', 'socialv') ?></span>
     <?php
} else if ($product->is_on_sale()) { ?>
    <span class="onsale socialv-on-sale"><?php esc_html_e('Sale!', 'socialv') ?></span>
     <?php
} else if ((time() - (60 * 60 * 24 * $newness_days)) < $created) { ?>
    <span class="onsale socialv-new"><?php esc_html_e('New!', 'socialv'); ?></span>
     <?php
} 

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
