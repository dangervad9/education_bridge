<?php

/**
 * BuddyPress - Users Profile
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use function SocialV\Utility\socialv;

$post_section = socialv()->post_style();
$user_id = bp_displayed_user_id();
$account_type = bp_get_user_meta($user_id, "socialv_user_account_type", true);
$logged_in_user_id = get_current_user_id();
socialv()->socialv_set_postviews($user_id);
?>
<?php if (bp_current_action() == 'public') :
	do_action('bp_before_member_home_content');
	do_action('socialv_before_members_content');
?>
<?php endif; ?>
<div class="container">
	<?php
	if (bp_current_action() == 'public') :
		do_action('socialv_after_members_content');
		do_action('socialv_members_content_before');
	endif;
	if (function_exists('friends_check_friendship') && !friends_check_friendship($logged_in_user_id, $user_id) && $user_id != $logged_in_user_id && $account_type == 'private') {
		do_action('socialv_user_private_content', $user_id);
	} else {
	?>
		<div id="item-body">

			<?php

			do_action('bp_before_profile_content'); ?>

			<div class="profile">
				<?php switch (bp_current_action()):

						// Edit
					case 'edit':
						bp_get_template_part('members/single/profile/edit');
						break;

						// Change Avatar
					case 'change-avatar':
						bp_get_template_part('members/single/profile/change-avatar');
						break;

						// Change Cover Image
					case 'change-cover-image':
						bp_get_template_part('members/single/profile/change-cover-image');
						break;

						// Compose
					case 'public':
						echo '<div class="row ' . esc_attr($post_section['row_reverse']) . '">';
						echo socialv()->socialv_the_layout_class();
						// Display XProfile
						if (bp_is_active('xprofile'))
							bp_get_template_part('members/single/profile/profile-loop');

						// Display WordPress profile (fallback)
						else
							bp_get_template_part('members/single/profile/profile-wp');

						echo socialv()->socialv_sidebar();
						echo '</div>';
						break;
						// Any other
					default:
						bp_get_template_part('members/single/plugins');
						break;
				endswitch; ?>

			</div><!-- .profile -->

			<?php

			/**
			 * Fires after the display of member profile content.
			 *
			 * @since 1.1.0
			 */
			do_action('bp_after_profile_content');

			/**
			 * Fires after the display of member body content.
			 *
			 * @since 1.2.0
			 */
			do_action('bp_after_member_body'); ?>

		</div><!-- #item-body -->
	<?php do_action('bp_after_member_home_content');
	} ?>
</div>