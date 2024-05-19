<?php
// Exit if the file is accessed directly over web.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$media = mpp_get_current_media();
?>
<div class="mpp-lightbox-content mpp-lightbox-with-comment-content mpp-clearfix" id="mpp-lightbox-media-<?php mpp_media_id(); ?>">

    <div class="mpp-lightbox-media-container mpp-lightbox-with-comment-media-container">

		<?php do_action( 'mpp_before_lightbox_media', $media ); ?>

        <?php mpp_locate_template( array( 'gallery/media/views/lightbox/media-meta-top.php' ), true ); ?>

        <div class="mpp-lightbox-media-entry mpp-lightbox-with-comment-media-entry">
	        <?php mpp_lightbox_content( $media );?>
        </div>

	    <?php mpp_locate_template( array( 'gallery/media/views/lightbox/media-meta-bottom.php' ), true ); ?>

        <?php do_action( 'mpp_after_lightbox_media', $media ); ?>
    </div> <!-- end of media container -->

</div> <!-- end of lightbox content -->
