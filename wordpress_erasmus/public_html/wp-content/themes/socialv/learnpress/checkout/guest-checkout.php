<?php

/**
 * Template for displaying user email field which enable checkout as guest.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/checkout/guest-email.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.1
 */

defined('ABSPATH') || exit();

$checkout  = LP()->checkout();
$is_exists = $checkout->checkout_email_exists();
?>

<input type="radio" id="checkout-account-switch-to-guest" name="checkout-account-switch-form" value="guest" checked="checked" />

<div id="checkout-account-guest" class="lp-checkout-block <?php echo esc_attr($is_exists ? 'email-exists' : ''); ?>">
	<h4 class="socialv-wc-login-title socialv-info"><?php esc_html_e('As Guest', 'socialv'); ?></h4>
	<p class="reg-email"><label for="guest_email"><?php esc_html_e('Enter your email...', 'socialv'); ?></label>
	<div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Message icli"></i></span><input size="30" placeholder="<?php esc_attr_e('Enter your email...', 'socialv'); ?>" type="text" id="guest_email" class="form-control" name="guest_email" autocomplete="off" required /></div>
	</p>

	<ul class="lp-form-fields">
		<li class="form-field">
			<div class="lp-guest-checkout-notice">
				<?php esc_html_e('An order key to activate the course will be sent to your email after the payment proceeded successfully.', 'socialv'); ?>
			</div>
			<?php
			$signin  = '';
			$signup  = '';
			$divider = '';

			if (LP()->checkout()->is_enable_login()) {
				$signin = sprintf('<a href="javascript:void(0)"><label for="checkout-account-switch-to-login">%s</label></a>', esc_html(_x('Sign in', 'checkout sign in link', 'socialv')));
			}

			if (LP()->checkout()->is_enable_login() && LP()->checkout()->is_enable_register()) {
				$divider = ',';
			}

			if (LP()->checkout()->is_enable_register()) {
				$signup = sprintf('<a href="javascript:void(0)"><label for="checkout-account-switch-to-register">%s</label></a>', esc_html(_x('Sign up', 'checkout sign up link', 'socialv')));
			}
			?>

			<?php if (LP()->checkout()->is_enable_login() || LP()->checkout()->is_enable_register()) : ?>
				<div class="lp-guest-switch-login"><?php echo sprintf(__('Or you can %1$s%2$s %3$s now.', 'socialv'), $signin, $divider, $signup); ?></div>
			<?php endif; ?>
		</li>
	</ul>
	<input type="hidden" name="learn-press-checkout-nonce" value="<?php echo esc_attr(wp_create_nonce('learn-press-guest-checkout')); ?>" />
</div>