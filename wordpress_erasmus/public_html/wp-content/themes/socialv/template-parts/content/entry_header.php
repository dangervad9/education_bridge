<?php

/**
 * Template part for displaying a post's header
 *
 * @package socialv
 */

namespace SocialV\Utility;

$socialv_options = get_option('socialv-options');
?>


<?php
if (!is_search()) {
	get_template_part('template-parts/content/entry_thumbnail', get_post_type());
}
?>
<div class="socialv-blog-detail">
	<?php
	get_template_part('template-parts/content/entry_meta', get_post_type());

	get_template_part('template-parts/content/entry_title', get_post_type());
	?>
	<!-- .entry-header -->