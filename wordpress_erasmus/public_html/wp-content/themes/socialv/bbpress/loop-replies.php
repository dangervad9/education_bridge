<?php

/**
 * Replies Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

do_action('bbp_template_before_replies_loop'); ?>

<div id="topic-<?php bbp_topic_id(); ?>-replies" class="replies-tab mt-3 clearfix border-radius-box">

	<div class="main-head-replies">
		<span class="bbp-reply-author me-3"><?php esc_html_e('Author',  'socialv'); ?></span>
		<span class="bbp-reply-content me-3"><?php bbp_show_lead_topic()
											? esc_html_e('Replies', 'socialv')
											: esc_html_e('Posts',   'socialv');
										?></span>
	</div>

	<?php if (bbp_thread_replies()) : ?>

		<?php bbp_list_replies(); ?>

	<?php else : ?>

		<?php while (bbp_replies()) : bbp_the_reply(); ?>

			<?php bbp_get_template_part('loop', 'single-reply'); ?>

		<?php endwhile; ?>

	<?php endif; ?>
</div><!-- #topic-<?php bbp_topic_id(); ?>-replies -->

<?php do_action('bbp_template_after_replies_loop');
