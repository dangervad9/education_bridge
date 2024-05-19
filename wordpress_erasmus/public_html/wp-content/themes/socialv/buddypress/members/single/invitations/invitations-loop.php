<?php

/**
 * BuddyPress - Membership Invitations Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 8.0.0
 */

?>

<form action="" method="post" id="invitations-bulk-management">
	<div class="table-responsive">
		<table class="invitations">
			<thead>
				<tr>
					<th class="bulk-select-all"><input id="select-all-invitations" type="checkbox">
						<label class="bp-screen-reader-text" for="select-all-invitations">
							<?php
							/* translators: accessibility text */
							esc_html_e('Select all', 'socialv');
							?>
						</label>
					</th>
					<th class="title"><?php esc_html_e('Invitee', 'socialv'); ?></th>
					<th class="content"><?php esc_html_e('Message', 'socialv'); ?></th>
					<th class="sent"><?php esc_html_e('Sent', 'socialv'); ?></th>
					<th class="accepted"><?php esc_html_e('Accepted', 'socialv'); ?></th>
					<th class="date"><?php esc_html_e('Date Modified', 'socialv'); ?></th>
					<th class="actions text-center"><?php esc_html_e('Actions', 'socialv'); ?></th>
				</tr>
			</thead>

			<tbody>
			
				<?php while (bp_the_members_invitations()) : bp_the_members_invitation(); ?>

					<tr>
						<td class="bulk-select-check">
							<label for="<?php bp_the_members_invitation_property('id', 'attribute'); ?>">
								<input id="<?php bp_the_members_invitation_property('id', 'attribute'); ?>" type="checkbox" name="members_invitations[]" value="<?php bp_the_members_invitation_property('id', 'attribute'); ?>" class="invitation-check">
								<span class="bp-screen-reader-text">
									<?php
									/* translators: accessibility text */
									esc_html_e('Select this invitation', 'socialv');
									?>
								</span>
							</label>
						</td>
						<td class="invitation-invitee"><?php bp_the_members_invitation_property('invitee_email');  ?></td>
						<td class="invitation-content"><?php bp_the_members_invitation_property('content');  ?></td>
						<td class="invitation-sent"><?php bp_the_members_invitation_property('invite_sent');  ?></td>
						<td class="invitation-accepted"><?php bp_the_members_invitation_property('accepted');  ?></td>
						<td class="invitation-date-modified"><?php bp_the_members_invitation_property('date_modified');   ?></td>
						<td class="invitation-actions table-data-action text-center"><?php bp_the_members_invitation_action_links(array('sep' => '')); ?></td>
					</tr>

				<?php endwhile; ?>

			</tbody>
		</table>

		<div class="text-end">
			<div class="invitations-options-nav position-relative">
				<label class="bp-screen-reader-text" for="invitation-select">
					<?php
					esc_html_e('Select Bulk Action', 'socialv');
					?>
				</label>

				<select name="invitation_bulk_action" id="invitation-select">
					<option value="" selected="selected"><?php esc_html_e('Bulk Actions', 'socialv'); ?></option>
					<option value="resend"><?php echo esc_html_x('Resend', 'button', 'socialv'); ?></option>
					<option value="cancel"><?php echo esc_html_x('Cancel', 'button', 'socialv'); ?></option>
				</select>

				<input type="submit" id="invitation-bulk-manage" class="button action btn socialv-btn-success" value="<?php echo esc_attr_x('Apply', 'button', 'socialv'); ?>">
			</div><!-- .invitations-options-nav -->
		</div>

		<?php wp_nonce_field('invitations_bulk_nonce', 'invitations_bulk_nonce'); ?>
	</div>
</form>