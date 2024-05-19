<?php

/**
 * Template part for displaying the Messages
 *
 * @package socialv
 */

$socialv_options = get_option('socialv-options');
?>
<div class="dropdown dropdown-messages">
	<button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
		<i class="iconly-Message icli" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php esc_attr_e('Messages', 'socialv'); ?>"></i>
		<?php if (class_exists('BP_Better_Messages')) {
			echo do_shortcode('[bp_better_messages_unread_counter hide_when_no_messages="1"]');
		} else {
			if (function_exists('bp_get_total_unread_messages_count') && bp_get_total_unread_messages_count(bp_loggedin_user_id()) > 0) { ?>
				<span class="notify-count"><?php echo esc_html((bp_get_total_unread_messages_count(bp_loggedin_user_id()) > 9) ? '9+' : (bp_get_total_unread_messages_count(bp_loggedin_user_id()))); ?></span>
		<?php }
		} ?>
	</button>
	<div class="dropdown-menu dropdown-menu-right">
		<div class="item-heading">
			<h5 class="heading-title"><?php esc_html_e('Messages', 'socialv'); ?></h5>
		</div>
		<?php
		if (class_exists('BP_Better_Messages') && function_exists('Better_Messages')) { ?>
			<div class="item-body">
				<?php
				echo Better_Messages()->functions->get_threads_html(get_current_user_id());
				?>
			</div>
			<div class="item-footer">
				<a href="<?php echo bp_loggedin_user_domain() . 'messages/'; ?>" class="view-btn"><?php esc_html_e('View All Messages', 'socialv'); ?></a>
			</div>
			<?php
		} else {
			if (function_exists('bp_message_threads') && bp_has_message_threads(bp_ajax_querystring('messages') .  '&user_id=' . bp_loggedin_user_id())) : ?>
				<div class="item-body">
					<form action="<?php echo bp_displayed_user_domain() . bp_get_messages_slug() . '/' . bp_current_action() ?>/bulk-manage/" method="post" id="messages-bulk-management">
						<?php while (bp_message_threads()) : bp_message_thread();
							global $messages_template;
						?><a href="<?php bp_message_thread_view_link(); ?>">
								<div class="d-flex socialv-notification-box socialv-message-notification <?php echo esc_attr((bp_message_thread_has_unread()) ? 'socialv-unread' : 'socialv-read'); ?>">
									<?php $avatar_img = bp_message_thread_avatar(array('width' => 32, 'height' => 32, 'class' => 'avatar rounded-circle'));
									if (!empty($avatar_img)) :
										echo '<div class="item-img">' . $avatar_img . '</div>';
									endif;
									?>
									<div class="flex-grow-1 item-details ms-3">
										<div class="item-detail-data d-flex justify-content-between">
											<?php if (empty($messages_template->thread->last_sender_id)) {
												echo '<h6 class="item-title">' . bp_get_message_thread_subject() . '</h6>';
											} else if ('sentbox' != bp_current_action()) { ?>
												<h6 class="item-title"><?php echo esc_html(bp_core_get_user_displayname($messages_template->thread->last_sender_id)); ?></h6>
											<?php } else { ?>
												<h6 class="item-title"><span class="to"><?php esc_html_e('To:', 'socialv'); ?></span><?php bp_message_thread_to(); ?>
												</h6>
											<?php } ?>
											<div class="item-time" data-livestamp="<?php bp_core_iso8601_date(bp_get_message_thread_last_post_date_raw(array('relative' => false))); ?>">
												<?php $date_notified = bp_get_message_thread_last_post_date_raw();
												echo bp_core_time_since($date_notified); ?></div>
										</div>
										<p class="m-0"><?php bp_message_thread_excerpt('3'); ?></p>

									</div>
									<?php
									?>
								</div>
							</a>
						<?php endwhile; ?>
					</form>
				</div>
				<div class="item-footer">
					<a href="<?php echo bp_loggedin_user_domain() . 'messages/'; ?>" class="view-btn"><?php esc_html_e('View All Messages', 'socialv'); ?></a>
				</div>
			<?php else : ?>
				<div class="item-body">
					<p class="no-message m-0"><?php esc_html_e('Sorry, no messages were found.', 'socialv'); ?></p>
				</div>
		<?php endif;
		} ?>
	</div>
</div>