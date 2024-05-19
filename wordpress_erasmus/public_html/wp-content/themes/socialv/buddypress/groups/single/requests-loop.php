<?php

/**
 * BuddyPress - Groups Requests Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<?php if (bp_group_has_membership_requests(bp_ajax_querystring('membership_requests'))) : ?>
	<div id="request-list" class="item-list socialv-members-lists socialv-bp-main-box">
		<?php while (bp_group_membership_requests()) : bp_group_the_membership_request(); ?>
			<div class="socialv-member-info group-request-list">
				<div class="socialv-member-main">
					<div class="socialv-member-left  item-avatar">
						<a href="<?php bp_member_link(); ?>"><?php bp_member_avatar(array('type'    => 'full', 'width' => 80, 'height' => 80, 'class' => 'rounded-circle')); ?></a>
					</div>
					<div class="socialv-member-center item-block">
						<div class="member-name">
							<h5 class="title">
								<a href="<?php bp_member_link(); ?>"><?php bp_group_request_user_link(); ?></a>
							</h5>
						</div>
						<div class="socialv-member-info-top">
							<span class="socialv-e-last-activity"><?php bp_group_request_time_since_requested(); ?></span>
						</div>
						<p class="comments"><?php bp_group_request_comment(); ?></p>

						<?php

						/**
						 * Fires inside the groups membership request list loop.
						 *
						 * @since 1.1.0
						 */
						do_action('bp_group_membership_requests_admin_item'); ?>
					</div>
				</div>
				<div class="socialv-member-right">
					<div class="request-btn d-block">
						<?php bp_button(array('id' => 'group_membership_accept', 'component' => 'groups', 'wrapper_class' => 'accept', 'link_class' => 'accept btn btn-sm socialv-btn-success', 'link_href' => bp_get_group_request_accept_link(), 'link_text' => esc_html__('Accept', 'socialv'))); ?>
						<?php bp_button(array('id' => 'group_membership_reject', 'component' => 'groups', 'wrapper_class' => 'reject', 'link_class' => 'reject btn btn-sm socialv-btn-danger', 'link_href' => bp_get_group_request_reject_link(), 'link_text' => esc_html__('Reject', 'socialv'))); ?>
						<?php do_action('bp_group_membership_requests_admin_item_action'); ?>
					</div>

				</div>
			</div>
		<?php endwhile; ?>
	</div>
	<div id="pag-bottom" class="socialv-bp-pagination">
		<div class="pagination-links" id="member-dir-pag-bottom">
			<?php bp_group_requests_pagination_links(); ?>
		</div>
	</div>

<?php else : ?>

	<div id="message" class="info">
		<p><?php esc_html_e('There are no pending membership requests.', 'socialv'); ?></p>
	</div>

<?php endif;
