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
get_header();

echo '<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<div class="' . apply_filters('content_container_class', 'container') . '">
			<div class="row">
				<div class="col-md-12 col-sm-12">';

while (have_posts()) :
	the_post();
	global $post;
	$post_content = $post->post_content;


	if (class_exists('PMPro_Membership_Level')) {
		$queried_object_id    = get_queried_object_id();
		$levels_page_id       = pmpro_getOption('levels_page_id');
		$confirmation_page_id = pmpro_getOption('confirmation_page_id');
		$checkout_page_id     = pmpro_getOption('checkout_page_id');
		if (in_array($queried_object_id, [$levels_page_id, $confirmation_page_id, $checkout_page_id, has_shortcode($post_content, 'pmpro_levels')])) {
			do_action('socialv_pmpro_membership_top_wizard');
		}
		// Check if the current post is restricted to members
		if (!pmpro_has_membership_access($post->ID)) {
			echo '<div class="card-main"><div class="card-inner">';
			the_content();
			echo '</div></div>';
		} else {
			if (strpos($post_content, '[pmpro_') !== false || strpos($post_content, 'Paid Memberships Pro') !== false) {
				$is_login_page      = pmpro_is_login_page($post->ID);
				$account_page_id    = pmpro_getOption('account_page_id');
				$cancel_page_id     = pmpro_getOption('cancel_page_id');
				$is_cancel_page     = is_page($cancel_page_id);
				$is_account_page    = is_page($account_page_id);

				$card_main_class    = $is_login_page ? ' socialv-bp-login' : '';
				$card_main_class    .= $is_cancel_page ? ' pmpro-card-sm-box' : '';
				$card_main_class    .= $is_account_page ? ' pmpro-card-main' : '';
				$card_inner_classes = $is_account_page ? '' : 'card-inner';
				echo '<div class="card-main socialv-pmpro-page ' . $card_main_class . '">';
				echo '<div class="' . $card_inner_classes . '">';
				if ($is_cancel_page) {
					do_action('socialv_pmpro_member_header_top');
				}
				get_template_part('template-parts/content/entry_page', get_post_type());
				echo '</div>';
				if ($is_account_page) {
					echo '</div>';
				} else {
					echo '</div></div>';
				}
			} else {
				get_template_part('template-parts/content/entry_page', get_post_type());
			}
		}
	} else {
		get_template_part('template-parts/content/entry_page', get_post_type());
	}

	wp_reset_postdata();

endwhile;

echo '</div>
			</div>
		</div><!-- #primary -->
	</main><!-- #main -->
</div><!-- .container -->';

get_footer();
