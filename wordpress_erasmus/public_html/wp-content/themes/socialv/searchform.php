<?php

/**
 * The template for displaying all pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package socialv
 */

namespace SocialV\Utility;

$unique_id = esc_html(uniqid('search-form-')); ?>
<form method="get" class="search-form search__form" action="<?php echo esc_url(home_url('/')); ?>">
	<div class="form-search">
		<input type="search" id="<?php echo esc_attr($unique_id); ?>" class="search-field search__input" name="s" placeholder="<?php esc_attr_e("Search website", "socialv"); ?>" />
		<button type="submit" class="search-submit">
			<i class="iconly-Search icli" aria-hidden="true"></i>
			<span class="screen-reader-text">
				<?php echo esc_html_x('Search', 'submit button', 'socialv'); ?>
			</span>
		</button>
	</div>
</form>