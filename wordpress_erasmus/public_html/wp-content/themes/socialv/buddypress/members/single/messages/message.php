<?php

/**
 * BuddyPress - Private Message Content.
 *
 * This template is used in /messages/single.php during the message loop to
 * display each message and when a new message is created via AJAX.
 *
 * @since 2.4.0
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<div class="message-box <?php bp_the_thread_message_css_class(); ?>">

	<div class="message-metadata">
		<?php

		/**
		 * Fires before the single message header is displayed.
		 *
		 * @since 1.1.0
		 */
		do_action('bp_before_message_meta'); ?>
		<div class="socialv-single-message-top">
			<?php bp_the_thread_message_sender_avatar('width=50&height=50'); ?>
			<div class="socialv-single-message-content">
				<?php if (bp_get_the_thread_message_sender_link()) : ?>

					<h6><a href="<?php bp_the_thread_message_sender_link(); ?>"><?php bp_the_thread_message_sender_name(); ?></a></h6>

				<?php else : ?>

					<h6><?php bp_the_thread_message_sender_name(); ?></h6>

				<?php endif; ?>

				<span class="activity"><?php bp_the_thread_message_time_since(); ?></span>
			</div>
		</div>
		<?php if (bp_is_active('messages', 'star')) : ?>
			<div class="message-star-actions">
				<?php bp_the_message_star_action_link(); ?>
			</div>
		<?php endif; ?>

		<?php

		/**
		 * Fires after the single message header is displayed.
		 *
		 * @since 1.1.0
		 */
		do_action('bp_after_message_meta'); ?>

	</div><!-- .message-metadata -->

	<?php

	/**
	 * Fires before the message content for a private message.
	 *
	 * @since 1.1.0
	 */
	do_action('bp_before_message_content'); ?>

	<div class="message-content">

		<?php bp_the_thread_message_content(); ?>

	</div><!-- .message-content -->

	<?php

	/**
	 * Fires after the message content for a private message.
	 *
	 * @since 1.1.0
	 */
	do_action('bp_after_message_content'); ?>

	<div class="clear"></div>

</div><!-- .message-box -->