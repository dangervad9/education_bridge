<?php

/**
 * Template part for displaying a post
 *
 * @package socialv
 */

namespace SocialV\Utility;

$socialv_options = get_option('socialv-options');
$socialv_layout = '';
if (isset($socialv_options['blog_setting'])) {
	$socialv_layout = $socialv_options['blog_setting'];
}
if ($socialv_layout == '2' || $socialv_layout == '3') {
?>
	<div class="<?php echo esc_attr($args); ?>">
	<?php } ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
		<div class="socialv-blog-box">
			<?php
			get_template_part('template-parts/content/entry_header', get_post_type());
			if (is_single()) {
				get_template_part('template-parts/content/entry_content', get_post_type());
			} else {
				get_template_part('template-parts/content/entry_summary', get_post_type());
			}
			wp_link_pages(array(
				'before'      => '<div class="page-links">' . esc_html__('Pages:', 'socialv'),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			));
			get_template_part('template-parts/content/entry_footer', get_post_type());
			?>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
	<?php
	if (is_singular(get_post_type())) {
		if (class_exists('ReduxFramework')) {
			$socialv_option = get_option('socialv-options');
			if ($socialv_option['display_comment'] == 'yes') {
				// Show comments only when the post type supports it and when comments are open or at least one comment exists.
				if (post_type_supports(get_post_type(), 'comments') && (comments_open() || get_comments_number())) {
					comments_template();
				}
			}
		} else {
			// Show comments only when the post type supports it and when comments are open or at least one comment exists.
			if (post_type_supports(get_post_type(), 'comments') && (comments_open() || get_comments_number())) {
				comments_template();
			}
		}
	}
	if ($socialv_layout == '2' || $socialv_layout == '3') { ?>
	</div>
<?php
	}
