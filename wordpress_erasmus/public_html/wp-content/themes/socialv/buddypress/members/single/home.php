<?php

/**
 * BuddyPress - Members Home
 *
 * @since   1.0.0
 * @version 3.0.0
 */

use function SocialV\Utility\socialv;

$post_section = socialv()->post_style();
$user_id = bp_displayed_user_id();
$account_type = bp_get_user_meta($user_id, "socialv_user_account_type", true);
$logged_in_user_id = get_current_user_id();
socialv()->socialv_set_postviews($user_id);
?>
<div id="buddypress">

	<?php
	if (bp_is_user_profile()) :
		bp_get_template_part('members/single/profile');

	elseif (bp_is_user_settings()) :
		bp_get_template_part('members/single/settings');
	else :

		do_action('bp_before_member_home_content');
		do_action('socialv_before_members_content');
	?>
		<div class="container">

			<?php do_action('socialv_after_members_content');
			if (function_exists('friends_check_friendship') &&  !friends_check_friendship($logged_in_user_id, $user_id) && $user_id != $logged_in_user_id && $account_type == 'private') {
				do_action('socialv_user_private_content', $user_id);
			} else {
				if (class_exists('BP_Better_Messages') && bp_current_action() == 'bp-messages') :
					echo '<div class="card-main card-space-bottom">
	<div class="card-inner pt-0 pb-0"></div></div>';
				else :
					do_action('socialv_members_content_before');
				endif;
			?>
				<div id="item-body">

					<?php
					if (class_exists('BP_Better_Messages') && bp_current_action() == 'bp-messages') :
					else :
						if (!bp_is_user_activity()) :
							echo '<div class="row ' . esc_attr($post_section['row_reverse']) . '">';
							echo socialv()->socialv_the_layout_class();
						endif;
					endif;
					/**
					 * Fires before the display of member body content.
					 *
					 * @since 1.2.0
					 */
					do_action('bp_before_member_body');


					if (bp_is_user_front()) :
						bp_displayed_user_front_template_part();

					elseif (bp_is_user_activity()) :
						bp_get_template_part('members/single/activity');

					elseif (bp_is_user_blogs()) :
						bp_get_template_part('members/single/blogs');

					elseif (bp_is_user_friends()) :
						bp_get_template_part('members/single/friends');

					elseif (bp_is_user_groups()) :
						bp_get_template_part('members/single/groups');

					elseif (bp_is_user_messages()) :
						bp_get_template_part('members/single/messages');

					elseif (bp_is_user_notifications()) :
						bp_get_template_part('members/single/notifications');

					elseif (bp_is_user_members_invitations()) :
						bp_get_template_part('members/single/invitations');
					// If nothing sticks, load a generic template
					else :
						bp_get_template_part('members/single/plugins');

					endif;

					/**
					 * Fires after the display of member body content.
					 *
					 * @since 1.2.0
					 */
					do_action('bp_after_member_body');

					if (class_exists('BP_Better_Messages') && bp_current_action() == 'bp-messages') :
					else :
						if (!bp_is_user_activity()) :
							echo socialv()->socialv_sidebar();
							echo '</div>';
						endif;
					endif;

					?>

				</div><!-- #item-body -->
			<?php
				do_action('bp_after_member_home_content');
			}
			?>
		</div>
	<?php

	endif; ?>
</div><!-- #buddypress -->