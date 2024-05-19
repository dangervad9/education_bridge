<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

do_action('bbp_template_before_forums_loop'); ?>
<div class="table-responsive mt-4 w-100">
	<table class="forums-table table bbp-forums" id="forums-list-<?php bbp_forum_id(); ?>">
		<tr>
			<?php if (bbp_is_user_home() && bbp_is_subscriptions()) : ?>
				<th class="pe-0"></th>
			<?php endif; ?>
			<th>
				<span><?php esc_html_e('Forum', 'socialv'); ?></span>
			</th>
			<th>
				<span><?php esc_html_e('Topics', 'socialv'); ?></span>
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


		<?php while (bbp_forums()) : bbp_the_forum(); ?>

			<?php bbp_get_template_part('loop', 'single-forum'); ?>

		<?php endwhile; ?>
	</table>
</div>

<?php do_action('bbp_template_after_forums_loop');
