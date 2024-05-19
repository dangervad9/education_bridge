<?php

/**
 * User Login Form
 *
 * @package bbPress
 * @subpackage Theme
 */

use function SocialV\Utility\socialv;

// Exit if accessed directly
defined('ABSPATH') || exit;
?>
<div class="card-main socialv-bp-login">
	<div class="card-inner">
		<div class="socialv-login-form">
			<?php socialv()->get_shortcode_content("login"); ?>
			<form method="post" action="<?php bbp_wp_login_action(array('context' => 'login_post')); ?>" class="iqonic-login-form bbp-login-form">
				<div class="iqonic-result-msg"></div>
				<fieldset class="bbp-form-sv">
					<legend><?php esc_html_e('Log In', 'socialv'); ?></legend>

					<div class="bbp-username-sv login-username">
						<label for="user_login"><?php esc_html_e('Username', 'socialv'); ?>: </label>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1"><i class="iconly-Add-User icli"></i></span>
							<input class="form-control" placeholder="<?php esc_attr_e('Username', 'socialv'); ?>" type="text" name="log" value="<?php socialv()->get_default_login_user('marvin'); ?>" size="20" maxlength="100" id="user_login" autocomplete="off" />
						</div>
					</div>

					<div class="bbp-password-sv login-password">
						<label for="user_pass"><?php esc_html_e('Password', 'socialv'); ?>: </label>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon2"><i class="iconly-Lock icli"></i></span>
							<input class="form-control" placeholder="<?php esc_attr_e('Password', 'socialv'); ?>" type="password" name="pwd" value="<?php socialv()->get_default_login_user('marvin'); ?>" size="20" id="user_pass" autocomplete="off" />
						</div>
					</div>

					<div class="bbp-remember-me ">
						<input type="checkbox" name="rememberme" value="forever" <?php checked(bbp_get_sanitize_val('rememberme', 'checkbox')); ?> id="rememberme" />
						<label for="rememberme"><?php esc_html_e('Keep me signed in', 'socialv'); ?></label>
					</div>

					<?php do_action('login_form'); ?>

					<div class="bbp-submit-wrapper">

						<button type="submit" name="user-submit" id="user-submit" class="button submit user-submit socialv-button"><?php esc_html_e('Log In', 'socialv'); ?></button>

						<?php bbp_user_login_fields(); ?>

					</div>
					<input type="hidden" name="iq_form_type" value="login" />
					<?php if (class_exists('ReduxFramework')) {
						if (isset($element_nonce) && true == $element_nonce) { ?>
							<?php wp_nonce_field('socialv_ajax_login_action', 'socialv_ajax_login_page_nonce'); ?>
						<?php } else { ?>
							<?php wp_nonce_field('socialv_ajax_login_action', 'socialv_ajax_login_popup_nonce'); ?>
					<?php }
					} ?>
				</fieldset>
			</form>
		</div>
	</div>
</div>