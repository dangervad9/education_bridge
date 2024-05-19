<?php

use function SocialV\Utility\socialv;

/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */


if (!defined('ABSPATH')) {
	exit;
}
$is_sidebar = socialv()->is_primary_sidebar_active();
$socialv_options = get_option('socialv-options');
$is_view_listing = $_COOKIE['product_view']['is_grid'] == '1' ? 'active' : '';
$is_view_grid = array(
	'3' => '',
	'4' => '',
);
if ($_COOKIE['product_view']['is_grid'] == '2') {
	$is_view_grid[$_COOKIE['product_view']['col_no'] + 1] = 'active';
}

?>
<div class="socialv-product-view-wrapper">

	<?php
	if (is_shop() && $is_sidebar) { ?>
		<div class="socialv-filter-button shop-filter-sidebar">
			<i class="iconly-Filter-2 icli"></i>
			<span class="socialv-btn-text"><?php esc_html_e("Filter", "socialv"); ?></span>
		</div>
	<?php
	}
	if (is_shop() ||is_product_category() || is_archive()) { ?>
	<input id="skeleton_template_url" type="hidden" value="<?php echo esc_url(get_template_directory_uri()); ?>" name="skeleton_template_url">
		<div class="socialv-product-view-buttons">
			<ul>
				<li>
					<a class="btn socialv-listing <?php echo esc_attr($is_view_listing) ?> ">
						<i class="icon-list-icon"></i>
					</a>
				</li>
				<li>
					<a class="btn socialv-view-grid <?php echo esc_attr($is_view_grid['3']) ?>" data-grid="2">
						<i class="icon-grid-2"></i>
					</a>
				</li>
				<li>
					<a class="btn socialv-view-grid <?php echo esc_attr($is_view_grid['4']) ?>" data-grid="3">
						<i class="icon-grid-3"></i>
					</a>
				</li>
			</ul>
		</div>
	<?php
	}
	?>

	<form class="woocommerce-ordering" method="get">
		<select name="orderby" class="orderby" aria-label="<?php esc_attr_e('Shop order', 'socialv'); ?>">
			<?php foreach ($catalog_orderby_options as $id => $name) : ?>
				<option value="<?php echo esc_attr($id); ?>" <?php selected($orderby, $id); ?>><?php echo esc_html($name); ?></option>
			<?php endforeach; ?>
		</select>
		<input type="hidden" name="paged" value="1" />
		<?php wc_query_string_form_fields(null, array('orderby', 'submit', 'paged', 'product-page')); ?>
	</form>
</div>
</div>