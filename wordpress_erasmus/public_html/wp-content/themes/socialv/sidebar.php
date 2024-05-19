<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package socialv
 */

namespace SocialV\Utility;

if (!socialv()->is_primary_sidebar_active()) {
	return;
}
$is_sidebar = (class_exists('WooCommerce') && (bool)is_active_sidebar('product_sidebar') && (is_shop() || is_tax())) ? true : false; ?>
<?php if ($is_sidebar == true) { ?>
	<div class="col-xl-3 socialv-woo-sidebar col-sm-12 mt-5 mt-xl-0 sidebar-service-right">
		<div class="socialv-filter-close">
			<?php esc_html_e('Close', 'socialv'); ?>
			<i class="icon-close-2"></i>
		</div>
		<?php isSidebar_content(); ?>
	</div>
<?php } else { ?>
	<div class="<?php echo esc_attr((class_exists('LearnPress') && ((bool)is_active_sidebar('archive-courses-sidebar') && is_post_type_archive('lp_course')) || is_tax('course_category')) ? 'col-xl-3' : 'col-xl-4') ?> col-sm-12 mt-5 mt-xl-0 sidebar-service-right">
		<?php isSidebar_content(); ?>
	</div>
<?php }

function isSidebar_content()
{ ?>
	<aside id="secondary" class="primary-sidebar widget-area">
		<h2 class="screen-reader-text"><?php esc_html_e('Asides', 'socialv'); ?></h2>
		<?php socialv()->display_primary_sidebar(); ?>
	</aside><!-- #secondary -->
<?php }
