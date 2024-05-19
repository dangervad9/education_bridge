<?php

/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.7.0
 */

if (!defined('ABSPATH')) {
	exit;
}
$socialv_options = get_option('socialv-options');
?>
<div class="sorting-wrapper">
	<p class="woocommerce-result-count" data-product-per-page="<?php echo isset($socialv_options['woocommerce_product_per_page']) ? esc_attr($socialv_options['woocommerce_product_per_page']) : 3  ?>">
		<?php
		if (1 === intval($total)) {
			esc_html_e('Showing the single result', 'socialv');
		} elseif ($total <= $per_page || -1 === $per_page) {
			printf(_n('Showing all %d result', 'Showing all %d results', $total, 'socialv'), $total);
		} else {
			$first = ($per_page * $current) - $per_page + 1;
			$last  = min($total, $per_page * $current);
			printf(_nx('Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'socialv'), $first, $last, $total);
		}
		?>
	</p>