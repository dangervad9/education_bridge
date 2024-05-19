<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

?>
<div class="replies-tab-table">
	<div id="post-<?php bbp_reply_id(); ?>" class="sv-reply-post-date d-flex justify-content-between align-items-center">
		<span><?php bbp_reply_post_date(); ?></span>
		<?php if (bbp_is_single_user_replies()) : ?>

			<span class="bbp-header">
				<?php esc_html_e('in reply to: ', 'socialv'); ?>
				<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(bbp_get_reply_topic_id()); ?>"><?php bbp_topic_title(bbp_get_reply_topic_id()); ?></a>
			</span>

		<?php endif; ?>
		<?php do_action('bbp_theme_before_reply_admin_links'); ?>

		<?php bbp_reply_admin_links(); ?>

		<?php do_action('bbp_theme_after_reply_admin_links'); ?>
		<a href="<?php bbp_reply_url(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a>

	</div>
	<div <?php bbp_reply_class(); ?>>
		<div class="bp-member-img flex-shrink-0">
			<?php bbp_reply_author_link(array('type' => 'avatar', 'size' => 50)); ?>
		</div>
		<?php do_action('bbp_theme_before_reply_author_details'); ?>
		<div class="flex-grow-1  main-bp-details">
			<div class="d-flex justify-content-between align-items-center">
				<?php bbp_reply_author_link(array('type' => 'name')); ?>
				<?php bbp_reply_author_role(array(
					'show_role' => true, 'before'   => '<span class="sv-author-role">',
					'after'    => '</span>'
				)); ?>
			</div>

			<?php if (current_user_can('moderate', bbp_get_reply_id())) : ?>

				<?php do_action('bbp_theme_before_reply_author_admin_details'); ?>

				<?php do_action('bbp_theme_after_reply_author_admin_details'); ?>

			<?php endif; ?>

			<?php do_action('bbp_theme_after_reply_author_details'); ?>
			<?php do_action('bbp_theme_before_reply_content'); ?>
			<div class="socialv_topic_reply_details">
				<?php bbp_reply_content(); ?>
			</div>

			<?php do_action('bbp_theme_after_reply_content'); ?>
		</div>
	</div>
</div>