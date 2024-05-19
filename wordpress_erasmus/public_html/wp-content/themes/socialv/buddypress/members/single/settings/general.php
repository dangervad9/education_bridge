<?php

/**
 * BuddyPress - Members Single Profile
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>


<div class="card-inner">
	<?php do_action('bp_before_member_settings_template'); ?>
	<div id="template-notices" role="alert" aria-atomic="true">
		<?php
		do_action('template_notices'); ?>

	</div>
	<div class="card-head card-header-border d-flex align-items-center justify-content-between">
		<div class="head-title">
			<h4 class="card-title"><?php esc_html_e('Account settings', 'socialv'); ?></h4>
		</div>
	</div>
	<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/general'; ?>" method="post" class="standard-form1" id="settings-form">
		<div class="form-floating">
			<input type="email" name="email" id="email" class="form-control" value="<?php echo bp_get_displayed_user_email(); ?>" class="settings-input" <?php bp_form_field_attributes('email'); ?> placeholder="<?php esc_attr_e('Account Email', 'socialv'); ?>" />
			<label for="email"><?php esc_html_e('Account Email', 'socialv'); ?></label>
		</div>
		<div class="form-floating">
			<?php if (!is_super_admin()) : ?>
				<input type="password" name="pwd" id="pwd" class="form-control" size="16" value="" class="settings-input small" <?php bp_form_field_attributes('password'); ?> placeholder="<?php esc_attr_e('Current Password (required to update email or change current password)', 'socialv'); ?>" />
				<label for="pwd"><?php esc_html_e('Current Password (required to update email or change current password)', 'socialv'); ?></label>
			<?php endif; ?>
		</div>
		<div class="form-floating">
			<input type="password" name="pass1" id="pass1" class="form-control" size="16" value="" class="settings-input small password-entry" <?php bp_form_field_attributes('password'); ?> placeholder="<?php esc_attr_e('Change Password (leave blank for no change)', 'socialv'); ?>" />
			<label for="pass1"><?php esc_html_e('Change Password (leave blank for no change)', 'socialv'); ?></label>
		</div>
		<div id="pass-strength-result"></div>
		<div class="form-floating">
			<input type="password" name="pass2" id="pass2" class="form-control" size="16" value="" class="settings-input small password-entry-confirm" <?php bp_form_field_attributes('password'); ?> placeholder="<?php esc_attr_e('Repeat New Password', 'socialv'); ?>" />
			<label for="pass2"><?php esc_html_e('Repeat New Password', 'socialv'); ?></label>
		</div>
		<?php

		/**
		 * Fires before the display of the submit button for user general settings saving.
		 *
		 * @since 1.5.0
		 */
		do_action('bp_core_general_settings_before_submit'); ?>
		<div class="form-edit-btn">
			<div class="submit">
				<input type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'socialv'); ?>" id="submit" class="auto btn socialv-btn-success" />
			</div>
		</div>

		<?php
		/**
		 * Fires after the display of the submit button for user general settings saving.
		 *
		 * @since 1.5.0
		 */
		do_action('bp_core_general_settings_after_submit'); ?>

		<?php wp_nonce_field('bp_settings_general'); ?>

	</form>
</div>
<?php
do_action('bp_after_member_settings_template');
