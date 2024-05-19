<?php

/**
 * BuddyPress - Members Single Group Invites
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use function SocialV\Utility\socialv;

/**
 * Fires before the display of member group invites content.
 *
 * @since 1.1.0
 */
do_action('bp_before_group_invites_content'); ?>

<?php if (bp_has_groups('type=invites&user_id=' . bp_loggedin_user_id())) : ?>

	<h2 class="bp-screen-reader-text"><?php
										/* translators: accessibility text */
										esc_html_e('Group invitations', 'socialv');
										?></h2>
	<div class="groups mygroups group-list">
		<div id="groups-list" class="invites socialv-groups-lists socialv-bp-main-box row">

			<?php while (bp_groups()) : bp_the_group(); ?>
				<div <?php bp_group_class(array('item-entry col-md-6 d-flex flex-column')); ?>>
					<div class="socialv-card socialv-group-info h-100">
						<div class="top-bg-image">
							<?php echo socialv()->socialv_group_banner_img(bp_get_group_id(), 'groups'); ?>
							<?php if (bp_get_group_status() == 'private') {
								echo '<div class="status"><i class="iconly-Lock icli"></i></div>';
							} ?>
						</div>
						<div class="text-center">
							<div class="group-header">
								<?php if (!bp_disable_group_avatar_uploads()) : ?>
									<div class="group-icon">
										<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar('width=50&height=50'); ?></a>
									</div>
								<?php endif; ?>
								<div class="group-name">
									<h5 class="title"><?php bp_group_link(); ?></h5>
								</div>
							</div>
							<div class="socialv-group-details d-inline-block">
								<ul class="list-inline">
									<li class="d-inline-block">
										<a href="<?php bp_group_permalink(); ?>"><span class="post-icon"><i class="iconly-Paper icli"></i></span><span class="item-number"><?php echo socialv()->socialv_group_posts_count(bp_get_group_id()); ?></span><span class="item-text"><?php echo ((socialv()->socialv_group_posts_count(bp_get_group_id()) == 1) ? esc_html__('Post', 'socialv') : esc_html__('Posts', 'socialv')); ?></span></a>
									</li>
									<li class="d-inline-block">
										<a href="<?php bp_group_permalink(); ?>">
											<span class="member-icon"><i class="iconly-User2 icli"></i></span>
											<span class="item-text">
												<?php
												echo ((bp_get_group_total_members(false) == 1) ? esc_html__('Member', 'socialv') : esc_html__('Members', 'socialv'));
												/* translators: %s: group members count */
												?>
											</span>

											<span class="item-number"><?php echo bp_get_group_total_members(false); ?></span>
										</a>
									</li>
								</ul>
							</div>
							<ul class="group-member member-thumb list-inline list-img-group">
								<?php
								$total_members = BP_Groups_Group::get_total_member_count(bp_get_group_id());
								if ($total_members == 1) {
									echo '<li><span>' . esc_html_e('No Members', 'socialv') . '</span></li>';
								} else {
									if (bp_group_has_members('group_id=' . bp_get_group_id() . '&per_page=4&exclude_admins_mods=false')) : ?>
										<?php while (bp_group_members()) : bp_group_the_member(); ?>
											<li><a href="<?php bp_member_permalink(); ?>"><?php bp_group_member_avatar_thumb(); ?></a></li>
										<?php endwhile; ?>
										<li><a href="<?php bp_group_permalink(); ?>"><i class="icon-add"></i></a></li>
								<?php endif;
								} ?>
							</ul>
							<?php
							do_action('bp_directory_groups_item');

							/**
							 * Fires inside the display of a member group invite item.
							 *
							 * @since 1.1.0
							 */
							do_action('bp_group_invites_item'); ?>

							<div class="group-button generic-button action">
								<a class="group-button accept btn socialv-btn-success" href="<?php bp_group_accept_invite_link(); ?>"><?php esc_html_e('Accept', 'socialv'); ?></a> &nbsp;
								<a class="group-button reject confirm btn socialv-btn-danger" href="<?php bp_group_reject_invite_link(); ?>"><?php esc_html_e('Reject', 'socialv'); ?></a>

								<?php

								/**
								 * Fires inside the member group item action markup.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_group_invites_item_action'); ?>

							</div>
						</div>
					</div>
				</div>

			<?php endwhile; ?>

		</div>
	</div>
<?php else : ?>

	<div id="message" class="info">
		<p><?php esc_html_e('You have no outstanding group invites.', 'socialv'); ?></p>
	</div>

<?php endif; ?>

<?php
/**
 * Fires after the display of member group invites content.
 *
 * @since 1.1.0
 */
do_action('bp_after_group_invites_content');
