<?php
// Exit if the file is accessed directly over web.
if (!defined('ABSPATH')) {
	exit;
}
/**
 * Create Gallery shortcode
 * You can overwide it in yourtheme/mediapress/default/shortcodes/create-gallery.php
 */
?>
<div id="mpp-create-gallery-form-wrapper" class="mpp-container">

	<?php if (mpp_user_can_create_gallery(mpp_get_current_component(), mpp_get_current_component_id())) : ?>

		<form method="post" action="" id="mpp-create-gallery-form" class=" mpp-form-stacked mpp-create-gallery-form">
			<?php
			$title = $description = $status = $type = $component = '';

			if (!empty($_POST['mpp-gallery-title'])) {
				$title = sanitize_text_field($_POST['mpp-gallery-title']);
			}

			if (!empty($_POST['mpp-gallery-description'])) {
				$description = sanitize_textarea_field($_POST['mpp-gallery-description']);
			}

			if (!empty($_POST['mpp-gallery-status'])) {
				$status = sanitize_text_field($_POST['mpp-gallery-status']);
			}

			if (!empty($_POST['mpp-gallery-type'])) {
				$type = sanitize_text_field($_POST['mpp-gallery-type']);
			}

			if (!empty($_POST['mpp-gallery-component'])) {
				$component = sanitize_text_field($_POST['mpp-gallery-component']);
			}

			$current_component = mpp_get_current_component();

			?>

			<?php do_action('mpp_before_create_gallery_form'); ?>

			<div class="mpp-g mpp-form-wrap">

				<div class="mpp-u-1-1 mpp-before-create-gallery-form-fields">
					<?php // use this hook to add anything at the top of the gallery create form.  
					?>
					<?php do_action('mpp_before_create_gallery_form_fields'); ?>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<h3 class="text-center mb-4"><?php esc_html_e("Create Album", "socialv"); ?></h3>
					</div>
					<div class="col-lg-6">
						<div class="mpp-u-1 mpp-editable-gallery-type">
							<div class="position-relative border-start-0 form-floating">
								<?php echo str_replace("<select", "<select class='form-select'", mpp_type_dd(array('echo' => false, 'selected' => $type, 'component' => $current_component))); ?>
								<label for="mpp-gallery-type"><?php esc_html_e('Type', 'socialv'); ?></label>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mpp-u-1 mpp-editable-gallery-status">
							<div class="position-relative border-start-0 form-floating">
								<?php echo str_replace("<select", "<select class='form-select'", mpp_status_dd(array('echo' => false, 'selected' => $status, 'component' => $current_component))); ?>
								<label for="mpp-gallery-status"><?php esc_html_e('Status', 'socialv'); ?></label>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="mpp-u-1-1 mpp-editable-gallery-title">
							<div class="form-floating">
								<input class="form-control" type="text" id="mpp-gallery-title" value="<?php echo esc_attr($title) ?>" class="mpp-input-1" placeholder="<?php esc_attr_e('Gallery Title (Required)', 'socialv'); ?>" name="mpp-gallery-title" />
								<label for="mpp-gallery-title"><?php esc_html_e('Title:', 'socialv'); ?></label>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="mpp-u-1 mpp-editable-gallery-description">
							<div class="form-floating">
								<textarea class="form-control" id="mpp-gallery-description" name="mpp-gallery-description" rows="3" class="mpp-input-1" placeholder="<?php esc_attr_e('Description', 'socialv'); ?>"><?php echo esc_textarea($description); ?></textarea>
								<label for="mpp-gallery-description"><?php esc_html_e('Description', 'socialv'); ?></label>
							</div>
						</div>
					</div>
				</div>


				<div class="mpp-u-1-1 mpp-after-create-gallery-form-fields">
					<?php // use this hook to add any extra data here for settings or other things at the bottom of create gallery form. 
					?>
					<?php do_action('mpp_after_create_gallery_form_fields'); ?>
				</div>

				<?php do_action('mpp_before_create_gallery_form_submit_field'); ?>
				<?php
				// do not delete this line, we need it to validate.
				wp_nonce_field('mpp-create-gallery', 'mpp-nonce');
				// also do not delete the next line <input type='hidde' name='mpp-action' value='create-gallery' >.
				?>

				<input type='hidden' name="mpp-action" value='create-gallery' />
				<input type='hidden' name="mpp-gallery-component" value="<?php echo esc_attr($current_component); ?>" />

				<div class="mpp-u-1 mpp-clearfix mpp-submit-button">
					<button type="submit" class='mpp-align-right w-100 socialv-button '> <?php esc_html_e('Create', 'socialv'); ?></button>
				</div>

			</div><!-- end of .mpp-g -->

			<?php do_action('mpp_after_create_gallery_form'); ?>
		</form>

	<?php else : ?>
		<div class='mpp-notice mpp-unauthorized-access'>
			<p><?php esc_html_e('Unauthorized access!', 'socialv'); ?></p>
		</div>
	<?php endif; ?>
</div><!-- end of mpp-container -->