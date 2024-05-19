<?php

/**
 * BuddyPress - Groups Home
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use function SocialV\Utility\socialv;

$post_section = socialv()->post_style();

$group_id = bp_get_group_id();

?>
<div id="buddypress">
	<?php if (bp_has_groups()) : while (bp_groups()) : bp_the_group(); ?>

			<?php
			/**
			 * Fires before the display of the group home content.
			 *
			 * @since 1.2.0
			 */
			do_action('bp_before_group_home_content'); ?>

			<div id="item-header" role="complementary">

				<?php bp_get_template_part('groups/single/cover-image-header'); ?>

			</div><!-- #item-header -->
			<div class="socialv-group-profile-box">
				<div class="card-main socialv-group-profile-box">
					<div class="card-inner">
						<div class="container">
							<div class="item-header-cover-image-wrapper">
								<div id="item-header-content" class="d-flex align-items-start justify-content-between m-0">
									<div class="socialv-group-left">
										<div class="d-flex align-items-start group-profile-details gap-4">
											<div class="header-avatar zoom-gallery">
												<?php if (is_user_logged_in()) {
													$is_member = groups_is_user_member(get_current_user_id(), bp_get_group_id());
													if (bp_get_group_status() == 'private' && !$is_member  && !bp_current_user_can('bp_moderate')) {
														echo bp_core_fetch_avatar(array('item_id'    => bp_get_group_id(), 'avatar_dir' => 'group-avatars', 'object'     => 'group', 'width'      => 150, 'height'     => 150, 'class' => 'rounded', 'type' => 'full'));
													} else { 
														$avatar_url = bp_core_fetch_avatar(
															array(
																'item_id' => $group_id,
																'object'  => 'group',
																'type'    => 'full',
																'html'    => false
															)
														);
														?>
														<a href="<?php echo esc_url($avatar_url); ?>" class="popup-zoom">
															<?php echo bp_core_fetch_avatar(array('item_id'    => bp_get_group_id(), 'avatar_dir' => 'group-avatars', 'object'     => 'group', 'width'      => 150, 'height'     => 150, 'class' => 'rounded', 'type' => 'full')); ?>
														</a>
												<?php }
												} else {
													echo bp_core_fetch_avatar(array('item_id'    => bp_get_group_id(), 'avatar_dir' => 'group-avatars', 'object'     => 'group', 'width'      => 150, 'height'     => 150, 'class' => 'rounded', 'type' => 'full'));
												} ?>
											</div><!-- #item-header-avatar -->
											<div class="avtar-details">
												<h5 class="group-name"><?php echo esc_html(bp_get_group_name()); ?></h5>
												<?php 
												do_action( 'bp_group_header_meta' );
												if (!empty(bp_get_group_description())) { ?>
													<div class="description-content hideContent">
														<?php bp_group_description(); ?>
													</div>
													<div class="show-more" style="display:none">
														<a href="javascript:void(0);" data-showmore="<?php echo esc_attr__('[More]', 'socialv'); ?>" data-showless="<?php echo esc_attr__('[Less]', 'socialv'); ?>"><?php echo esc_html__('[More]', 'socialv'); ?></a>
													</div>
												<?php } ?>
											</div>
										</div>
									</div>

									<div class="socialv-group-right">
										<ul class="socialv-user-meta list-inline">
											<li class="group-type">
												<?php bp_group_type(); ?>
											</li>
											<li>
												<h5><?php echo socialv()->socialv_group_posts_count(bp_get_group_id()); ?></h5> <?php echo ((socialv()->socialv_group_posts_count($group_id) == 1) ? esc_html__('Post', 'socialv') : esc_html__('Posts', 'socialv')); ?>
											</li>
											<li>
												<h5><?php echo bp_get_group_total_members(false); ?></h5> <?php echo ((bp_get_group_total_members(false) == 1) ? esc_html__('Member', 'socialv') : esc_html__('Members', 'socialv')); ?>
											</li>
										</ul>
										<div id="item-buttons" class="socialv-group-btn-action"><?php do_action('bp_group_header_actions'); ?></div>
									</div>
								</div><!-- #item-header-content -->
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="container">

				<div id="template-notices" class="card-space" role="alert" aria-atomic="true">
					<?php
					do_action('template_notices'); ?>

				</div>
				<div class="card-main card-space card-space-bottom">
					<div class="card-inner p-0">
						<div id="item-nav">
							<div class="item-list-tabs no-ajax socialv-tab-lists" id="object-nav" aria-label="<?php esc_attr_e('Group primary navigation', 'socialv'); ?>" role="navigation">
								<?php
								$bp = buddypress();
								$current_item = !empty($parent_slug) ? $parent_slug : bp_current_item();
								$group_tab = count($bp->{bp_current_component()}->nav->get_secondary(array('parent_slug' => $current_item)));
								if ($group_tab > 8) : ?>
									<div class="left" onclick="slide('left',event)"></div>
									<div class="right" onclick="slide('right',event)"></div>
								<?php endif; ?>
								<ul class="list-inline socialv-tab-container custom-nav-slider">
									<?php bp_get_options_nav(); ?>
								</ul>
							</div>
						</div><!-- #item-nav -->
					</div>
				</div>
				<div id="item-body">
					<?php
					echo '<div class="row ' . esc_attr($post_section['row_reverse']) . '">';
					echo socialv()->socialv_the_layout_class();
					/**
					 * Fires before the display of the group home body.
					 *
					 * @since 1.2.0
					 */
					do_action('bp_before_group_body');

					/**
					 * Does this next bit look familiar? If not, go check out WordPress's
					 * /wp-includes/template-loader.php file.
					 *
					 * @todo A real template hierarchy? Gasp!
					 */

					// Looking at home location
					if (bp_is_group_home()) :

						if (bp_group_is_visible()) {

							// Load appropriate front template
							bp_groups_front_template_part();
						} else {

							/**
							 * Fires before the display of the group status message.
							 *
							 * @since 1.1.0
							 */
							do_action('bp_before_group_status_message'); ?>

							<div id="message" class="info">
								<p><?php bp_group_status_message(); ?></p>
							</div>

					<?php

							/**
							 * Fires after the display of the group status message.
							 *
							 * @since 1.1.0
							 */
							do_action('bp_after_group_status_message');
						}

					// Not looking at home
					else :

						// Group Admin
						if (bp_is_group_admin_page()) : bp_get_template_part('groups/single/admin');

						// Group Activity
						elseif (bp_is_group_activity()) : bp_get_template_part('groups/single/activity');

						// Group Members
						elseif (bp_is_group_members()) : socialv()->socialv_bp_groups_members_template_part();

						// Group Invitations
						elseif (bp_is_group_invites()) :
							echo '<div class="card-main"><div class="card-inner">';
							bp_get_template_part('groups/single/send-invites');
							echo '</div></div>';

						// Membership request
						elseif (bp_is_group_membership_request()) : bp_get_template_part('groups/single/request-membership');

						// Anything else (plugins mostly)
						else : bp_get_template_part('groups/single/plugins');

						endif;

					endif;

					/**
					 * Fires after the display of the group home body.
					 *
					 * @since 1.2.0
					 */
					do_action('bp_after_group_body');
					echo socialv()->socialv_sidebar();
					echo '</div>';

					?>

				</div><!-- #item-body -->
			</div>
			<?php

			/**
			 * Fires after the display of the group home content.
			 *
			 * @since 1.2.0
			 */
			do_action('bp_after_group_home_content');
			socialv()->socialv_more_content_js();
			?>

	<?php endwhile;
	endif; ?>
</div><!-- #buddypress -->