<?php

/**
 * BuddyPress - Members Settings Data
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 4.0.0
 */

do_action('bp_before_member_settings_template'); ?>


<div class="card-inner socialv-export-data">
	<div class="card-head card-header-border d-flex align-items-center justify-content-between">
		<div class="head-title">
			<h4 class="card-title"><?php esc_html_e('Data Export', 'socialv'); ?></h4>
		</div>
	</div>
	<?php $request = bp_settings_get_personal_data_request(); ?>

	<?php if ($request) : ?>

		<?php if ('request-completed' === $request->status) : ?>

			<?php if (bp_settings_personal_data_export_exists($request)) : ?>

				<p><?php esc_html_e('Your request for an export of personal data has been completed.', 'socialv'); ?></p>
				<p>
					<?php
					printf(esc_html__('You may download your personal data by clicking on the link below. For privacy and security, we will automatically delete the file on %s, so please download it before then.', 'socialv'), bp_settings_get_personal_data_expiration_date($request));
					?>
				</p>

				<p><strong><?php printf('<a href="%1$s">%2$s</a>', bp_settings_get_personal_data_export_url($request), esc_html__('Download personal data', 'socialv')); ?></strong></p>

			<?php else : ?>

				<p><?php esc_html_e('Your previous request for an export of personal data has expired.', 'socialv'); ?></p>
				<p><?php esc_html_e('Please click on the button below to make a new request.', 'socialv'); ?></p>

				<form id="bp-data-export" method="post" class="text-end">
						<input type="hidden" name="bp-data-export-delete-request-nonce" value="<?php echo wp_create_nonce('bp-data-export-delete-request'); ?>" />
						<button type="submit" name="bp-data-export-nonce" class="socialv-button" value="<?php echo wp_create_nonce('bp-data-export'); ?>"><?php esc_html_e('Request new data export', 'socialv'); ?></button>
				</form>

			<?php endif; ?>

		<?php elseif ('request-confirmed' === $request->status) : ?>

			<p>
				<?php
				/* translators: %s: confirmation date */
				printf(esc_html__('You previously requested an export of your personal data on %s.', 'socialv'), bp_settings_get_personal_data_confirmation_date($request));
				?>
			</p>
			<p><?php esc_html_e('You will receive a link to download your export via email once we are able to fulfill your request.', 'socialv'); ?></p>

		<?php endif; ?>

	<?php else : ?>

		<p><?php esc_html_e('You can request an export of your personal data, containing the following items if applicable:', 'socialv'); ?></p>

		<?php bp_settings_data_exporter_items(); ?>

		<p><?php esc_html_e('If you want to make a request, please click on the button below:', 'socialv'); ?></p>

		<form id="bp-data-export" method="post" class="text-end">
			<button type="submit" name="bp-data-export-nonce" class="socialv-button" value="<?php echo wp_create_nonce('bp-data-export'); ?>"><?php esc_html_e('Request personal data export', 'socialv'); ?></button>
		</form>

	<?php endif; ?>

</div>
<?php

do_action('bp_after_member_settings_template');
