<?php

/**
 * Template for displaying log in form.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/checkout/form-login.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.1
 */

defined('ABSPATH') || exit();

if (is_user_logged_in()) {
	return;
}
?>

<input type="radio" id="checkout-account-switch-to-login" checked="checked" name="checkout-account-switch-form" value="login" />

<div id="checkout-account-login" class="lp-checkout-block left">
	<h4 class="socialv-wc-login-title socialv-info"><?php esc_html_e('Sign in', 'socialv'); ?></h4>
	<p class="login-username"><label for="username"><?php esc_html_e('Username or Email Address*', 'socialv'); ?></label>
	<div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Add-User icli"></i></span><input type="text" name="username" id="username" class="userform form-control" placeholder="<?php esc_attr_e('Email or username', 'socialv'); ?>" required autocomplete="username" /></div>
	</p>
	<p class="login-password"><label for="password"><?php esc_html_e('Password', 'socialv'); ?></label>
	<div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Lock icli"></i></span><input type="password" name="password" id="password" class="password form-control" placeholder="<?php esc_attr_e('Password', 'socialv'); ?>" autocomplete="current-password" required /></div>
	</p>

	<?php do_action('learn-press/after-checkout-account-login-fields'); ?>
	<input type="hidden" name="learn-press-checkout-nonce" value="<?php echo wp_create_nonce('learn-press-checkout-login'); ?>">

	<div class="d-flex flex-sm-row justify-content-between align-items-center">
		<p class="login-remember">
			<label>
				<input type="checkbox" name="rememberme" />
				<?php esc_html_e('Remember me', 'socialv'); ?>
			</label>
		</p>
		<a class="forgot-pwd" href="<?php echo esc_url_raw(wp_lostpassword_url()); ?>">
			<?php esc_html_e('Lost password?', 'socialv'); ?>
		</a>
	</div>

	<p class="text-center register-link">
		<?php if (LP()->checkout()->is_enable_register()) : ?>
			<?php esc_html_e('Don\'t have an account?', 'socialv'); ?>
			<a href="javascript: void(0);">
				<label for="checkout-account-switch-to-register"><?php echo esc_html_x('Sign up', 'checkout sign up link', 'socialv'); ?></label>
			</a>.
		<?php endif; ?>

		<?php learn_press_get_template('checkout/guest-checkout-link'); ?>
	</p>
</div>