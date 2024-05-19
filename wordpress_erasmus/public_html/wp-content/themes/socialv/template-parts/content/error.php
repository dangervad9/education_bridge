<?php

/**
 * Template part for displaying the page content when an error has occurred
 *
 * @package socialv
 */

namespace SocialV\Utility;

?>
<section class="error text-center socialv-error">
	<?php get_template_part('template-parts/content/page_header'); ?>
	<div class="page-content">
		<?php if (is_home() && current_user_can('publish_posts')) { ?>
			<p>
				<?php
				printf(
					wp_kses(
						/* translators: 1: link to WP admin new post page. */
						__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'socialv'),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					esc_url(admin_url('post-new.php'))
				);
				?>
			</p>
		<?php } elseif (is_search()) { ?>
			<p>
				<?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'socialv'); ?>
			</p>
			<form method="get" class="search-form search__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="form-search">
					<input type="search" class="search-field search__input" name="s" value="<?php echo get_search_query(); ?>" placeholder=<?php esc_attr_e("Search website","socialv") ?> />
					<button type="submit" class="search-submit" ><i class="iconly-Search icli" aria-hidden="true"></i><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'socialv' ); ?></span></button> 
				</div>
			</form>
			<div class="d-block">
				<?php
					$btn_text  = esc_html__('Back to Home','socialv');
				?>
				<?php socialv()->socialv_get_blog_readmore(home_url(), $btn_text); ?>
			</div>
		<?php } else { ?>
			<p>
				<?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'socialv'); ?>
			</p>
		<?php
		}
		get_search_form('');
		?>
	</div><!-- .page-content -->
</section><!-- .error -->