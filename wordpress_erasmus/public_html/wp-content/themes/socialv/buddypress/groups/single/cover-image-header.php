<?php

/**
 * BuddyPress - Groups Cover Image Header.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires before the display of a group's header.
 *
 * @since 1.2.0
 */
do_action('bp_before_group_header'); ?>
<?php if (bp_group_use_cover_image_header()) :
    $cover_image_url          = bp_attachments_get_attachment(
        'url',
        array(
            'object_dir' => 'groups',
            'item_id'    => bp_get_group_id(),
        )
    );
?>
    <div id="cover-image-container">
        <div class="header-cover-image zoom-gallery has_cover_image">
            <?php if (is_user_logged_in()) {
                $is_member = groups_is_user_member(get_current_user_id(), bp_get_group_id());
                if (bp_get_group_status() == 'private' && !$is_member  && !bp_current_user_can('bp_moderate')) { ?>
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
                echo  '<div id="header-cover-image" class="header-cover-img"></div>';
            } ?>
        </div>
    </div><!-- #cover-image-container -->
<?php endif; ?>
<?php

/**
 * Fires after the display of a group's header.
 *
 * @since 1.2.0
 */
do_action('bp_after_group_header'); ?>