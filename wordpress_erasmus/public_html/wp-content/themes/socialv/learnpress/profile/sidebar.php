<?php

/**
 * Template for displaying sidebar in user profile.
 *
 * @author ThimPress
 * @package LearnPress/Templates
 * @version 4.0.1
 */

defined('ABSPATH') || exit;
?><aside id="profile-sidebar">

	<div class="lp-content-area lp-profile-content-area">
		<?php do_action('learn-press/user-profile-account'); ?>
	</div>
	<?php learn_press_get_template('profile/socials.php'); ?>
	<?php do_action('learn-press/user-profile-tabs'); ?>

</aside>