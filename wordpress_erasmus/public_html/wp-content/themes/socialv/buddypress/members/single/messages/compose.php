<?php

/**
 * BuddyPress - Members Single Messages Compose
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>
<h2 class="bp-screen-reader-text"><?php
									/* translators: accessibility text */
									esc_html_e('Compose Message', 'socialv');
									?></h2>

<form action="<?php bp_messages_form_action('compose'); ?>" method="post" id="send_message_form" class="standard-form1" enctype="multipart/form-data">

	<?php

	/**
	 * Fires before the display of message compose content.
	 *
	 * @since 1.1.0
	 */
	do_action('bp_before_messages_compose_content'); ?>


	<ul class="first acfb-holder1 list-inline m-0">
		<?php bp_message_get_recipient_tabs(); ?>
		<li class="form-editor-box">
			<input type="text" name="send-to-input" class="form-control send-to-input" placeholder="<?php esc_attr_e("Send To (Username or Friend's Name)", 'socialv'); ?>" />
		</li>
	</ul>

	<?php if (bp_current_user_can('bp_moderate')) : ?>
		<p><label for="send-notice"><input type="checkbox" id="send-notice" name="send-notice" value="1" /> <?php esc_html_e("This is a notice to all users.", 'socialv'); ?></label></p>
	<?php endif; ?>

	<div class="form-floating">
		<input type="text" name="subject" id="subject" class="form-control" value="<?php bp_messages_subject_value(); ?>" placeholder="<?php esc_attr_e('Subject', 'socialv'); ?>" />
		<label><?php esc_html_e('Subject', 'socialv'); ?></label>
	</div>

	<div class="form-floating">
		<textarea name="content" id="message_content" class="form-control" rows="15" cols="40" placeholder="<?php esc_attr_e('Content', 'socialv'); ?>"><?php bp_messages_content_value(); ?></textarea>
		<label for="message_content"><?php esc_html_e('Message', 'socialv'); ?></label>
	</div>

	<input type="hidden" name="send_to_usernames" id="send-to-usernames" value="<?php bp_message_get_recipient_usernames(); ?>" class="<?php bp_message_get_recipient_usernames(); ?>" />

	<?php

	/**
	 * Fires after the display of message compose content.
	 *
	 * @since 1.1.0
	 */
	do_action('bp_after_messages_compose_content'); ?>
	<div class="form-edit-btn">
		<div class="submit">
			<input type="submit" value="<?php esc_attr_e("Send Message", 'socialv'); ?>" name="send" id="send" class="btn socialv-btn-success" />
		</div>
	</div>

	<?php wp_nonce_field('messages_send_message'); ?>
</form>