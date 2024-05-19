<?php

/**
 * Search
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

if (bbp_allow_search()) : ?>
	<div class="card-main card-space">
		<div class="card-inner">
			<div class="socialv-bp-searchform">
				<form method="get" id="bbp-reply-search-form">
					<div class="search-input">
						<label class="screen-reader-text hidden" for="rs"><?php esc_html_e('Search replies:', 'socialv'); ?></label>
						<input type="text" value="<?php bbp_search_terms(); ?>" name="rs" id="rs" class="form-control" placeholder="<?php esc_attr_e('Search replies:', 'socialv'); ?>" />
						<button type="submit" id="bbp_search_submit" class="btn-search"><i class="iconly-Search icli"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php endif;
