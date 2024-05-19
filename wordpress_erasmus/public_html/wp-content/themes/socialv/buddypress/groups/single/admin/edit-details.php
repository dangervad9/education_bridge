<?php
/**
 * BuddyPress - Groups Admin - Edit Details
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<h2 class="bp-screen-reader-text"><?php esc_html_e( 'Manage Group Details', 'socialv' ); ?></h2>

<?php

/**
 * Fires before the display of group admin details.
 *
 * @since 1.1.0
 */
do_action( 'bp_before_group_details_admin' ); ?>

<div class="form-floating">
	<input type="text" name="group-name" id="group-name" class="form-control" placeholder="<?php esc_attr_e('Group Name','socialv'); ?>" value="<?php echo esc_attr( bp_get_group_name() ); ?>" aria-required="true" />
	<label for="group-name"><?php esc_html_e( 'Group Name (required)', 'socialv' ); ?></label>
</div>

<div class="form-floating">
	<textarea name="group-desc" id="group-desc" class="form-control" placeholder="<?php esc_attr_e('Group Description','socialv'); ?>" aria-required="true"><?php bp_group_description_editable(); ?></textarea>
	<label for="group-desc"><?php esc_html_e( 'Group Description (required)', 'socialv' ); ?></label>
</div>

<?php

/**
 * Fires after the group description admin details.
 *
 * @since 1.0.0
 */
do_action( 'groups_custom_group_fields_editable' ); ?>

<p>
	<label for="group-notify-members" class="checkbox-label">
		<input type="checkbox" name="group-notify-members" id="group-notify-members" value="1" /> <?php esc_html_e( 'Notify group members of these changes via email', 'socialv' ); ?>
	</label>
</p>

<?php

/**
 * Fires after the display of group admin details.
 *
 * @since 1.1.0
 */
do_action( 'bp_after_group_details_admin' ); ?>

<div class="form-edit-btn">
	<div class="submit"><input type="submit" value="<?php esc_attr_e( 'Save Changes', 'socialv' ); ?>" id="save" class="btn socialv-btn-success" name="save" /></div>
</div>
	<?php wp_nonce_field( 'groups_edit_group_details' );

