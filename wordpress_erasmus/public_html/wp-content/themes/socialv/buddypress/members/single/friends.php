<?php

/**
 * BuddyPress - Users Friends
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>
<div class="card-main">
	<div class="card-inner pt-0 pb-0">
		<div class="row align-items-center" id="subnav" aria-label="<?php esc_attr_e('Member secondary navigation', 'socialv'); ?>" role="navigation">
			<?php if (is_user_logged_in()) : if (bp_displayed_user_id() == bp_loggedin_user_id()) : ?>
					<div class="col-md-7 col-xl-7 item-list-tabs no-ajax">
						<div class="socialv-subtab-lists">
							<div class="left" onclick="slide('left',event)">
								<i class="iconly-Arrow-Left-2 icli"></i>
							</div>
							<div class="right" onclick="slide('right',event)">
								<i class="iconly-Arrow-Right-2 icli"></i>
							</div>
							<div class="socialv-subtab-container custom-nav-slider">
								<ul class="list-inline m-0">
									<?php if (bp_is_my_profile()) bp_get_options_nav(); ?>
								</ul>
							</div>
						</div>
					</div>

			<?php endif;
			endif; ?>
			<div class="<?php echo esc_attr((bp_displayed_user_id() == bp_loggedin_user_id()) ? 'col-md-5 col-xl-5' : 'col-12 socialv-full-width'); ?> ">
				<ul class="list-inline m-0 select-two-container ">
					<?php if (!bp_is_current_action('requests')) : ?>

						<li id="members-order-select" class="last filter socialv-data-filter-by position-relative">
							<label for="members-friends"><?php esc_html_e('Order By:', 'socialv'); ?></label>
							<select id="members-friends">
								<option value="active"><?php esc_html_e('Last Active', 'socialv'); ?></option>
								<option value="newest"><?php esc_html_e('Newest Registered', 'socialv'); ?></option>
								<option value="alphabetical"><?php esc_html_e('Alphabetical', 'socialv'); ?></option>

								<?php

								/**
								 * Fires inside the members friends order options select input.
								 *
								 * @since 2.0.0
								 */
								do_action('bp_member_friends_order_options'); ?>

							</select>

						</li>

					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="card-main card-space">
	<div class="card-inner">
		<?php
		switch (bp_current_action()):
			case 'my-friends':

				/**
				 * Fires before the display of member friends content.
				 *
				 * @since 1.2.0
				 */
				do_action('bp_before_member_friends_content'); ?>

				<?php if (is_user_logged_in()) : ?>
					<h2 class="bp-screen-reader-text"><?php
														/* translators: accessibility text */
														esc_html_e('My friends', 'socialv');
														?></h2>
				<?php else : ?>
					<h2 class="bp-screen-reader-text"><?php
														/* translators: accessibility text */
														esc_html_e('Friends', 'socialv');
														?></h2>
				<?php endif ?>

				<div class="members friends">
					<?php bp_get_template_part('members/single/friends/friendships');  ?>
				</div><!-- .members.friends -->
		<?php

				/**
				 * Fires after the display of member friends content.
				 *
				 * @since 1.2.0
				 */
				do_action('bp_after_member_friends_content');
				break;

			case 'requests':
				bp_get_template_part('members/single/friends/requests');
				break;

				// Any other
			default:
				bp_get_template_part('members/single/plugins');
				break;
		endswitch;
		?>

	</div>
</div>