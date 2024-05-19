<?php

/**
 * BuddyPress - Activity Stream (Single Item)
 *
 * This template is used by activity-loop.php and AJAX functions to show
 * each activity.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @since 3.0.0
 * @version 10.0.0
 */

use function SocialV\Utility\socialv;

/**
 * Fires before the display of an activity entry.
 *
 * @since 1.2.0
 */
do_action('bp_before_activity_entry');
$reaction_class = '';
$socialv_option = get_option('socialv-options');
$share_option = (isset($socialv_option['is_socialv_enable_share_post']) && $socialv_option['is_socialv_enable_share_post'] == '1') ? true : false;
$is_iqonic_reaction_active = false;
if (function_exists('iqonic_is_reaction_plugin_active')) {
	$is_iqonic_reaction_active = iqonic_is_reaction_plugin_active();
}
$activity_id = bp_get_activity_id();
$acivity_class = bp_get_activity_type() === 'activity_share' ? ' activity-sharing' : '';
?>

<li class="<?php bp_activity_css_class(); ?> socialv-activity-parent" id="activity-<?php bp_activity_id(); ?>">
	<div class="socialv_activity_inner">

		<div class="socialv-activity-header">
			<?php do_action("socialv_activity_header"); ?>
		</div>


		<div class="activity-content<?php echo esc_attr($acivity_class); ?>">

			<div class="activity-inner">

				<?php if (bp_activity_has_content() || bp_is_group() || bp_is_user()) : ?>
					<?php bp_get_template_part('activity/type-parts/content',  bp_activity_type_part()); ?>
				<?php endif;
				if (bp_get_activity_type() === 'activity_share') {
					$share_id = bp_activity_get_meta($activity_id, 'shared_activity_id', true);
					do_action('socialv_share_activity', $share_id);
				}
				?>
			</div>

			<?php

			/**
			 * Fires after the display of an activity entry content.
			 *
			 * @since 1.2.0
			 */
			do_action('bp_activity_entry_content'); ?>

			<!-- meta -->
			<?php
			$users_likes = bp_activity_get_meta($activity_id, "_socialv_activity_liked_users", true);
			$comment_count = bp_activity_get_comment_count(); ?>

			<div class="socialv-meta-details">
				<!-- display user likes -->
				<?php
				if ($is_iqonic_reaction_active) {
					do_action('iqonic-user-reaction-list', $activity_id, get_current_user_id());
				} else {
					do_action("socialv_activity_like_users", $users_likes);
				}

				if ($comment_count > 0) : ?>
					<div class="comment-info">
						<?php printf(' %1s %2s', $comment_count, ($comment_count == 1) ? esc_html__(" Comment", "socialv") : esc_html__(" Comments", "socialv")); ?>
					</div>
				<?php endif ?>
			</div>

			<div class="socialv-comment-main">
				<div class="comment-activity">
					<div class="socialv-activity_comment">
						<?php if (bp_get_activity_type() == 'activity_comment') : 	?>

							<a href="<?php bp_activity_thread_permalink(); ?>" class="button view ">
								<?php esc_html_e('View Conversation', 'socialv'); ?>
							</a>

						<?php endif; ?>

						<?php if (is_user_logged_in()) : ?>

							<?php if (bp_activity_can_favorite()) : ?>
								<?php
								$is_liked_class = "";
								if (socialv()->is_socialv_user_likes($activity_id, "_socialv_activity_liked_users")) :
									$is_liked_class = " liked";
								endif;
								$like_icon = '<i class="iconly-Heart icli"></i>';
								$like_label =  "<span class='label-like'>" . esc_html__("Like", "socialv") . "</span>";
								$like_html = $like_icon . $like_label;
								?>
								<?php if ($is_iqonic_reaction_active) { ?>
								<?php do_action("iqonic_reaction", $activity_id, get_current_user_id());
								} else { ?>

									<a href="javascript:void(0)" class="socialv-user-activity-btn<?php echo esc_attr($is_liked_class); ?>" data-id="<?php bp_activity_id(); ?>">
										<?php echo apply_filters("socialv_activity_like", $like_html, $like_label, $like_icon); ?>
									</a> <?php
										} ?>

							<?php endif; ?>

							<?php if (bp_activity_can_comment()) : ?>
								<?php
								$comment_icon = '<i class="iconly-Chat icli"></i>';
								$comment_label = "<span class='label-comment'>" . esc_html__("Comment", "socialv") . "</span>";
								$comment_html = $comment_icon . $comment_label;
								?>
								<a href="<?php bp_activity_comment_link(); ?>" class="socialv-acomment-reply main-comment active " id="acomment-comment-<?php bp_activity_id(); ?>" comment-id="ac-form-<?php bp_activity_id(); ?>">
									<?php echo apply_filters("socialv_activity_comment", $comment_html, $comment_label, $comment_icon); ?>
								</a>
							<?php endif; ?>
						<?php endif; ?>
						<!-- share -->
						<?php
						if (is_user_logged_in() && ($share_option == true)) :
							$share_icon = '<span class="share_icon"><i class="icon-share"></i></span>';
							$share_label = "<span>" . esc_html__("Share", "socialv") . "</span>";
							$share_html = $share_icon . $share_label;
						?>
							<div class="socialv-share-post">
								<span class="share-btn">
									<?php echo apply_filters("socialv_activity_share", $share_html, $share_label, $share_icon); ?>
								</span>
								<?php do_action('socialv_social_share'); ?>
							</div>
						<?php
						endif;

						/**
						 * Fires at the end of the activity entry meta data area.
						 *
						 * @since 1.2.0
						 */
						do_action('bp_activity_entry_meta'); ?>

					</div>
				</div>
			</div>
		</div>

		<?php

		/**
		 * Fires before the display of the activity entry comments.
		 *
		 * @since 1.2.0
		 */
		do_action('bp_before_activity_entry_comments'); ?>

		<?php if ((bp_activity_get_comment_count() || bp_activity_can_comment()) || bp_is_single_activity()) : ?>

			<div class="activity-comments socialv-form">

				<?php if (is_user_logged_in() && bp_activity_can_comment()) : ?>

					<form action="<?php bp_activity_comment_form_action(); ?>" method="post" id="ac-form-<?php bp_activity_id(); ?>" class="ac-form socialv-comment-form" <?php bp_activity_comment_form_nojs_display(); ?>>
						<div class="socialv-form-wrapper">
							<div class="ac-reply-avatar"><?php bp_loggedin_user_avatar('class=rounded-circle&type=thumb&width=' . BP_AVATAR_THUMB_WIDTH . '&height=' . BP_AVATAR_THUMB_HEIGHT); ?></div>
							<div class="ac-reply-content">
								<div class="ac-textarea">
									<label for="ac-input-<?php bp_activity_id(); ?>" class="bp-screen-reader-text">
										<?php
										/* translators: accessibility text */
										echo esc_html__('Comment', 'socialv');
										?>
									</label>
									<textarea placeholder="<?php esc_attr_e('Write a Comment ...', 'socialv'); ?>" id="ac-input-<?php bp_activity_id(); ?>" class="ac-input bp-suggestions" name="ac_input_<?php bp_activity_id(); ?>"></textarea>
								</div>

								<button class="send-comment-btn ac_form_submit" type="submit" name="ac_form_submit">
								</button>
								<input type="hidden" name="comment_form_id" value="<?php bp_activity_id(); ?>" />
							</div>

							<?php

							/**
							 * Fires after the activity entry comment form.
							 *
							 * @since 1.5.0
							 */
							do_action('bp_activity_entry_comments'); ?>

							<?php wp_nonce_field('new_activity_comment', '_wpnonce_new_activity_comment_' . $activity_id); ?>
						</div>
					</form>

				<?php endif; ?>

			</div>
			<div class="activity-comments-list">
				<?php bp_activity_comments(); ?>
			</div>


		<?php endif; ?>

		<?php

		/**
		 * Fires after the display of the activity entry comments.
		 *
		 * @since 1.2.0
		 */
		do_action('bp_after_activity_entry_comments'); ?>
	</div>
	<?php do_action('socialv_activity_footer'); ?>
</li>

<?php

/**
 * Fires after the display of an activity entry.
 *
 * @since 1.2.0
 */
do_action('bp_after_activity_entry');
