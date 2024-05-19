<?php

/**
 * BuddyPress - Members Settings Notifications
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

do_action('bp_before_member_settings_template'); ?>


<div class="card-inner">
	<div id="template-notices" role="alert" aria-atomic="true">
		<?php do_action('template_notices'); ?>
	</div>
	<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/notifications'; ?>" method="post" id="settings-form">
		<div class="card-head card-header-border d-flex align-items-center justify-content-between">
			<div class="head-title">
				<h4 class="card-title"><?php esc_html_e('Notification settings', 'socialv'); ?></h4>
			</div>
		</div>
		<div class="notification-settings">
			<ul class="list-inline m-0">
				<?php do_action('bp_notification_settings'); ?>
			</ul>
		</div>

		<?php do_action('bp_members_notification_settings_before_submit'); ?>
		<div class="form-edit-btn">
			<div class="submit">
				<input type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'socialv'); ?>" id="submit" class="auto btn socialv-btn-success" />
			</div>
		</div>


		<?php do_action('bp_members_notification_settings_after_submit'); ?>

		<?php wp_nonce_field('bp_settings_notifications'); ?>

	</form>
	<?php
	?>
</div>