<?php
/**
 * BuddyPress - Sent Membership Invitations
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 8.0.0
 */
?>
<h2 class="bp-screen-reader-text">
	<?php
	/* translators: accessibility text */
	esc_html_e( 'Send Invitations', 'socialv' );
	?>
</h2>

<?php if ( bp_user_can( bp_displayed_user_id(), 'bp_members_send_invitation' ) ) : ?>

<div class="card-main">
	<div class="card-inner">
		<form class="standard-form1 members-invitation-form" id="members-invitation-form" method="post">
			<p class="description"><?php esc_html_e( 'Fill out the form below to invite a new user to join this site. Upon submission of the form, an email will be sent to the invitee containing a link to accept your invitation. You may also add a custom message to the email.', 'socialv' ); ?></p>

			<div class="form-floating">
				<input id="bp_members_invitation_invitee_email" type="email" class="form-control" name="invitee_email" required="required" placeholder="<?php esc_attr_e('Email', 'socialv'); ?>">
				<label for="bp_members_invitation_invitee_email"><?php esc_html_e( 'Email address of new user', 'socialv' ); ?></label>
			</div>

			<div class="form-floating">
				<textarea id="bp_members_invitation_message" class="form-control" name="content" placeholder="<?php esc_attr_e('Message', 'socialv'); ?>"></textarea>
				<label for="bp_members_invitation_message"><?php esc_html_e( 'Add a personalized message to the invitation (optional)', 'socialv' ); ?></label>
			</div>

			<input type="hidden" name="action" value="send-invite">

			<?php wp_nonce_field( 'bp_members_invitation_send_' . bp_displayed_user_id() ) ?>
			<div class="form-edit-btn">
				<p class="submit">
					<input id="submit" type="submit" name="submit" class="socialv-button submit" value="<?php esc_attr_e( 'Send Invitation', 'socialv' ) ?>" />
				</p>
			</div>
		</form>
	</div>
</div>


<?php else : ?>

	<p class="bp-feedback error">
		<span class="bp-icon" aria-hidden="true"></span>
		<span class="bp-help-text">
			<?php echo apply_filters( 'members_invitations_form_access_restricted', esc_html__( 'Sorry, you are not allowed to send invitations.', 'socialv' ) ); ?>
		</span>
	</p>

<?php endif; ?>
