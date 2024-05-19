<?php

/**
 * BuddyPress - Activity Post Form
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<form action="<?php bp_activity_post_form_action(); ?>" method="post" id="whats-new-form" name="whats-new-form">

	<?php

	/**
	 * Fires before the activity post form.
	 *
	 * @since 1.2.0
	 */
	do_action('bp_before_activity_post_form');
	?>
	<div class="main-upload-detail">


		<div id="whats-new-avatar" class="socialv-avatar">
			<a href="<?php echo bp_loggedin_user_domain(); ?>">
				<?php bp_loggedin_user_avatar('type=full&class=rounded-circle&width=' . bp_core_avatar_thumb_width() . '&height=' . bp_core_avatar_thumb_height()); ?>
			</a>
		</div>
		<!-- activity media upload buttons hook -->
		<?php do_action("socialv_activity_upload_buttons"); ?>
	</div>
	<div id="whats-new-content" class="whats-new-content">
		<?php
		if (bp_is_group()) {
			/* translators: 1: group name. 2: member name. */
			$greeting_placeholder = sprintf(esc_html__('What\'s new in %1$s, %2$s?', 'socialv'), bp_get_group_name(), bp_get_user_firstname(bp_get_loggedin_user_fullname()));
		} else {
			/* translators: %s: member name */
			$greeting_placeholder = sprintf(esc_html__("What's on your mind, %s?", 'socialv'), bp_get_user_firstname(bp_get_loggedin_user_fullname()));
		}
		?>
		<div id="whats-new-textarea" class="whats-new-textarea">
			<label for="whats-new" class="bp-screen-reader-text"><?php esc_html_e('Post what\'s new', 'socialv'); ?></label>
			<textarea class="bp-suggestions" placeholder="<?php echo esc_attr($greeting_placeholder) ?>" name="whats-new" id="whats-new" cols="50" rows="10" <?php if (bp_is_group()) : ?>data-suggestions-group-id="<?php echo esc_attr((int) bp_get_current_group_id()); ?>" <?php endif; ?>><?php if (isset($_GET['r'])) : ?>@<?php echo sanitize_textarea_field($_GET['r']); ?> <?php endif; ?></textarea>
		</div>

		<?php do_action("socialv_activity_upload_dropzone"); ?>

		<div class="socialv-whats-new-options">


			<?php if (bp_is_active('groups') && !bp_is_my_profile() && !bp_is_group()) : ?>

				<div id="whats-new-post-in-box" class="whats-new-post-in-box">
					<span class="post-lable"><?php esc_html_e('Post in', 'socialv'); ?></span>
					<div class="new-post-in-box">
						<select id="whats-new-post-in" name="whats-new-post-in">
							<option selected="selected" value="0"><?php esc_html_e('My Profile', 'socialv'); ?></option>

							<?php if (bp_has_groups('user_id=' . bp_loggedin_user_id() . '&type=alphabetical&max=100&per_page=100&populate_extras=0&update_meta_cache=0')) :
								while (bp_groups()) : bp_the_group(); ?>

									<option value="<?php bp_group_id(); ?>"><?php bp_group_name(); ?></option>

							<?php endwhile;
							endif; ?>

						</select>
					</div>

				</div>
			<?php elseif (bp_is_group_activity()) : ?>

				<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
				<input type="hidden" id="whats-new-post-in" name="whats-new-post-in" value="<?php bp_group_id(); ?>" />

			<?php endif;

			/**
			 * Fires at the end of the activity post form markup.
			 *
			 * @since 1.2.0
			 */
			do_action('bp_activity_post_form_options'); ?>
			<div class="whats-new-submit">
				<button type="submit" name="aw-whats-new-submit" id="aw-whats-new-submit" class="btn socialv-btn-primary" value="<?php esc_attr_e('Post', 'socialv'); ?>">
					<?php esc_attr_e('Post', 'socialv'); ?>
					<span class="btn-icon"><i class="iconly-Send icli"></i></span>
				</button>
			</div>
			<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />


		</div><!-- #whats-new-options -->
	</div><!-- #whats-new-content -->

	<?php wp_nonce_field('post_update', '_wpnonce_post_update'); ?>
	<?php

	/**
	 * Fires after the activity post form.
	 *
	 * @since 1.2.0
	 */
	do_action('bp_after_activity_post_form'); ?>

</form><!-- #whats-new-form -->