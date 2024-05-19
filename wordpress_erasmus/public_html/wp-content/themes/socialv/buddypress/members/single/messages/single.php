<?php
/**
 * BuddyPress - Members Single Message
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 10.0.0
 */

?>
<div id="message-thread">

	<?php

	/**
	 * Fires before the display of a single member message thread content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_message_thread_content' ); ?>

	<?php if ( bp_thread_has_messages() ) : ?>

		<h2 id="message-subject"><?php bp_the_thread_subject(); ?></h2>

		<p id="message-recipients">
			<span class="highlight">

				<?php if ( bp_get_thread_recipients_count() <= 1 ) : ?>

					<?php esc_html_e( 'You are alone in this conversation.', 'socialv' ); ?>

				<?php elseif ( bp_get_max_thread_recipients_to_list() <= bp_get_thread_recipients_count() ) : ?>

					<?php
					/* translators: %s: message recipients count */
					printf( __( 'Conversation between %s recipients.', 'socialv' ), number_format_i18n( bp_get_thread_recipients_count() ) );
					?>

				<?php else : ?>

					<?php
					/* translators: %s: message recipients list */
					printf( __( 'Conversation between %s.', 'socialv' ), bp_get_thread_recipients_list() );
					?>

				<?php endif; ?>

			</span>
			<span class="data-buttons">

			<a class="btn socialv-btn-danger confirm" href="<?php bp_the_thread_delete_link(); ?>"><?php esc_html_e( 'Delete', 'socialv' ); ?></a>

			<?php if ( bp_get_thread_recipients_count() > 2 ) : ?>

				<a class="btn socialv-btn-danger confirm" href="<?php bp_the_thread_exit_link(); ?>"><?php esc_html_e( 'Exit Conversation', 'socialv' ); ?></a>

			<?php endif; ?>

			<?php

			/**
			 * Fires after the action links in the header of a single message thread.
			 *
			 * @since 2.5.0
			 */
			do_action( 'bp_after_message_thread_recipients' ); ?>
			</span>
		</p>

		<?php

		/**
		 * Fires before the display of the message thread list.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_before_message_thread_list' ); ?>

		<?php while ( bp_thread_messages() ) : bp_thread_the_message(); ?>
			<?php bp_get_template_part( 'members/single/messages/message' ); ?>
		<?php endwhile; ?>

		<?php

		/**
		 * Fires after the display of the message thread list.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_after_message_thread_list' ); ?>

		<?php

		/**
		 * Fires before the display of the message thread reply form.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_before_message_thread_reply' ); ?>

		<form id="send-reply" action="<?php bp_messages_form_action(); ?>" method="post" class="standard-form1">

			<div class="message-box1">

				<div class="message-metadata">

					<?php

					/** This action is documented in bp-templates/bp-legacy/buddypress-functions.php */
					do_action( 'bp_before_message_meta' ); ?>

					<div class="avatar-box">
						<?php bp_loggedin_user_avatar( 'type=thumb&height=50&width=50' ); ?>

						<strong><?php esc_html_e( 'Send a Reply', 'socialv' ); ?></strong>
					</div>

					<?php
					do_action( 'bp_after_message_meta' ); ?>

				</div><!-- .message-metadata -->

				<div class="message-content">

					<?php

					/**
					 * Fires before the display of the message reply box.
					 *
					 * @since 1.1.0
					 */
					do_action( 'bp_before_message_reply_box' ); ?>

					<div class="form-floating ">
						<textarea name="content" id="message_content" class="form-control" rows="15" cols="40" placeholder="<?php esc_attr_e('Message', 'socialv'); ?>"></textarea>
						<label for="message_content">
							<?php
							/* translators: accessibility text */
							esc_html_e( 'Reply to Message', 'socialv' );
						?>
						</label>
					</div>

					<?php

					/**
					 * Fires after the display of the message reply box.
					 *
					 * @since 1.1.0
					 */
					do_action( 'bp_after_message_reply_box' ); ?>
					<div class="form-edit-btn">
						<div class="submit">
							<input type="submit" name="send" value="<?php esc_attr_e( 'Send Reply', 'socialv' ); ?>" id="send_reply_button" class="btn socialv-btn-success" />
						</div>
					</div>

					<input type="hidden" id="thread_id" name="thread_id" value="<?php bp_the_thread_id(); ?>" />
					<input type="hidden" id="messages_order" name="messages_order" value="<?php bp_thread_messages_order(); ?>" />
					<?php wp_nonce_field( 'messages_send_message', 'send_message_nonce' ); ?>

				</div><!-- .message-content -->

			</div><!-- .message-box -->

		</form><!-- #send-reply -->

		<?php

		/**
		 * Fires after the display of the message thread reply form.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_after_message_thread_reply' ); ?>

	<?php endif; ?>

	<?php

	/**
	 * Fires after the display of a single member message thread content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_message_thread_content' ); ?>

</div>
