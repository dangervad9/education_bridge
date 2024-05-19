<?php

/**
 * BuddyPress - Members Friends Requests
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use function SocialV\Utility\socialv;

/**
 * Fires before the display of member friend requests content.
 *
 * @since 1.2.0
 */
$socialv_options = get_option('socialv-options');

do_action('bp_before_member_friend_requests_content'); ?>

<div class="card-head card-header-border d-flex align-items-center justify-content-between">
	<div class="head-title">
		<h5 class="card-title"><?php echo ((bp_friend_get_total_requests_count(bp_displayed_user_id()) == 1) ? esc_html__('Friend Request', 'socialv') : esc_html__('Friends Requests', 'socialv')); ?> <?php echo '(' . esc_html((bp_friend_get_total_requests_count(false) < 10) ? ('0' . bp_friend_get_total_requests_count(bp_displayed_user_id())) : bp_friend_get_total_requests_count(bp_displayed_user_id())) . ')';  ?></h5>
	</div>
</div>
<?php
$per_page = isset($socialv_options['default_post_per_page']) ? $socialv_options['default_post_per_page'] : 10;
if (bp_has_members('type=alphabetical&include=' . bp_get_friendship_requests() . '&per_page=' . ($per_page))) : ?>

	<ul id="friend-list" class="socialv-members-lists socialv-bp-main-box row list-inline">
		<?php while (bp_members()) : bp_the_member(); ?>
			<li id="friendship-<?php bp_friend_friendship_id(); ?>" class="item-entry col-12">
				<div class="socialv-member-info">
					<div class="socialv-member-main">
						<div class="socialv-member-left  item-avatar">
							<a href="<?php bp_member_link(); ?>"><?php bp_member_avatar(array('type'    => 'full', 'width' => 80, 'height' => 80, 'class' => 'rounded-circle')); ?></a>
						</div>
						<div class="socialv-member-center item-block">
							<div class="member-name">
								<h5 class="title">
									<a href="<?php bp_member_link(); ?>"><?php bp_member_name(); ?></a>
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
						<div class="request-btn d-block">
							<a class="accept btn btn-sm socialv-btn-success" href="<?php bp_friend_accept_request_link(); ?>"><?php esc_html_e('Accept', 'socialv'); ?></a> &nbsp;
							<a class="reject btn btn-sm socialv-btn-danger" href="<?php bp_friend_reject_request_link(); ?>"><?php esc_html_e('Reject', 'socialv'); ?></a>
							<?php do_action('bp_friend_requests_item_action'); ?>
						</div>

					</div>
				</div>
			</li>

		<?php endwhile; ?>
	</ul>
	<?php

	/**
	 * Fires and displays the member friend requests content.
	 *
	 * @since 1.1.0
	 */
	do_action('bp_friend_requests_content'); ?>
	<?php
	$total_member = bp_friend_get_total_requests_count();
	if ($total_member > $per_page) { ?>
		<div id="pag-bottom" class="socialv-bp-pagination">
			<div class="pagination-links" id="member-dir-pag-bottom">
				<?php bp_members_pagination_links(); ?>
			</div>
		</div>
	<?php } ?>
<?php else : ?>

	<div id="message" class="info">
		<p><?php esc_html_e('You have no pending friendship requests.', 'socialv'); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of member friend requests content.
 *
 * @since 1.2.0
 */
do_action('bp_after_member_friend_requests_content');
