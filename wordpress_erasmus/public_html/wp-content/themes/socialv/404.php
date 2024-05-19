<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package socialv
 */

namespace SocialV\Utility;

get_header();
?>
<main id="primary" class="site-main">
	<?php get_template_part('template-parts/content/error', '404'); ?>
</main><!-- #primary -->
<?php
get_footer();
