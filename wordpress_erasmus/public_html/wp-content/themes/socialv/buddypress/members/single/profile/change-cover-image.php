<?php

/**
 * BuddyPress - Members Profile Change Cover Image
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>
<div class="row card-space">
    <div class="col-md-4">
        <div class="accordion">
            <div class="socialv-profile-edit-dropdown" id="accordionProfile">
                <div class="accordion-item">
                    <h6 class="accordion-header" id="headingOne">
                        <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="iconly-Profile icli"></i> <?php esc_html_e('Profile Setting', 'socialv'); ?>
                        </div>
                    </h6>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionProfile">

                        <?php if (bp_profile_has_multiple_groups()) : ?>
                            <div class="accordion-body">
                                <ul class="list-inline m-0" >
                                    <?php bp_profile_group_tabs(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="accordion-item">
                    <h6 class="accordion-header" id="headingTwo">
                        <div class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="iconly-Setting icli"></i> <?php esc_html_e('Account Settings', 'socialv'); ?>
                        </div>
                    </h6>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionProfile">
                        <div class="accordion-body">
                            <?php do_action('socialv_settings_menus'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <?php do_action('socialv_account_menu_header_buttons'); ?>
        <div class="card-main card-space">

            <div class="card-head card-header-border d-flex align-items-center justify-content-between">
                <div class="head-title">
                    <h4 class="card-title"><?php esc_html_e('Change Cover Image', 'socialv'); ?></h4>
                </div>
            </div>

            <div class="card-inner">
                <div class="row">
                    <?php do_action('bp_before_profile_avatar_upload_content'); ?>
                    <?php do_action('bp_before_profile_edit_cover_image'); ?>

                    <p><?php esc_html_e('Your Cover Image will be used to customize the header of your profile.', 'socialv'); ?></p>

                    <?php bp_attachments_get_template_part('cover-images/index'); ?>

                    <?php do_action('bp_after_profile_edit_cover_image'); ?>

                </div>
            </div>
        </div>
    </div>
</div>