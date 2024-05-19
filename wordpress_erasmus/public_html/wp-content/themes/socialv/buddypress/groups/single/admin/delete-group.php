<?php
/**
 * BuddyPress - Groups Admin - Delete Group
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<h2 class="bp-screen-reader-text"><?php esc_html_e( 'Delete Group', 'socialv' ); ?></h2>

<?php

/**
 * Fires before the display of group delete admin.
 *
 * @since 1.1.0
 */
do_action( 'bp_before_group_delete_admin' ); ?>

<div id="message" class="info">
	<p><?php esc_html_e( 'WARNING: Deleting this group will completely remove ALL content associated with it. There is no way back, please be careful with this option.', 'socialv' ); ?></p>
</div>

<label for="delete-group-understand" class="checkbox-label mt-3"><input type="checkbox" name="delete-group-understand" id="delete-group-understand" value="1" onclick="if(this.checked) { document.getElementById('delete-group-button').disabled = ''; } else { document.getElementById('delete-group-button').disabled = 'disabled'; }" /> <?php esc_html_e( 'I understand the consequences of deleting this group.', 'socialv' ); ?></label>

<?php

/**
 * Fires after the display of group delete admin.
 *
 * @since 1.1.0
 */
do_action( 'bp_after_group_delete_admin' ); ?>
<div class="form-edit-btn">
	<div class="submit">
		<input type="submit" disabled="disabled" value="<?php esc_attr_e( 'Delete Group', 'socialv' ); ?>" id="delete-group-button" class="btn socialv-btn-danger" name="delete-group-button" />
	</div>
</div>

<?php wp_nonce_field( 'groups_delete_group' );
