<?php

/**
 * Template for displaying register form.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/checkout/form-register.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.1
 */

defined('ABSPATH') || exit();
?>

<input type="radio" id="checkout-account-switch-to-register" name="checkout-account-switch-form" checked="checked" value="register" />
<div id="checkout-account-register" class="checkout-account-switch-form lp-checkout-block left">
	<h4 class="socialv-wc-login-title socialv-info"><?php esc_html_e('Sign up', 'socialv'); ?></h4>
	<?php do_action('learn-press/before-form-register-fields'); ?>

	<p class="reg-email"><label for="reg_email"><?php esc_html_e('Email address', 'socialv'); ?>&nbsp;<span class="required">*</span></label>
	<div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Message icli"></i></span><input id="reg_email" class="form-control" name="reg_email" type="text" placeholder="<?php esc_attr_e('Email', 'socialv'); ?>" autocomplete="email" value="<?php echo esc_attr(LP_Helper::sanitize_params_submitted($_POST['reg_email'] ?? '')); ?>" required /></div>
	</p>
	<p class="reg-username"><label for="reg_username"><?php esc_html_e('Username', 'socialv'); ?>&nbsp;<span class="required">*</span></label>
	<div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Add-User icli"></i></span><input id="reg_username" class="form-control" name="reg_username" type="text" placeholder="<?php esc_attr_e('Username', 'socialv'); ?>" autocomplete="username" value="<?php echo esc_attr(LP_Helper::sanitize_params_submitted($_POST['reg_username'] ?? '')); ?>" required /></div>
	</p>
	<p class="reg-password"><label for="reg_password"><?php esc_html_e('Password', 'socialv'); ?>&nbsp;<span class="required">*</span></label>
	<div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Add-User icli"></i></span><input id="reg_password" class="form-control" name="reg_password" type="password" placeholder="<?php esc_attr_e('Password', 'socialv'); ?>" autocomplete="new-password" required /></div>
	</p>
	<p class="reg-password2"><label for="reg_password2"><?php esc_html_e('Confirm Password', 'socialv'); ?>&nbsp;<span class="required">*</span></label>
	<div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Add-User icli"></i></span><input id="reg_password2" class="form-control" name="reg_password2" type="password" placeholder="<?php esc_attr_e('Password', 'socialv'); ?>" autocomplete="off" required /></div>
	</p>
	<?php do_action('learn-press/after-form-register-fields'); ?>

	<?php wp_nonce_field('learn-press-checkout-register', 'learn-press-checkout-nonce'); ?>

	<p class="lp-checkout-sign-in-link">
		<?php if (LP()->checkout()->is_enable_login()) : ?>
			<?php esc_html_e('Already had an account?', 'socialv'); ?>
			<a href="javascript: void(0);">
				<label for="checkout-account-switch-to-login"><?php esc_html_e('Sign in', 'socialv'); ?></label>
			</a>.
		<?php endif; ?>

		<?php learn_press_get_template('checkout/guest-checkout-link'); ?>
	</p>

	<?php do_action('learn-press/after-checkout-form-register'); ?>
</div>