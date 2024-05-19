<?php

/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires before the display of the members loop.
 *
 * @since 1.2.0
 */

use function SocialV\Utility\socialv;

$socialv_options = get_option('socialv-options');
do_action('bp_before_members_loop'); ?>
<div class="card-head card-header-border d-flex align-items-center justify-content-between">
	<div class="head-title">
		<h5 class="card-title"><?php echo ((bp_get_total_friend_count(bp_displayed_user_id()) == 1) ? esc_html__('Friend', 'socialv') : esc_html__('Friends', 'socialv')); ?> <?php echo '(' . esc_html((bp_get_total_friend_count() < 10) ? ('0' . bp_get_total_friend_count(bp_displayed_user_id())) : bp_get_total_friend_count(bp_displayed_user_id())) . ')';  ?></h5>
	</div>
</div>
<?php if (bp_get_current_member_type()) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message() ?></p>
<?php endif; ?>

<?php
$per_page = isset($socialv_options['default_post_per_page']) ? $socialv_options['default_post_per_page'] : 10;
if (bp_has_members(bp_ajax_querystring('members') . '&per_page=' . ($per_page))) : ?>

	<?php
	/**
	 * Fires before the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action('bp_before_directory_members_list'); ?>

	<div id="members-list" class="socialv-members-lists socialv-bp-main-box row">

		<?php while (bp_members()) : bp_the_member(); ?>

			<div <?php bp_member_class(['item-entry col-12']); ?>>
				<div class="socialv-member-info">
					<div class="socialv-member-main">
						<div class="socialv-member-left  item-avatar">
							<a href="<?php bp_member_link(); ?>"><?php bp_member_avatar(array('type'    => 'full', 'width' => 80, 'height' => 80, 'class' => 'rounded-circle')); ?></a>
						</div>
						<div class="socialv-member-center item-block">
							<div class="member-name">
								<h5 class="title">
									<a href="<?php bp_member_link(); ?>"><?php bp_member_name(); ?></a>
									<?php if (class_exists("BP_Verified_Member"))
										echo socialv()->socialv_get_verified_badge(bp_get_member_user_id());
									?>
								</h5>
							</div>
							<div class="socialv-member-info-top">
								<span class="bp-member-nickname">@<?php echo bp_get_member_user_login(); ?></span>
							</div>
							<?php do_action('bp_friend_requests_item'); ?>
						</div>
					</div>
					<div class="socialv-member-right">
						<span class="socialv-e-last-activity" data-livestamp="<?php bp_core_iso8601_date(bp_get_member_last_active(array('relative' => false))); ?>"><?php bp_member_last_active(); ?></span>
						<?php do_action('bp_directory_members_actions'); ?>
					</div>

				</div>
			</div>

		<?php endwhile; ?>

	</div>

	<?php

	/**
	 * Fires after the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action('bp_after_directory_members_list'); ?>

	<?php bp_member_hidden_fields(); ?>
	<?php
	$total_member = bp_get_total_friend_count();
	if ($total_member > $per_page) { ?>
		<div id="pag-bottom" class="socialv-bp-pagination">
			<div class="pagination-links" id="member-dir-pag-bottom">
				<?php bp_members_pagination_links(); ?>
			</div>
		</div>
	<?php } ?>

<?php else : ?>

	<div id="message" class="info">
		<p><?php esc_html_e("Sorry, no members were found.", 'socialv'); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of the members loop.
 *
 * @since 1.2.0
 */
do_action('bp_after_members_loop');
