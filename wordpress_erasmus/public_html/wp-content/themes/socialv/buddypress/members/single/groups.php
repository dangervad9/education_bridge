<?php

/**
 * BuddyPress - Users Groups
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>
<div class="card-main socialv-search-main">
	<div class="card-inner pt-0 pb-0">
		<div id="subnav" >
			<div class="row align-items-center">
				<?php if (is_user_logged_in()) : if (bp_displayed_user_id() == bp_loggedin_user_id()) : ?>
						<div class="col-xl-7 col-md-7 item-list-tabs no-ajax">
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
				<div class="<?php echo esc_attr((bp_displayed_user_id() == bp_loggedin_user_id()) ? 'col-xl-5 col-md-5' : 'col-12 socialv-full-width'); ?> socialv-product-view-buttons">
					<div class="socialv-group-filter">
						<ul class="list-inline m-0 position-relative">

							<?php if (!bp_is_current_action('invites')) : ?>

								<li id="groups-order-select" class="last filter socialv-data-filter-by">

									<label for="groups-order-by"><?php esc_html_e('Order By:', 'socialv'); ?></label>
									<select id="groups-order-by">
										<option value="active"><?php esc_html_e('Last Active', 'socialv'); ?></option>
										<option value="popular"><?php esc_html_e('Most Members', 'socialv'); ?></option>
										<option value="newest"><?php esc_html_e('Newly Created', 'socialv'); ?></option>
										<option value="alphabetical"><?php esc_html_e('Alphabetical', 'socialv'); ?></option>

										<?php

										/**
										 * Fires inside the members group order options select input.
										 *
										 * @since 1.2.0
										 */
										do_action('bp_member_group_order_options'); ?>

									</select>
								</li>

							<?php endif; ?>

						</ul>
					</div>
				</div>
			</div>

		</div><!-- .item-list-tabs -->
	</div>
</div>
<div class="card-main">
	<div class="card-inner">
		<?php

		switch (bp_current_action()):

				// Home/My Groups
			case 'my-groups':

				/**
				 * Fires before the display of member groups content.
				 *
				 * @since 1.2.0
				 */
				do_action('bp_before_member_groups_content'); ?>

				<?php if (is_user_logged_in()) : ?>
					<h2 class="bp-screen-reader-text"><?php
														/* translators: accessibility text */
														esc_html_e('My groups', 'socialv');
														?></h2>
				<?php else : ?>
					<h2 class="bp-screen-reader-text"><?php
														/* translators: accessibility text */
														esc_html_e('Member\'s groups', 'socialv');
														?></h2>
				<?php endif; ?>

				<div class="groups mygroups group-list grid-view">

					<?php bp_get_template_part('groups/groups-loop'); ?>

				</div>

		<?php

				/**
				 * Fires after the display of member groups content.
				 *
				 * @since 1.2.0
				 */
				do_action('bp_after_member_groups_content');
				break;

				// Group Invitations
			case 'invites':
				bp_get_template_part('members/single/groups/invites');
				break;

				// Any other
			default:
				bp_get_template_part('members/single/plugins');
				break;
		endswitch;
		?>
	</div>
</div>