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

<?php if (bp_get_current_member_type()) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message() ?></p>
<?php endif;

$per_page = isset($socialv_options['default_post_per_page']) ? $socialv_options['default_post_per_page'] : 10;
if (bp_has_members(bp_ajax_querystring('members') . '&per_page=' . ($per_page))) :
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
							<a href="<?php bp_member_permalink(); ?>">
								<?php bp_member_avatar(array('type'    => 'full', 'width' => 80, 'height' => 80, 'class' => 'rounded-circle')); ?>
							</a>
						</div>
						<div class="socialv-member-center item-block">
							<div class="member-name">
								<a class="h5 title" href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
							</div>
							<?php
							$user_id = bp_get_member_user_id();
							$location =  xprofile_get_field_data('location', $user_id);
							?>
							<div class="socialv-member-info-top">
								<?php if (!empty($location)) : ?>
									<i class="iconly-Location icli me-1"></i><span class="socialv-e-member-location me-4"><?php echo esc_html($location); ?></span>
								<?php endif; ?>
								<i class="iconly-Calendar icli me-1"></i><span class="socialv-e-last-activity me-4" data-livestamp="<?php bp_core_iso8601_date(bp_get_member_last_active(array('relative' => false))); ?>"><?php bp_member_last_active(); ?></span>
							</div>
							<?php do_action('socialv_member_center_content'); ?>
						</div>
					</div>
					<div class="socialv-member-right">
						<?php do_action('bp_directory_members_actions'); ?>
						<?php if (is_user_logged_in() && function_exists('friends_get_friend_user_ids') && !class_exists('BP_Better_Messages')) : ?>
							<a class="message-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e('Message', 'socialv'); ?>" href="<?php echo esc_url(socialv()->bp_custom_get_send_private_message_link(bp_get_member_user_id())); ?>"><i class="iconly-Message icli"></i></a>
						<?php endif; ?>
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
	$total_member = bp_get_total_member_count();
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
