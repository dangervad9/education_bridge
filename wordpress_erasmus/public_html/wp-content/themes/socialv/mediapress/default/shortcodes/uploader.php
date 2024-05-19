<?php
// Exit if the file is accessed directly over web
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="mpp-upload-shortcode">
    <div class="mpp-media-upload-container"><!-- mediapress upload container -->
	<!-- append uploaded media here -->
	<div id="mpp-uploaded-media-list-shortcode" class="mpp-uploading-media-list">
		<ul class="list-inline">
		</ul>
	</div>

	<?php do_action( 'mpp_after_shortcode_upload_medialist' ); ?>

	<!-- drop files here for uploading -->
	
	<?php do_action( 'socialv_mpp_upload_dropzone' ); ?>
	<?php do_action( 'mpp_after_shortcode_upload_dropzone' ); ?>

	<!-- show any feedback here -->
	<div id="mpp-upload-feedback-shortcode" class="mpp-feedback">
		<ul></ul>
	</div>

	<?php do_action( 'mpp_after_shortcode_upload_feedback' ); ?>

	<?php if ( mpp_is_remote_enabled( 'shortcode' ) ) : ?>
        <!-- remote media -->
        <div class="mpp-remote-media-container">
            <div class="mpp-feedback mpp-remote-media-upload-feedback">
                <ul></ul>
            </div>
			<?php wp_nonce_field( 'mpp_add_media', 'mpp-remote-media-nonce' ); ?>
        </div>
        <!-- end of remote media -->
	<?php endif;?>

    <input type='hidden' name='mpp-context' class="mpp-context" id='mpp-context' value="<?php echo esc_attr($context); ?>"/>

	<?php if ( $type ) : ?>
		<input type='hidden' name='mpp-uploading-media-type' class='mpp-uploading-media-type' value="<?php echo esc_attr($type); ?>"/>
	<?php endif; ?>

	<?php if ( $skip_gallery_check ) : ?>
		<input type="hidden" name="mpp-shortcode-skip-gallery-check" value="1" id="mpp-shortcode-skip-gallery-check"/>
	<?php endif; ?>

	<?php if ( $gallery_id || $skip_gallery_check ) : ?>
		<input type='hidden' name='mpp-shortcode-upload-gallery-id' id='mpp-shortcode-upload-gallery-id' value="<?php echo esc_attr($gallery_id); ?>"/>

	<?php else : ?>
		<?php
		mpp_list_galleries_dropdown( array(
			'name'           => 'mpp-shortcode-upload-gallery-id',
			'id'             => 'mpp-shortcode-upload-gallery-id',
			'selected'       => $gallery_id,
			'type'           => $type,
			'status'         => $status,
			'component'      => $component,
			'component_id'   => $component_id,
			'posts_per_page' => - 1,
			'label_empty'    => $label_empty,
		) );
		?>
	<?php endif; ?>
    </div><!-- end of mediapress form container -->
</div>
