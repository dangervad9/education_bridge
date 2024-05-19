<?php

/**
 * Template for displaying editing basic information form of user in profile page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/settings/tabs/basic-information.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.1
 */

defined('ABSPATH') || exit();

$profile = LP_Profile::instance();

if (!isset($section)) {
	$section = 'basic-information';
}

$user = $profile->get_user();
?>

<form method="post" id="learn-press-profile-basic-information" name="profile-basic-information" enctype="multipart/form-data" class="learn-press-form">

	<?php do_action('learn-press/before-profile-basic-information-fields', $profile); ?>

	<ul class="form-fields">

		<?php do_action('learn-press/begin-profile-basic-information-fields', $profile); ?>
		<li class="form-field form-field__first-name form-field__50 form-floating">
			<input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($user->get_data('first_name')); ?>" class="regular-text form-control" placeholder="<?php esc_attr_e('First name', 'socialv'); ?>">
			<label for="first_name"><?php esc_html_e('First name', 'socialv'); ?></label>
		</li>
		<li class="form-field form-field__last-name form-field__50 form-floating">
			<input type="text" name="last_name" id="last_name" value="<?php echo esc_attr($user->get_data('last_name')); ?>" class="regular-text form-control" placeholder="<?php esc_attr_e('Last name', 'socialv'); ?>">
			<label for="last_name"><?php esc_html_e('Last name', 'socialv'); ?></label>
		</li>
		<li class="form-field form-field__last-name form-field__50 form-floating">
			<input type="text" name="account_display_name" id="account_display_name" required value="<?php echo esc_attr($user->get_data('display_name')); ?>" class="regular-text form-control" placeholder="<?php esc_attr_e('Display name', 'socialv'); ?>">
			<label for="account_display_name"><?php esc_html_e('Display name', 'socialv'); ?><span class="required">*</span></label>
		</li>
		<li class="form-field form-field__last-name form-field__50 form-floating">
			<input type="email" name="account_email" id="account_email" required value="<?php echo esc_attr($user->get_data('email')); ?>" class="regular-text form-control" placeholder="<?php esc_attr_e('Email address', 'socialv'); ?>">
			<label for="account_email"><?php esc_html_e('Email address', 'socialv'); ?><span class="required">*</span></label>
		</li>

		<li class="form-field form-field__bio form-field__clear form-floating">
			<textarea name="description" id="description" rows="5" cols="30" class="form-control" placeholder="<?php esc_attr_e('Biographical Info', 'socialv'); ?>"><?php echo esc_html($user->get_data('description')); ?></textarea>
			<label for="description"><?php esc_html_e('Biographical Info', 'socialv'); ?></label>
			<div class="form-field-input">
				<p class="description"><?php esc_html_e('Share a little biographical information to fill out your profile. This may be shown publicly.', 'socialv'); ?></p>
			</div>
		</li>

		<?php
		$custom_profile = lp_get_user_custom_register_fields($user->ID);
		$custom_fields  = LP_Settings::instance()->get('register_profile_fields');

		if ($custom_fields) {
			foreach ($custom_fields as $field) {
		?>
				<li class="form-field form-field__<?php echo esc_attr($field['id']); ?> form-field__clear form-floating">
					<?php
					switch ($field['type']) {
						case 'text':
						case 'number':
						case 'email':
						case 'url':
						case 'tel':
					?>
							<input name="_lp_custom_register[<?php echo esc_attr($field['id']); ?>]" type="<?php echo esc_attr($field['type']); ?>" class="regular-text form-control" value="<?php echo esc_attr($custom_profile[$field['id']] ?? ''); ?>" placeholder="<?php echo esc_attr($field['name']); ?>">
							<label for="_lp_custom_register[<?php echo esc_attr($field['id']); ?>]"><?php echo esc_html($field['name']); ?></label>
						<?php
							break;
						case 'textarea':
						?>
							<textarea name="_lp_custom_register[<?php echo esc_attr($field['id']); ?>]" class="form-control" placeholder="<?php echo esc_attr($field['name']); ?>"><?php echo isset($custom_profile[$field['id']]) ? esc_textarea($custom_profile[$field['id']]) : ''; ?></textarea>
							<label for="_lp_custom_register[<?php echo esc_attr($field['id']); ?>]"><?php echo esc_html($field['name']); ?></label>
						<?php
							break;
						case 'checkbox':
						?>
							<label>
								<input name="_lp_custom_register[<?php echo esc_attr($field['id']); ?>]" type="<?php echo esc_attr($field['type']); ?>" value="1" <?php echo isset($custom_profile[$field['id']]) ? checked($custom_profile[$field['id']], 1) : ''; ?>>
								<?php echo esc_html($field['name']); ?>
							</label>
					<?php
							break;
					}
					?>
				</li>
			<?php
			}
		}

		// Social button.
		$socials = learn_press_get_user_extra_profile_info($user->get_id());
		if ($socials) {
			foreach ($socials as $k => $v) {
				if (!learn_press_is_social_profile($k)) {
					continue;
				}
			?>

				<li class="form-field form-field__profile-social form-field__50 form-field__<?php echo esc_attr($k); ?> form-floating">
					<input type="text" value="<?php echo esc_attr($v); ?>" name="user_profile_social[<?php echo esc_attr($k); ?>]" class="form-control" placeholder="<?php echo learn_press_social_profile_name($k); ?>">
					<label for="user_profile_social[<?php echo esc_attr($k); ?>]"><?php echo learn_press_social_profile_name($k); ?></label>
				</li>
		<?php
			}
		}
		?>

		<?php do_action('learn-press/end-profile-basic-information-fields', $profile); ?>
	</ul>

	<?php do_action('learn-press/after-profile-basic-information-fields', $profile); ?>

	<p>
		<input type="hidden" name="save-profile-basic-information" value="<?php echo wp_create_nonce('learn-press-save-profile-basic-information'); ?>" />
	</p>

	<button type="submit" name="submit"><?php esc_html_e('Save changes', 'socialv'); ?></button>

</form>