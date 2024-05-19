<?php

/**
 * BuddyPress - Members Notifications Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>
<form action="" method="post" id="notifications-bulk-management">
	<div class="table-responsive">
		<table class="notifications">
			<thead>
				<tr>
					<th class="icon"></th>
					<th class="bulk-select-all text-center"><input id="select-all-notifications" type="checkbox"><label class="bp-screen-reader-text" for="select-all-notifications"><?php
																																														/* translators: accessibility text */
																																														esc_html_e('Select all', 'socialv');
																																														?></label></th>
					<th class="title"><?php esc_html_e('Notification', 'socialv'); ?></th>
					<th class="date"><?php esc_html_e('Date Received', 'socialv'); ?></th>
					<th class="actions text-center"><?php esc_html_e('Actions',    'socialv'); ?></th>
				</tr>
			</thead>

			<tbody>

				<?php while (bp_the_notifications()) : bp_the_notification(); ?>

					<tr>
						<td></td>
						<td class="bulk-select-check text-center">
							<label for="<?php bp_the_notification_id(); ?>">
								<input id="<?php bp_the_notification_id(); ?>" type="checkbox" name="notifications[]" value="<?php bp_the_notification_id(); ?>" class="notification-check">
								<span class="bp-screen-reader-text"><?php	/* translators: accessibility text */ _e('Select this notification', 'socialv');						?></span>
							</label>
						</td>
						<td class="notification-description"><?php bp_the_notification_description();  ?></td>
						<td class="notification-since"><?php bp_the_notification_time_since();   ?></td>
						<td class="notification-actions table-data-action text-center"><?php bp_the_notification_action_links(array('sep' => '')); ?></td>
					</tr>

				<?php endwhile; ?>

			</tbody>
		</table>
	</div>
	<div class="text-end">
		<div class="notifications-options-nav position-relative">
			<select name="notification_bulk_action" id="notification-select">
				<option value="" selected="selected"><?php esc_html_e('Bulk Actions', 'socialv'); ?></option>

				<?php if (bp_is_current_action('unread')) : ?>
					<option value="read"><?php esc_html_e('Mark read', 'socialv'); ?></option>
				<?php elseif (bp_is_current_action('read')) : ?>
					<option value="unread"><?php esc_html_e('Mark unread', 'socialv'); ?></option>
				<?php endif; ?>
				<option value="delete"><?php esc_html_e('Delete', 'socialv'); ?></option>
			</select>
			<input type="submit" id="notification-bulk-manage" class="button action btn socialv-btn-success" value="<?php esc_attr_e('Apply', 'socialv'); ?>">

		</div><!-- .notifications-options-nav -->
	</div>
	<?php wp_nonce_field('notifications_bulk_nonce', 'notifications_bulk_nonce'); ?>
</form>