<?php

/**
 * Template part for displaying the header navigation menu
 *
 * @package socialv
 */

namespace SocialV\Utility;

$socialv_options = get_option('socialv-options');
?>

<nav class="navbar deafult-header socialv-menu-wrapper mobile-menu">
	<button class="navbar-toggler custom-toggler ham-toggle close-custom-toggler" type="button">
		<span class="menu-btn-close">
			<?php esc_html_e("Close", "socialv"); ?><i class="icon-close-2"></i>
		</span>
	</button>

	<div class="menu-all-pages-container">
		<?php
		socialv()->display_primary_nav_menu(array(
			'menu_class' => 'top-menu navbar-nav ml-auto list-inline',
			'item_spacing' => 'discard',
			'link_before'  => '<span class="menu-title">',
			'link_after'   => '</span>',
		));
		?>
	</div>
</nav><!-- #site-navigation -->