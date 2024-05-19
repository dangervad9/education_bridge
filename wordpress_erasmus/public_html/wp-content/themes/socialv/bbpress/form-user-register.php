<?php

/**
 * User Registration Form
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
			<?php socialv()->get_shortcode_content("register"); ?>
			<form method="post" action="<?php bbp_wp_login_action(array('context' => 'login_post')); ?>" class="bbp-login-form">

				<fieldset class="bbp-form">
					<legend><?php esc_html_e('Create an Account', 'socialv'); ?></legend>

					<?php do_action('bbp_template_before_register_fields'); ?>


					<div class="socialv-alert socialv-alert-info">
						<ul>
							<li><?php esc_html_e('Your username must be unique, and cannot be changed later.','socialv'); ?></li>
							<li><?php esc_html_e('We use your email address to email you a secure password and verify your account.', 'socialv'); ?></li>
						</ul>
					</div>

					<div class="bbp-username login-username">
						<label for="user_login"><?php esc_html_e('Username', 'socialv'); ?>: </label>
						<div class="input-group mb-3">
							<span class="input-group-text"><i class="iconly-Add-User icli"></i></span>
							<input class="form-control" placeholder="<?php esc_attr_e('Username', 'socialv'); ?>" required type="text" name="user_login" value="<?php bbp_sanitize_val('user_login'); ?>"    size="20" id="user_login" maxlength="100" autocomplete="off" />
						</div>
					</div>

					<div class="bbp-email email-username">
						<label for="user_email"><?php esc_html_e('Email', 'socialv'); ?>: </label>
						<div class="input-group mb-3">
							<span class="input-group-text"><i class="iconly-Message icli"></i></span>
							<input class="form-control" placeholder="<?php esc_attr_e('Email', 'socialv'); ?>" required type="text" name="user_email" value="<?php bbp_sanitize_val('user_email'); ?>" size="20" id="user_email" maxlength="100" autocomplete="off" />
						</div>
					</div>

					<?php do_action('register_form'); ?>

					<div class="bbp-submit-wrapper">

						<button type="submit" name="user-submit" class="button submit user-submit socialv-button"><?php esc_html_e('Register', 'socialv'); ?></button>

						<?php bbp_user_register_fields(); ?>

					</div>

					<?php do_action('bbp_template_after_register_fields'); ?>

				</fieldset>
			</form>
		</div>
	</div>
</div>