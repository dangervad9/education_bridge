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
				<form method="get" id="bbp-topic-search-form">
					<div class="search-input">
						<label class="screen-reader-text hidden" for="ts"><?php esc_html_e('Search topics:', 'socialv'); ?></label>
						<input type="text" value="<?php bbp_search_terms(); ?>" name="ts" id="ts" class="form-control" placeholder="<?php esc_attr_e('Search topics:', 'socialv'); ?>"/>
						<button type="submit" id="bbp_search_submit" class="btn-search"><i class="iconly-Search icli"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php endif;
