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
	<div class="card-main">
		<div class="card-inner">
			<div class="socialv-bp-searchform">
				<form method="get" id="bbp-search-form">
					<div class="search-input">
						<label class="screen-reader-text hidden"><?php esc_html_e('Search for:', 'socialv'); ?></label>
						<input type="hidden" name="action" value="bbp-search-request" />
						<input type="text" value="<?php bbp_search_terms(); ?>" name="bbp_search" id="bbp_search" class="form-control" placeholder="<?php esc_attr_e('Search for:', 'socialv'); ?>" />
						<button type="submit" id="bbp_search_submit" class="btn-search"><i class="iconly-Search icli"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endif;
