<?php

/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

do_action('bbp_template_before_topics_loop'); ?>
<div class="table-responsive mt-4 w-100">
	<table class="forums-table table bbp-topics" id="bbp-forum-<?php bbp_forum_id(); ?>">
		<tr>
			<?php if (bbp_is_user_home() && bbp_is_favorites() || bbp_is_subscriptions()) : ?>
				<th class="pe-0"></th>
			<?php endif; ?>
			<th>
				<span><?php esc_html_e('Topic', 'socialv'); ?></span>
			</th>
			<th>
				<span><?php esc_html_e('Voices', 'socialv'); ?></span>
			</th>
			<th>
				<span><?php bbp_show_lead_topic()
							? esc_html_e('Replies', 'socialv')
							: esc_html_e('Posts',   'socialv');
						?></span>
			</th>
			<th>
				<span><?php esc_html_e('Freshness', 'socialv'); ?></span>
			</th>
		</tr>

		<?php
		while (bbp_topics()) : bbp_the_topic(); ?>

			<?php bbp_get_template_part('loop', 'single-topic'); ?>
		<?php endwhile; ?>
	</table>
</div>

<?php do_action('bbp_template_after_topics_loop');
