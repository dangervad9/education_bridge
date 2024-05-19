<?php

/**
 * Template part for displaying the Friends Request
 *
 * @package socialv
 */

?>

<div class="dropdown dropdown-friend">
	<button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
		<i class="iconly-User2 icli" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php esc_attr_e('Friend Requests', 'socialv'); ?>"></i>
		<?php if (function_exists('bp_friend_get_total_requests_count') && bp_friend_get_total_requests_count(bp_loggedin_user_id()) > 0) { ?>
			<span id="notify-count" class="notify-count"><?php echo esc_html((bp_friend_get_total_requests_count(bp_loggedin_user_id()) > 9) ? '9+' : (bp_friend_get_total_requests_count(bp_loggedin_user_id()))); ?></span>
		<?php } ?>
	</button>
	<div class="dropdown-menu dropdown-menu-right">
		<div class="item-heading">
			<h5 class="heading-title"><?php esc_html_e('Friend Requests', 'socialv'); ?></h5>
		</div>
		<?php if (function_exists('bp_get_friendship_requests')) :  if (bp_has_members('type=alphabetical&include=' . bp_get_friendship_requests(bp_loggedin_user_id()))) : ?>
				<div class="item-body">
					<?php while (bp_members()) : bp_the_member(); ?>
						<div class="d-flex socialv-notification-box socialv-friend-request">
							<div class="item-img">
								<div class="item-img">
									<a href="<?php bp_member_link(); ?>">
										<?php echo bp_core_fetch_avatar(array(
											'item_id' => bp_get_member_user_id(),
											'type'    => 'thumb',
											'class' => 'avatar rounded-circle',
											'width'         => 32,
											'height'        => 32,
										)); ?>
									</a>
								</div>
							</div>
							<div class="flex-grow-1 d-flex justify-content-between item-details ms-3">
								<div class="item-detail-data">
									<h6 class="item-title"><a href="<?php bp_member_link(); ?>"><?php bp_member_name(); ?></a></h6>
									<p class="m-0 item-time response"><?php bp_member_last_active(); ?></p>
								</div>
								<div class="request-button">
									<?php $friendship_id = friends_get_friendship_id(bp_get_member_user_id(), bp_loggedin_user_id()); ?>
									<a class="btn socialv-btn-outline-primary socialv-friendship-btn item-btn accept" data-friendship-id="<?php echo esc_attr($friendship_id); ?>" href="<?php bp_friend_accept_request_link(); ?>"><i class="icon-check" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php esc_attr_e('Accept', 'socialv'); ?>"></i></a>
									<a class="btn socialv-btn-outline-danger socialv-friendship-btn socialv-button-light item-btn reject" data-friendship-id="<?php echo esc_attr($friendship_id); ?>" href="<?php bp_friend_reject_request_link(); ?>"><i class="icon-close-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php esc_attr_e('Remove', 'socialv'); ?>"></i></a>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
				<div class="item-footer">
					<a href="<?php echo bp_loggedin_user_domain() . 'friends/requests'; ?>" class="view-btn"><?php esc_html_e('View All Friend Request', 'socialv'); ?></a>
				</div>
			<?php else : ?>
				<div class="item-body">
					<p class="no-request m-0"><?php esc_html_e('You have no pending friends requests.', 'socialv'); ?></p>
				</div>
		<?php endif;
		endif;  ?>
	</div>
</div>