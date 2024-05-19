<?php

/**
 * Template for displaying checkout form.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/checkout/form.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.2
 */

defined('ABSPATH') || exit();

$checkout = LP()->checkout();

learn_press_print_messages();

if (!is_user_logged_in()) {
?>
	<div class="learn-press-message error">
		<?php esc_html_e('Please login to enroll the course!', 'socialv'); ?>
	</div>
<?php
}
?>

<form method="post" id="learn-press-checkout-form" name="learn-press-checkout-form" class="lp-checkout-form" tabindex="0" action="<?php echo esc_url_raw(learn_press_get_checkout_url()); ?>" enctype="multipart/form-data">
	<?php
	if (has_action('learn-press/before-checkout-form')) {
	?>
		<div class="lp-checkout-form__before">
			<div class="card-main">
				<div class="card-inner">
					<?php do_action('learn-press/before-checkout-form'); ?>
				</div>
			</div>
		</div>
	<?php
	}

	do_action('learn-press/checkout-form');

	if (has_action('learn-press/after-checkout-form')) {
	?>
		<div class="lp-checkout-form__after">
			<div class="card-main">
				<div class="card-inner">
					<div class="socialv-login-form">
						<?php do_action('learn-press/after-checkout-form'); ?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	?>
</form>

<?php
