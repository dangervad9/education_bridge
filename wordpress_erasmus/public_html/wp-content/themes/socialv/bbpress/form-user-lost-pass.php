<?php

/**
 * User Lost Password Form
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
			<?php socialv()->get_shortcode_content("forgetpwd"); ?>
			<form method="post" action="<?php bbp_wp_login_action(array('action' => 'lostpassword', 'context' => 'login_post')); ?>" class="bbp-login-form">
				<fieldset class="bbp-form">
					<legend><?php esc_html_e('Lost Password', 'socialv'); ?></legend>

					<div class="bbp-username">
						<p>
							<label for="user_login" class="hide"><?php esc_html_e('Username or Email', 'socialv'); ?>: </label>
							<input type="text" name="user_login" value="" size="20" id="user_login" maxlength="100" autocomplete="off" />
						</p>
					</div>

					<?php do_action('login_form', 'resetpass'); ?>

					<div class="bbp-submit-wrapper">

						<button type="submit" name="user-submit" class="button submit user-submit"><?php esc_html_e('Reset My Password', 'socialv'); ?></button>

						<?php bbp_user_lost_pass_fields(); ?>

					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>