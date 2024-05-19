<?php
// Exit if the file is accessed directly over web.
if (!defined('ABSPATH')) {
	exit;
}
/**
 * @package mediapress
 *
 * Single Gallery template
 * If you need specific template for various types, you can copy this file and create new files with name like
 * This comes as the fallback template in our template hierarchy
 * Before loading this file, MediaPress will search for
 * single-{type}-{status}.php
 * single-{type}.php
 * and then fallback to
 * single.php
 * Where type=photo|video|audio|any active type
 *         status =public|private|friendsonly|groupsonly|any registered status
 *
 *
 * Please create your template if you need specific templates for photo, video etc
 *
 *
 *
 * Fallback single Gallery View
 */
?>
<?php
$gallery = mpp_get_current_gallery();
$id    = $gallery->id;
$type    = $gallery->type;
?>
<div class="single-media-inner">
	<div class="single-media-header">

		<?php if (mpp_user_can_upload(mpp_get_current_component(), mpp_get_current_component_id(), mpp_get_current_gallery())) : ?>
			<button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#socialv-create-albumz">
				<i class="iconly-Upload icli"></i>
				<?php esc_html_e("Upload", "socialv"); ?>
			</button>

			<!-- Modal -->
			<div class="modal fade" id="socialv-create-albumz" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered create-album-main">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<?php echo do_shortcode("[mpp-uploader gallery_id=$id]"); ?>
							<div class="mpp-u-1 mpp-clearfix mpp-submit-button">
								<button type="submit" onclick='location.reload();' class='mpp-align-right w-100 socialv-button '> <?php esc_html_e('Upload', 'socialv'); ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php endif; ?>
		<?php if (mpp_user_can_delete_gallery($gallery)) : ?>
			<div class="all-media-action">
				<!-- select all -->
				<span class="socialv-check select-media-icon me-3">
					<label>
						<input type="checkbox" class="select-media-checkbox multi" value="<?php echo esc_attr($id); ?>">
						<span class="select-all-label"><?php esc_html_e("Select All", "socialv"); ?></span>
					</label>
				</span>
				<!-- delete all -->
				<span class="multi-delete-media-icon">
					<a href="javascript:void(0);" class="socialv-delete-media multi-delete" data-id="<?php echo esc_attr($id); ?>">
						<span>
							<i class="iconly-Delete icli"></i>
							<label><?php esc_html_e("Delete", "socialv"); ?></label>
						</span>
					</a>
				</span>
			</div>
		<?php endif; ?>
	</div>
	<?php if (mpp_have_media()) : ?>

		<?php if (mpp_user_can_list_media(mpp_get_current_gallery_id())) : ?>

			<?php do_action('mpp_before_single_gallery'); ?>

			<?php if (mpp_show_gallery_description()) : ?>
				<div class="mpp-gallery-description mpp-single-gallery-description mpp-<?php echo esc_attr($type); ?>-gallery-description mpp-clearfix">
					<?php mpp_gallery_description(); ?>
				</div>
			<?php endif; ?>

			<div class='mpp-g socialv-media-list mpp-item-list mpp-media-list mpp-<?php echo esc_attr($type); ?>-list mpp-single-gallery-media-list mpp-single-gallery-<?php echo esc_attr($type); ?>-list' data-gallery-id="<?php echo mpp_get_current_gallery_id(); ?>" data-mpp-type="<?php echo esc_attr($type); ?>">
				<?php mpp_load_gallery_view($gallery); ?>
			</div>

			<?php do_action('mpp_after_single_gallery'); ?>
			
			<?php mpp_media_pagination(); ?>

			<?php do_action('mpp_after_single_gallery_pagination'); ?>

			<?php mpp_locate_template(array('buddypress/members/gallery/activity.php'), true); ?>

			<?php do_action('mpp_after_single_gallery_activity'); ?>

		<?php else : ?>
			<div class="mpp-notice mpp-gallery-prohibited">
				<p><?php printf(esc_html__('The privacy policy does not allow you to view this.', 'socialv')); ?></p>
			</div>
		<?php endif; ?>

		<?php mpp_reset_media_data(); ?>

	<?php else : ?>

		<div class="mpp-notice mpp-no-gallery-notice">
			<p> <?php esc_html_e('Nothing to see here!', 'socialv'); ?></p>
		</div>

	<?php endif; ?>
</div>