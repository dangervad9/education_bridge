<?php
// Exit if the file is accessed directly over web
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
//action:mediapress/create :- Create Gallery template
?>
<div id="mpp-gallery-create-form-wrapper" class="mpp-container">

	<?php if ( mpp_user_can_create_gallery( mpp_get_current_component(), mpp_get_current_component_id() ) ) : ?>

		<form method="post" action="" id="mpp-gallery-create-form" class="mpp-form mpp-form-stacked mpp-gallery-create-form">
			<?php
			$title  = $description = $type = '';
			$status = mpp_get_default_status();

			if ( ! empty( $_POST['mpp-gallery-title'] ) ) {
				$title = sanitize_text_field($_POST['mpp-gallery-title']);
			}

			if ( ! empty( $_POST['mpp-gallery-description'] ) ) {
				$description = sanitize_textarea_field($_POST['mpp-gallery-description']);
			}

			if ( ! empty( $_POST['mpp-gallery-status'] ) ) {
				$status = sanitize_text_field($_POST['mpp-gallery-status']);
			}

			if ( ! empty( $_POST['mpp-gallery-type'] ) ) {
				$type = sanitize_text_field($_POST['mpp-gallery-type']);
			}

			?>

			<?php do_action( 'mpp_before_create_gallery_form' ); ?>

			<div class="mpp-g mpp-form-wrap">
				<div class="mpp-u-1-1 mpp-before-create-gallery-form-fields">
					<?php // use this hook to add anything at the top of the gallery create form.  ?>
					<?php do_action( 'mpp_before_create_gallery_form_fields' ); ?>
				</div>

				<div class="mpp-u-1-2 mpp-editable-gallery-type">
					<label for="mpp-gallery-type"><?php esc_html_e( 'Type', 'socialv' ); ?></label>
					<?php mpp_type_dd( array( 'selected' => $type, 'component' => mpp_get_current_component() ) ) ?>
				</div>

				<div class="mpp-u-1-2 mpp-editable-gallery-status">
					<label for="mpp-gallery-status"><?php esc_html_e( 'Status', 'socialv' ); ?></label>
					<?php mpp_status_dd( array(
						'selected'  => $status,
				        'component' => mpp_get_current_component(),
					) ); ?>
				</div>

				<div class="mpp-u-1-1 mpp-editable-gallery-title">
					<label for="mpp-gallery-title"><?php esc_html_e( 'Title:', 'socialv' ); ?></label>
					<input id="mpp-gallery-title" type="text" value="<?php echo esc_attr( $title ) ?>" class="mpp-input-1" placeholder="<?php esc_attr_e( 'Gallery Title (Required)', 'socialv' ); ?>" name="mpp-gallery-title"/>
				</div>

				<div class="mpp-u-1-1 mpp-editable-gallery-description">
					<label for="mpp-gallery-description"><?php esc_html_e( 'Description', 'socialv' ); ?></label>
					<textarea id="mpp-gallery-description" name="mpp-gallery-description" rows="3" class="mpp-input-1"><?php echo esc_textarea( $description ); ?></textarea>
				</div>

				<div class="mpp-u-1-1 mpp-after-create-gallery-form-fields">
					<?php // use this hook to add any extra data here for settings or other things at the bottom of create gallery form. ?>
					<?php do_action( 'mpp_after_create_gallery_form_fields' ); ?>

				</div>

				<?php do_action( 'mpp_before_create_gallery_form_submit_field' ); ?>
				<?php
				// do not delete this line, we need it to validate.
				wp_nonce_field( 'mpp-create-gallery', 'mpp-nonce' );
				// also do not delete the next line <input type='hidde' name='mpp-action' value='create-gallery' >
				?>

				<input type='hidden' name="mpp-action" value='create-gallery'/>

				<div class="mpp-u-1-1 mpp-clearfix mpp-submit-button">
					<button type="submit" class='mpp-align-right mpp-button-primary mpp-create-gallery-button '> <?php esc_html_e( 'Create', 'socialv' ); ?></button>
				</div>

			</div><!-- end of .mpp-g -->

			<?php do_action( 'mpp_after_create_gallery_form' ); ?>
		</form>

	<?php else: ?>
		<div class='mpp-notice mpp-unauthorized-access'>
			<p><?php esc_html_e( 'Unauthorized access!', 'socialv' ); ?></p>
		</div>
	<?php endif; ?>
</div><!-- end of mpp-container -->
