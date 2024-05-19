<?php

/**
 * BuddyPress - Groups Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */
$socialv_options = get_option('socialv-options');
?>

<?php
$per_page = isset($socialv_options['default_post_per_page']) ? $socialv_options['default_post_per_page'] : 10;
if (bp_group_has_members(bp_ajax_querystring('group_members') . '&per_page=' . ($per_page))) :  ?>
	<div class="card-head card-header-border d-flex align-items-center justify-content-between">
		<div class="head-title">
			<h5 class="card-title"><?php echo ((bp_get_group_total_members(false) == 1) ? esc_html__('Member', 'socialv') : esc_html__('Members', 'socialv')); ?> <?php echo '(' . esc_html((bp_get_group_total_members(false) < 10) ? ('0' . bp_get_group_total_members(false)) : bp_get_group_total_members(false)) . ')';  ?></h5>
		</div>
	</div>

	<?php
	/**
	 * Fires before the display of the group members content.
	 *
	 * @since 1.1.0
	 */
	do_action('bp_before_group_members_content'); ?>

	<?php

	/**
	 * Fires before the display of the group members list.
	 *
	 * @since 1.1.0
	 */
	do_action('bp_before_group_members_list'); ?>

	<div id="members-list" class="socialv-members-lists socialv-bp-main-box row">

		<?php while (bp_group_members()) : bp_group_the_member(); ?>

			<div class="item-entry col-12">
				<div class="socialv-member-info">
					<div class="socialv-member-main">
						<div class="socialv-member-left  item-avatar">
							<a href="<?php bp_group_member_domain(); ?>">
								<?php bp_group_member_avatar_thumb('width=70&height=70&class=rounded-circle&type=full'); ?>
							</a>
						</div>
						<div class="socialv-member-center item-block">
							<div class="member-name">
								<h5 class="title">
									<?php bp_group_member_link(); ?>
								</h5>
							</div>
							<div class="socialv-member-info-top">
								<span class="bp-member-nickname">@<?php echo bp_get_member_user_login(); ?></span>
							</div>
						</div>
					</div>
					<div class="socialv-member-right">
						<?php do_action('bp_group_members_list_item'); ?>
						<?php if (bp_is_active('friends')) : ?>

							<div class="action">
								<?php bp_add_friend_button(bp_get_group_member_id(), bp_get_group_member_is_friend()); ?>
								<?php do_action('bp_group_members_list_item_action'); ?>
							</div>

						<?php endif; ?>
					</div>
				</div>
			</div>

		<?php endwhile; ?>

	</div>
	<?php

	/**
	 * Fires after the display of the group members list.
	 *
	 * @since 1.1.0
	 */
	do_action('bp_after_group_members_list'); ?>

	<?php
	$total_member = bp_get_group_total_members();
	if ($total_member > $per_page) { ?>
		<div id="pag-bottom" class="socialv-bp-pagination">
			<div class="pagination-links" id="member-pag-bottom">
				<?php bp_members_pagination_links(); ?>
			</div>
		</div>
	<?php } ?>
	<?php

	/**
	 * Fires after the display of the group members content.
	 *
	 * @since 1.1.0
	 */
	do_action('bp_after_group_members_content'); ?>

<?php else : ?>

	<div id="message" class="info">
		<p><?php esc_html_e('No members were found.', 'socialv'); ?></p>
	</div>

<?php endif;
