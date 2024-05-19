<?php

/**
 * BuddyPress - Activity Stream Comment
 *
 * This template is used by bp_activity_comments() functions to show
 * each activity.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires before the display of an activity comment.
 *
 * @since 1.5.0
 */

do_action('bp_before_activity_comment'); ?>

<li id="acomment-<?php bp_activity_comment_id(); ?>">
	<div class="comment-container-main">
		<div class="acomment-header">
			<div class="acomment-avatar-sv">
				<a href="<?php bp_activity_comment_user_link(); ?>">
					<?php bp_activity_avatar('class=rounded-circle&type=full&user_id=' . bp_get_activity_comment_user_id() . '&width=' . BP_AVATAR_THUMB_WIDTH . '&height=' . BP_AVATAR_THUMB_HEIGHT); ?>
				</a>
			</div>
			<div class="acomment-meta-info">
				<div class="acomment-meta">
					<?php
					printf(__('<a href="%1$s">%2$s</a><div class="activity-time-main"> replied <a href="%3$s" class="activity-time-since"><span class="time-since" data-livestamp="%4$s">%5$s</span></a></div>', 'socialv'), bp_get_activity_comment_user_link(), bp_get_activity_comment_name(),  bp_get_activity_comment_permalink(), bp_core_get_iso8601_date(bp_get_activity_comment_date_recorded()), bp_get_activity_comment_date_recorded());
					?>
				</div>
			</div>
		</div>


		<div class="acomment-content"><?php bp_activity_comment_content(); ?></div>

		<div class="acomment-options">
			<?php
			$is_iqonic_reaction_active = false;
			if (function_exists('iqonic_is_reaction_plugin_active')) {
				$is_iqonic_reaction_active = iqonic_is_reaction_plugin_active();
			}

			do_action("iqonic-comment-reaction", bp_get_activity_id(), get_current_user_id(), bp_get_activity_comment_id(), bp_get_activity_comment_user_id());
			if ($is_iqonic_reaction_active && is_user_logged_in()) {
			} ?>
			<?php if (is_user_logged_in() && bp_activity_can_comment_reply(bp_activity_current_comment())) : ?>

				<a href="#acomment-<?php bp_activity_comment_id(); ?>" class="socialv-acomment-reply list-reply" id="acomment-reply-<?php bp_activity_id(); ?>-from-<?php bp_activity_comment_id(); ?>" comment-id="ac-form-<?php bp_activity_id(); ?>"><?php esc_html_e('Reply', 'socialv'); ?></a>

			<?php endif; ?>

			<?php if (bp_activity_user_can_delete()) : ?>

				<a href="<?php bp_activity_comment_delete_link(); ?>" class="delete acomment-delete confirm bp-secondary-action" rel="nofollow"><?php esc_html_e('Delete', 'socialv'); ?></a>

			<?php endif; ?>

			<?php

			/**
			 * Fires after the default comment action options display.
			 *
			 * @since 1.6.0
			 */
			do_action('bp_activity_comment_options'); ?>
			<?php
			if ($is_iqonic_reaction_active) {
				do_action("iqonic-comment-reaction-list", bp_get_activity_id(), get_current_user_id(), bp_get_activity_comment_id());
			} ?>

		</div>
	</div>
	<?php bp_activity_recurse_comments(bp_activity_current_comment()); ?>
</li>

<?php

/**
 * Fires after the display of an activity comment.
 *
 * @since 1.5.0
 */
do_action('bp_after_activity_comment');
