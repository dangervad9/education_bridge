<?php

/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     7.1.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (is_user_logged_in()) {
	return;
}

?>
<form class="woocommerce-form woocommerce-form-login login" method="post">
	<div class="col-lg-6 mx-auto">
		<div class="card-main">
			<div class="card-inner">
				<div class="socialv-login-form">
					<?php do_action('woocommerce_login_form_start'); ?>
					<?php echo esc_html($message) ? wpautop(wptexturize($message)) : ''; ?>
					<p class="login-username mt-4"><label for="username"><?php esc_html_e('Username or Email Address*', 'socialv'); ?></label>
					<div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Add-User icli"></i></span><input type="text" required="" class="userform form-control" name="username" id="username" autocomplete="username" placeholder="<?php esc_attr_e('Username', 'socialv'); ?>" /></div>
					</p>
					<p class="login-password"><label for="password"><?php esc_html_e('Password*', 'socialv'); ?></label>
					<div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Lock icli"></i></span><input type="password" required="" name="password" id="password" autocomplete="current-password" class="password form-control" placeholder="<?php esc_attr_e('Password', 'socialv'); ?>" /></div>
					</p>

					<?php do_action('woocommerce_login_form'); ?>
					<div class="d-flex flex-sm-row justify-content-between align-items-center">
						<p class="login-remember"><label><input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e('Remember Me', 'socialv'); ?></label></p>
						<a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="forgot-pwd"><?php esc_html_e('Lost your password?', 'socialv'); ?></a>
					</div>
					<div class="clear"></div>

					<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
					<input type="hidden" name="redirect" value="<?php echo esc_url($redirect); ?>" />
					<p class="login-submit mb-0">
						<button type="submit" class="w-100 woocommerce-button socialv-button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="login" value="<?php esc_attr_e('Login', 'socialv'); ?>">
							<?php esc_html_e('Login', 'socialv'); ?>
						</button>
					</p>
					<?php do_action('woocommerce_login_form_end'); ?>
				</div>
			</div>
		</div>
	</div>
</form>