<?php

/**
 * BuddyPress - Members Messages Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires before the members messages loop.
 *
 * @since 1.2.0
 */
$socialv_options = get_option('socialv-options');
do_action('bp_before_member_messages_loop'); ?>

<?php if (bp_has_message_threads(bp_ajax_querystring('messages') . '&per_page=' . (isset($socialv_options['default_post_per_page']) ? $socialv_options['default_post_per_page'] : 10))) : ?>
	<?php

	/**
	 * Fires after the members messages pagination display.
	 *
	 * @since 1.2.0
	 */
	do_action('bp_after_member_messages_pagination'); ?>

	<?php

	/**
	 * Fires before the members messages threads.
	 *
	 * @since 1.2.0
	 */
	do_action('bp_before_member_messages_threads'); ?>

	<form action="<?php echo bp_displayed_user_domain() . bp_get_messages_slug() . '/' . bp_current_action() ?>/bulk-manage/" method="post" id="messages-bulk-management">
		<div class="table-responsive">
			<table id="message-threads" class="messages-notices">

				<thead>
					<tr>
						<th scope="col" class="thread-checkbox bulk-select-all text-center"><input id="select-all-messages" type="checkbox"><label class="bp-screen-reader-text" for="select-all-messages"><?php
																																																			/* translators: accessibility text */
																																																			esc_html_e('Select all', 'socialv');
																																																			?></label></th>
						<th scope="col" class="thread-from"><?php esc_html_e('From', 'socialv'); ?></th>
						<th scope="col" class="thread-info"><?php esc_html_e('Subject', 'socialv'); ?></th>

						<?php

						/**
						 * Fires inside the messages box table header to add a new column.
						 *
						 * This is to primarily add a <th> cell to the messages box table header. Use
						 * the related 'bp_messages_inbox_list_item' hook to add a <td> cell.
						 *
						 * @since 2.3.0
						 */
						do_action('bp_messages_inbox_list_header'); ?>

						<?php if (bp_is_active('messages', 'star')) : ?>
							<th scope="col" class="thread-star"></th>
						<?php endif; ?>

						<th scope="col" class="thread-options text-center"><?php esc_html_e('Actions', 'socialv'); ?></th>
					</tr>
				</thead>

				<tbody>

					<?php while (bp_message_threads()) : bp_message_thread(); ?>

						<tr id="m-<?php bp_message_thread_id(); ?>" class="<?php bp_message_css_class(); ?><?php if (bp_message_thread_has_unread()) : ?> unread<?php else : ?> read<?php endif; ?>">
							<td class="bulk-select-check text-center">
								<label for="bp-message-thread-<?php bp_message_thread_id(); ?>"><input type="checkbox" name="message_ids[]" id="bp-message-thread-<?php bp_message_thread_id(); ?>" class="message-check" value="<?php bp_message_thread_id(); ?>" /><span class="bp-screen-reader-text"><?php
																																																																											/* translators: accessibility text */
																																																																											esc_html_e('Select this message', 'socialv');
																																																																											?></span></label>
							</td>

							<?php if ('sentbox' != bp_current_action()) : ?>
								<td class="thread-from d-flex align-items-center gap-3">
									<div class="thread-avatar">
										<?php bp_message_thread_avatar(array('width' => 55, 'height' => 55, 'class' => 'rounded-circle')); ?>
									</div>
									<div class="thread-details">
										<?php bp_message_thread_from(); ?>
										<?php bp_message_thread_total_and_unread_count(); ?>
										<span class="activity d-block"><?php bp_message_thread_last_post_date(); ?></span>
									</div>
								</td>
							<?php else : ?>
								<td class="thread-from d-flex align-items-center gap-3">
									<div class="thread-avatar">
										<?php bp_message_thread_avatar(array('width' => 55, 'height' => 55)); ?>
									</div>
									<div class="thread-details">
										<?php bp_message_thread_to(); ?>
										<?php bp_message_thread_total_and_unread_count(); ?>
										<span class="activity d-block"><?php bp_message_thread_last_post_date(); ?></span>
									</div>
								</td>
							<?php endif; ?>

							<td class="thread-info">
								<p><a href="<?php bp_message_thread_view_link(bp_get_message_thread_id(), bp_displayed_user_id()); ?>" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php esc_attr_e("View Message", 'socialv'); ?>" aria-label="<?php esc_attr_e("View Message", 'socialv'); ?>"><?php bp_message_thread_subject(); ?></a></p>
								<p class="thread-excerpt"><?php bp_message_thread_excerpt(); ?></p>
							</td>

							<?php

							/**
							 * Fires inside the messages box table row to add a new column.
							 *
							 * This is to primarily add a <td> cell to the message box table. Use the
							 * related 'bp_messages_inbox_list_header' hook to add a <th> header cell.
							 *
							 * @since 1.1.0
							 */
							do_action('bp_messages_inbox_list_item'); ?>

							<?php if (bp_is_active('messages', 'star')) : ?>
								<td class="thread-star">
									<?php bp_the_message_star_action_link(array('thread_id' => bp_get_message_thread_id())); ?>
								</td>
							<?php endif; ?>

							<td class="thread-options table-data-action text-center">
								<?php if (bp_message_thread_has_unread()) : ?>
									<a class="read btn socialv-btn-outline-primary p-0 border-0 " href="<?php bp_the_message_thread_mark_read_url(bp_displayed_user_id()); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e('Make as Read', 'socialv'); ?>"><i class="iconly-Show icli"></i></a>
								<?php else : ?>
									<a class="unread btn socialv-btn-outline-primary p-0 border-0 " href="<?php bp_the_message_thread_mark_unread_url(bp_displayed_user_id()); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e('Make as Unread', 'socialv'); ?>"><i class="iconly-Hide icli"></i></a>
								<?php endif; ?>

								<a class="delete btn socialv-btn-outline-danger p-0 border-0 " href="<?php bp_message_thread_delete_link(bp_displayed_user_id()); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e('Delete', 'socialv'); ?>"><i class="iconly-Delete icli"></i></a>

								<?php

								/**
								 * Fires after the thread options links for each message in the messages loop list.
								 *
								 * @since 2.5.0
								 */
								do_action('bp_messages_thread_options'); ?>
							</td>
						</tr>

					<?php endwhile; ?>

				</tbody>

			</table><!-- #message-threads -->
		</div>


		<div class="text-end">
			<div class="messages-options-nav position-relative">
				<select name="messages_bulk_action" id="messages-select">
					<option value="" selected="selected"><?php esc_html_e('Bulk Actions', 'socialv'); ?></option>
					<option value="read"><?php esc_html_e('Mark read', 'socialv'); ?></option>
					<option value="unread"><?php esc_html_e('Mark unread', 'socialv'); ?></option>
					<option value="delete"><?php esc_html_e('Delete', 'socialv'); ?></option>
					<?php
					do_action('bp_messages_bulk_management_dropdown');
					?>
				</select>
				<input type="submit" id="messages-bulk-manage" class="button action btn socialv-btn-success" value="<?php esc_attr_e('Apply', 'socialv'); ?>">

			</div><!-- .messages-options-nav -->
		</div>


		<?php wp_nonce_field('messages_bulk_nonce', 'messages_bulk_nonce'); ?>
	</form>

	<?php

	/**
	 * Fires after the members messages threads.
	 *
	 * @since 1.2.0
	 */
	do_action('bp_after_member_messages_threads'); ?>

	<?php

	/**
	 * Fires and displays member messages options.
	 *
	 * @since 1.2.0
	 */
	do_action('bp_after_member_messages_options'); ?>

	<div class="socialv-bp-pagination no-ajax" id="user-pag">
		<div class="pagination-links" id="messages-dir-pag">
			<?php bp_messages_pagination(); ?>
		</div>
	</div>
<?php else : ?>

	<div id="message" class="info">
		<p><?php esc_html_e('Sorry, no messages were found.', 'socialv'); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the members messages loop.
 *
 * @since 1.2.0
 */
do_action('bp_after_member_messages_loop');
