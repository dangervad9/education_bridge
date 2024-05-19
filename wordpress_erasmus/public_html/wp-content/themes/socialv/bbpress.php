<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage socialv
 * @since 1.0
 * @version 1.0
 */

use function SocialV\Utility\socialv;

get_header();
$post_section = socialv()->post_style();
if (class_exists('bbPress')) :
?>
	<div id="primary" class="content-area">
		<main id="main" class="socialv-bp-default-main site-main">
			<div class="<?php echo apply_filters('content_container_class', 'container'); ?>">
				<div class="row <?php echo esc_attr($post_section['row_reverse']); ?>">
					<?php
					socialv()->socialv_the_layout_class();
					while (have_posts()) : the_post();
						get_template_part('template-parts/content/entry_page', get_post_type());
					endwhile; // End of the loop.
					wp_reset_postdata();
					socialv()->socialv_sidebar();
					?>
				</div>
			</div><!-- #primary -->
		</main><!-- #main -->
	</div><!-- .container -->
<?php endif;
get_footer();
