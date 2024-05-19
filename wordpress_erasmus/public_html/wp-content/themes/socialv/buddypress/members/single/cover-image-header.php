<?php

/**
 * BuddyPress - Users Cover Image Header
 *
 * @since 3.0.0
 * @version 3.0.0
 */

use function SocialV\Utility\socialv;

$post_section = socialv()->post_style();
$logged_in_user_id = get_current_user_id();

$user_id = bp_displayed_user_id();
$account_type = bp_get_user_meta($user_id, "socialv_user_account_type", true);
$has_cover_image          = '';
$has_cover_image_position = '';
$displayed_user           = bp_get_displayed_user();
$cover_image_url          = bp_attachments_get_attachment(
	'url',
	array(
		'object_dir' => 'members',
		'item_id'    => $displayed_user->id,
	)
);
if (function_exists('buddypress')) {
	if (!empty($cover_image_url)) {
		$cover_image_position = bp_get_user_meta($user_id, 'bp_cover_position', true);
		$has_cover_image      = ' has-cover-image';
		if ('' !== $cover_image_position) {
			$has_cover_image_position = 'has-position';
		}
	}
}

?>

<div id="cover-image-container">
	<div class="header-cover-image zoom-gallery <?php echo esc_attr($has_cover_image_position . $has_cover_image); ?>">
		<?php if (is_user_logged_in()) {
			if (function_exists('friends_check_friendship') &&  !friends_check_friendship($logged_in_user_id, $user_id) && $user_id != $logged_in_user_id && $account_type == 'private') { ?>
				<div id="header-cover-image" class="header-cover-img"></div>
			<?php } else { ?>
				<a href="<?php if ($cover_image_url) {
								echo esc_url($cover_image_url);
							} else {
								echo esc_url(SOCIALV_DEFAULT_COVER_IMAGE);
							} ?>" class="popup-zoom">
					<div id="header-cover-image" class="header-cover-img"></div>
				</a>
		<?php }
		} else {
			echo '<div id="header-cover-image" class="header-cover-img"></div>';
		} ?>

		<?php if (bp_is_my_profile()) { ?>
			<a href="<?php echo bp_get_members_component_link('profile', 'change-cover-image'); ?>" class="link-change-cover-image">
				<?php
				if (function_exists('buddypress') && isset(buddypress()->buddyboss)) {
				?>
					<i class="bb-icon-edit-thin"></i>
				<?php } else { ?>
					<i class="iconly-Edit-Square icli"></i>
				<?php
				}
				?>
			</a>
		<?php } ?>

		<?php
		if (function_exists('buddypress') && isset(buddypress()->buddyboss)) {
			if (!empty($cover_image_url)) {
		?>
				<a href="#" class="position-change-cover-image bp-tooltip" data-bp-tooltip-pos="right" data-bp-tooltip="<?php esc_attr_e('Reposition Cover Photo', 'socialv'); ?>">
					<i class="bb-icon-move"></i>
				</a>
				<div class="header-cover-reposition-wrap">
					<a href="#" class="btn socialv-btn-danger small cover-image-cancel"><?php esc_html_e('Cancel', 'socialv'); ?></a>
					<a href="#" class="btn socialv-btn-success small cover-image-save"><?php esc_html_e('Save Changes', 'socialv'); ?></a>
					<span class="drag-element-helper"><i class="bb-icon-menu"></i><?php esc_html_e('Drag to move cover photo', 'socialv'); ?></span>
					<img src="<?php echo esc_url($cover_image_url); ?>" alt="<?php esc_attr_e('Cover photo', 'socialv'); ?>" loading="lazy" />
				</div>
		<?php
			}
		}
		?>
	</div>
</div><!-- #cover-image-container -->