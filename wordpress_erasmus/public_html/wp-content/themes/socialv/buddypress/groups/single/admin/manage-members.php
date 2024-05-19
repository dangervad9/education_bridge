<?php

/**
 * BuddyPress - Groups Admin - Manage Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

do_action('bp_before_group_manage_members_admin'); ?>

<div aria-live="polite" aria-relevant="all" aria-atomic="true">
	<div class="bp-widget group-members-list group-admins-list">
		<h4 class="section-header"><?php esc_html_e('Administrators', 'socialv'); ?></h4>

		<?php if (bp_group_has_members(array('per_page' => 15, 'group_role' => array('admin'), 'page_arg' => 'mlpage-admin'))) : ?>


			<ul id="admins-list" class="item-list">
				<?php while (bp_group_members()) : bp_group_the_member(); ?>
					<li>
						<div class="user-data">
							<div class="item-avatar">
								<?php bp_group_member_avatar_thumb('width=70&height=70&class=rounded&type=full'); ?>
							</div>

							<div class="item">
								<h6 class="item-title">
									<?php bp_group_member_link(); ?>
								</h6>
								<p class="joined item-meta">
									<?php bp_group_member_joined_since(); ?>
								</p>
								<?php

								/**
								 * Fires inside the item section of a member admin item in group management area.
								 *
								 * @since 1.1.0
								 * @since 2.7.0 Added $section parameter.
								 *
								 * @param $section Which list contains this item.
								 */
								do_action('bp_group_manage_members_admin_item', 'admins-list'); ?>
							</div>
						</div>
						<div class="action">
							<?php if (count(bp_group_admin_ids(false, 'array')) > 1) : ?>
								<a class="button confirm admin-demote-to-member" href="<?php bp_group_member_demote_link(); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php esc_attr_e('Demote to Member', 'socialv'); ?>"><i class="iconly-User2 icli"></i></a>
							<?php endif; ?>

							<?php

							/**
							 * Fires inside the action section of a member admin item in group management area.
							 *
							 * @since 2.7.0
							 *
							 * @param $section Which list contains this item.
							 */
							do_action('bp_group_manage_members_admin_actions', 'admins-list'); ?>
						</div>
					</li>
				<?php endwhile; ?>
			</ul>

			<?php if (bp_group_member_needs_pagination()) : ?>

				<div class="no-ajax socialv-bp-pagination">
					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>
				</div>

			<?php endif; ?>

		<?php else : ?>

			<div id="message" class="info">
				<p><?php esc_html_e('No group administrators were found.', 'socialv'); ?></p>
			</div>

		<?php endif; ?>
	</div>

	<div class="bp-widget group-members-list group-mods-list">
		<h4 class="section-header"><?php esc_html_e('Moderators', 'socialv'); ?></h4>

		<?php if (bp_group_has_members(array('per_page' => 15, 'group_role' => array('mod'), 'page_arg' => 'mlpage-mod'))) : ?>

			<ul id="mods-list" class="item-list">

				<?php while (bp_group_members()) : bp_group_the_member(); ?>
					<li>
						<div class="user-data">
							<div class="item-avatar">
								<?php bp_group_member_avatar_thumb('width=70&height=70&class=rounded&type=full'); ?>
							</div>

							<div class="item">
								<h6 class="item-title">
									<?php bp_group_member_link(); ?>
								</h6>
								<p class="joined item-meta">
									<?php bp_group_member_joined_since(); ?>
								</p>
								<?php

								/**
								 * Fires inside the item section of a member admin item in group management area.
								 *
								 * @since 1.1.0
								 * @since 2.7.0 Added $section parameter.
								 *
								 * @param $section Which list contains this item.
								 */
								do_action('bp_group_manage_members_admin_item', 'admins-list'); ?>
							</div>
						</div>

						<div class="action">
							<a href="<?php bp_group_member_promote_admin_link(); ?>" class="button confirm mod-promote-to-admin" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php esc_attr_e('Promote to Admin', 'socialv'); ?>"><i class="iconly-Profile icli"></i></a>
							<a class="button confirm mod-demote-to-member" href="<?php bp_group_member_demote_link(); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php esc_attr_e('Demote to Member', 'socialv'); ?>"><i class="iconly-User2 icli"></i></a>

							<?php

							/**
							 * Fires inside the action section of a member admin item in group management area.
							 *
							 * @since 2.7.0
							 *
							 * @param $section Which list contains this item.
							 */
							do_action('bp_group_manage_members_admin_actions', 'mods-list'); ?>

						</div>
					</li>
				<?php endwhile; ?>

			</ul>

			<?php if (bp_group_member_needs_pagination()) : ?>
				<div class="no-ajax socialv-bp-pagination">
					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>
				</div>

			<?php endif; ?>

		<?php else : ?>

			<div id="message" class="info">
				<p><?php esc_html_e('No group moderators were found.', 'socialv'); ?></p>
			</div>

		<?php endif; ?>
	</div>

	<div class="bp-widget group-members-list">
		<h4 class="section-header"><?php esc_html_e("Members", 'socialv'); ?></h4>

		<?php if (bp_group_has_members(array('per_page' => 15, 'exclude_banned' => 0))) : ?>

			<ul id="members-list" class="item-list" aria-live="assertive" aria-relevant="all">
				<?php while (bp_group_members()) : bp_group_the_member(); ?>

					<li class="<?php bp_group_member_css_class(); ?>">
						<div class="user-data">
							<div class="item-avatar">
								<?php bp_group_member_avatar_thumb('width=70&height=70&class=rounded&type=full'); ?>
							</div>

							<div class="item">
								<h6 class="item-title">
									<?php bp_group_member_link(); ?>
									<?php
									if (bp_get_group_member_is_banned()) {
										echo ' <span class="banned">';
										esc_html_e('(banned)', 'socialv');
										echo '</span>';
									} ?>
								</h6>
								<p class="joined item-meta">
									<?php bp_group_member_joined_since(); ?>
								</p>
								<?php

								/**
								 * Fires inside the item section of a member admin item in group management area.
								 *
								 * @since 1.1.0
								 * @since 2.7.0 Added $section parameter.
								 *
								 * @param $section Which list contains this item.
								 */
								do_action('bp_group_manage_members_admin_item', 'admins-list'); ?>
							</div>
						</div>

						<div class="action">
							<?php if (bp_get_group_member_is_banned()) : ?>

								<a href="<?php bp_group_member_unban_link(); ?>" class="button confirm member-unban" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php esc_attr_e('Remove Ban', 'socialv'); ?>"><i class="icon-ban"></i></a>

							<?php else : ?>

								<a href="<?php bp_group_member_ban_link(); ?>" class="button confirm member-ban" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php esc_attr_e('Kick &amp; Ban', 'socialv'); ?>"><i class="icon-ban"></i></a>
								<a href="<?php bp_group_member_promote_mod_link(); ?>" class="button confirm member-promote-to-mod" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php esc_attr_e('Promote to Mod', 'socialv'); ?>"><i class="icon-moderator"></i></a>
								<a href="<?php bp_group_member_promote_admin_link(); ?>" class="button confirm member-promote-to-admin" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php esc_attr_e('Promote to Admin', 'socialv'); ?>"><i class="iconly-Profile icli"></i></a>

							<?php endif; ?>

							<a href="<?php bp_group_member_remove_link(); ?>" class="button confirm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php esc_attr_e('Remove from group', 'socialv'); ?>"><i class="iconly-Delete icli"></i></a>

							<?php

							/**
							 * Fires inside the action section of a member admin item in group management area.
							 *
							 * @since 2.7.0
							 *
							 * @param $section Which list contains this item.
							 */
							do_action('bp_group_manage_members_admin_actions', 'members-list'); ?>
						</div>
					</li>

				<?php endwhile; ?>
			</ul>

			<?php if (bp_group_member_needs_pagination()) : ?>
				<div class="no-ajax socialv-bp-pagination">
					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>
				</div>
			<?php endif; ?>

		<?php else : ?>

			<div id="message" class="info">
				<p><?php esc_html_e('No group members were found.', 'socialv'); ?></p>
			</div>

		<?php endif; ?>
	</div>

</div>

<?php

/**
 * Fires after the group manage members admin display.
 *
 * @since 1.1.0
 */
do_action('bp_after_group_manage_members_admin');
