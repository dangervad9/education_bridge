<?php
// Exit if the file is accessed directly over web.
if (!defined('ABSPATH')) {
	exit;
}
?>
<?php while (mpp_have_media()) : mpp_the_media(); ?>
	<?php $media = mpp_get_media(); ?>
	<?php
	$type = mpp_get_media_type($media);
	$id = mpp_get_media_id();
	?>
	<div class="socialv-media-inner mpp-u <?php mpp_media_class(mpp_get_media_grid_column_class()); ?>" data-mpp-type="<?php echo esc_attr($type); ?>">

		<?php do_action('mpp_before_media_item'); ?>

		<div class="mpp-item-meta mpp-media-meta mpp-media-meta-top">
			<?php do_action('mpp_media_meta_top'); ?>
		</div>

		<div class='socialv-media-container mpp-item-entry mpp-media-entry mpp-photo-entry'>
			<?php
			if (!mpp_is_doc_viewable($media)) {
				$url   = mpp_get_media_src('', $media);
				$class = 'mpp-no-lightbox';
			} else {
				$url   = mpp_get_media_permalink($media);
				$class = '';
			}
			?>
			<a href="<?php echo esc_url($url); ?>" <?php mpp_media_html_attributes(array('class' => "mpp-item-thumbnail mpp-media-thumbnail mpp-photo-thumbnail {$class}")); ?> data-mpp-type="<?php echo esc_attr($type); ?>">
				<img src="<?php mpp_media_src('thumbnail'); ?>" alt="<?php echo esc_attr(mpp_get_media_title()); ?> " loading="lazy" />
			</a>
			<?php if (mpp_user_can_delete_media($id)) : ?>
				<span class="delete-media-icon">
					<a href="javascript:void(0);" class="socialv-delete-media" data-id="<?php echo esc_attr($id); ?>">
						<i class="iconly-Delete icli"></i>
					</a>
				</span>

				<span class="socialv-check select-media-icon">
					<label>
						<input type="checkbox" class="select-media-checkbox single" value="<?php echo esc_attr($id); ?>">
					</label>
				</span>
			<?php endif; ?>

		</div>
		<a href="<?php echo esc_url($url); ?>" <?php mpp_media_html_attributes(array('class' => "socialv-doc-single mpp-item-thumbnail mpp-media-thumbnail mpp-photo-thumbnail {$class}")); ?> data-mpp-type="<?php echo esc_attr($type); ?>">
			<?php mpp_media_title(); ?>
		</a>
		<div class="mpp-item-meta mpp-media-meta mpp-media-meta-bottom">
			<?php do_action('mpp_media_meta'); ?>
		</div>

		<?php do_action('mpp_after_media_item'); ?>
	</div>

<?php endwhile; ?>