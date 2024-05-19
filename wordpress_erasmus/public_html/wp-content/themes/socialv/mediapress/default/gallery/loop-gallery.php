<?php
// Exit if the file is accessed directly over web
if (!defined('ABSPATH')) {
	exit;
}

/**
 * List all galleries for the current component
 *
 */
?>

<?php
$create_gallery = (mpp_user_can_create_gallery(mpp_get_current_component(), mpp_get_current_component_id()));

if (mpp_have_galleries()) : ?>
	<div class='mpp-g mpp-item-list mpp-galleries-list'>

		<?php while (mpp_have_galleries()) : mpp_the_gallery(); ?>
			<?php if ($create_gallery) : ?>
				<div class="socialv-create-gallery <?php mpp_gallery_class(mpp_get_gallery_grid_column_class()); ?>" data-bs-toggle="modal" data-bs-target="#socialv-create-album">
					<div class="create-gallery-detail">
						<div class="text-center">
							<div class="mb-3 create-gallery-icon"><i class="iconly-Plus icli"></i></div>
							<div class="create-gallery-label"><?php esc_html_e("Create Album", "socialv"); ?></div>
						</div>
					</div>
				</div>

				<!-- Modal -->
				<div class="modal fade" id="socialv-create-album" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered create-album-main">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<?php echo do_shortcode('[mpp-create-gallery]'); ?>
							</div>
						</div>
					</div>
				</div>

			<?php
				$create_gallery = false;
			endif;
			?>
			<?php $type = mpp_get_gallery_type(); ?>

			<div class="<?php mpp_gallery_class(mpp_get_gallery_grid_column_class()); ?>" id="mpp-gallery-<?php mpp_gallery_id(); ?>" data-mpp-type="<?php echo esc_attr($type); ?>">
				<?php do_action('mpp_before_gallery_entry'); ?>

				<div class="mpp-item-meta mpp-gallery-meta mpp-gallery-meta-top">
					<?php do_action('mpp_gallery_meta_top'); ?>
				</div>

				<div class="mpp-item-entry mpp-gallery-entry">
					<a href="<?php mpp_gallery_permalink(); ?>" <?php mpp_gallery_html_attributes(array('class' => 'mpp-item-thumbnail mpp-gallery-cover')); ?> data-mpp-type="<?php echo esc_attr($type); ?>">
						<img src="<?php mpp_gallery_cover_src('thumbnail'); ?>" alt="<?php echo esc_attr(mpp_get_gallery_title()); ?>" />
					</a>
				</div>

				<?php do_action('mpp_before_gallery_title'); ?>

				<a href="<?php mpp_gallery_permalink(); ?>" class="mpp-gallery-title" data-mpp-type="<?php echo esc_attr($type); ?>"><?php mpp_gallery_title(); ?></a>

				<?php do_action('mpp_before_gallery_actions'); ?>

				<div class="mpp-item-actions mpp-gallery-actions">
					<?php mpp_gallery_action_links(); ?>
				</div>

				<?php do_action('mpp_before_gallery_type_icon'); ?>

				<div class="mpp-type-icon"><?php do_action('mpp_type_icon', mpp_get_gallery_type(), mpp_get_gallery()); ?></div>

				<div class="mpp-item-meta mpp-gallery-meta mpp-gallery-meta-bottom">
					<?php do_action('mpp_gallery_meta'); ?>
				</div>

				<?php do_action('mpp_after_gallery_entry'); ?>
			</div>

		<?php endwhile; ?>

	</div>
	<?php mpp_gallery_pagination(); ?>
	<?php mpp_reset_gallery_data(); ?>
<?php else : ?>
	<div class="mpp-notice mpp-no-gallery-notice card-main">
		<div class="card-inner text-center">
			<div class="mb-3">
				<?php esc_html_e('There are no galleries available!', 'socialv'); ?>
			</div>
			<?php if ($create_gallery) : ?>
				<a href="javascript:void(0);" class="socialv-create-gallery socialv-button" data-bs-toggle="modal" data-bs-target="#socialv-create-album">
					<?php esc_html_e("Create", "socialv"); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
<?php if ($create_gallery) : ?>
	<!-- Modal -->
	<div class="modal fade" id="socialv-create-album" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered create-album-main">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<?php echo do_shortcode('[mpp-create-gallery]'); ?>
				</div>
			</div>
		</div>
	</div>
<?php
endif;
?>