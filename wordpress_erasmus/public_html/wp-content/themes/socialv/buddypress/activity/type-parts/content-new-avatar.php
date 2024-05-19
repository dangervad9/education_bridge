<?php

/**
 * BuddyPress - `new_avatar` activity type content part.
 *
 * This template is only used to display the `new_avatar` activity type content.
 *
 * @since 10.0.0
 * @version 10.0.0
 */

use function SocialV\Utility\socialv;

if (bp_is_user()) :
    $user_id = bp_get_activity_user_id();
    $user_cover_image = bp_attachments_get_attachment('url', array(
        'item_id' => $user_id
    ));
    $user_profile_photo = bp_core_fetch_avatar(array(
        'item_id'   => $user_id,
        'type'      => 'full',
        'width'     => 140,
        'height'    => 140,
        'class'     => 'aligncenter rounded',
    ));
    $user_mention_name =  bp_core_get_username($user_id);
    $user_mention_url =  wp_nonce_url(
        add_query_arg(
            array(
                'r' => $user_mention_name,
            ),
            bp_get_activity_directory_permalink()
        )
    );

?>
    <div class="bp-member-activity-preview socialv-profile-activity">
        <div class="bp-member-preview-cover">
            <a href="<?php echo esc_url(bp_core_get_user_domain($user_id)); ?>">
                <?php if (!empty($user_cover_image)) : ?>
                    <img src="<?php echo esc_url($user_cover_image) ?>" alt="<?php esc_attr_e('image', 'socialv'); ?>" loading="lazy" />
                <?php else : ?>
                    <img src="<?php echo esc_url(SOCIALV_DEFAULT_COVER_IMAGE); ?>" alt="<?php esc_attr_e('activity', 'socialv'); ?>" loading="lazy" />
                <?php endif; ?>
            </a>
        </div>

        <div class="bp-member-short-description">
            <?php if (!empty($user_profile_photo)) : ?>
                <div class="bp-member-avatar-content has-cover-image <?php echo !empty($user_cover_image) ? 'has-cover-image' : ''; ?>">
                    <a href="<?php echo esc_url(bp_core_get_user_domain($user_id)); ?>">
                        <?php echo wp_kses_post($user_profile_photo); ?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="socialv-profile-detail">
                <h5 class="bp-member-short-description-title">
                    <a href="<?php echo esc_url(bp_core_get_user_domain($user_id)); ?>"><?php echo esc_html(bp_core_get_user_displayname($user_id));  ?></a>
                    <?php if (class_exists("BP_Verified_Member"))
                        echo socialv()->socialv_get_verified_badge(bp_get_activity_user_id());
                    ?>
                </h5>
                <div class="bp-member-nickname">
                    <a href="<?php echo esc_url(is_user_logged_in() ? $user_mention_url : bp_core_get_user_domain($user_id)); ?>">@<?php echo esc_html($user_mention_name); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="bp-member-activity-preview socialv-profile-activity">
        <div class="bp-member-preview-cover">
            <a href="<?php bp_activity_generated_content_part('user_url'); ?>">
                <?php if (bp_activity_has_generated_content_part('user_cover_image')) : ?>
                    <img src="<?php bp_activity_generated_content_part('user_cover_image'); ?>" alt="<?php esc_attr_e('image', 'socialv'); ?>" loading="lazy" />
                <?php else : ?>
                    <img src="<?php echo esc_url(SOCIALV_DEFAULT_COVER_IMAGE); ?>" alt="<?php esc_attr_e('activity', 'socialv'); ?>" loading="lazy" />
                <?php endif; ?>
            </a>
        </div>

        <div class="bp-member-short-description">
            <div class="bp-member-avatar-content has-cover-image <?php echo bp_activity_has_generated_content_part('user_cover_image') ? 'has-cover-image' : ''; ?>">
                <a href="<?php bp_activity_generated_content_part('user_url'); ?>">
                    <?php if (bp_activity_has_generated_content_part('user_profile_photo')) : ?>
                        <img src="<?php bp_activity_generated_content_part('user_profile_photo'); ?>" class=" avatar aligncenter avatar-140 rounded" alt="<?php esc_attr_e('image', 'socialv'); ?>" loading="lazy" />
                    <?php else : ?>
                        <img src="<?php echo esc_url(BP_AVATAR_DEFAULT); ?>" class=" avatar aligncenter avatar-140 rounded" alt="<?php esc_attr_e('image', 'socialv'); ?>" loading="lazy" />
                    <?php endif; ?>
                </a>
            </div>
            <div class="socialv-profile-detail">
                <h5 class="bp-member-short-description-title">
                    <a href="<?php bp_activity_generated_content_part('user_url'); ?>"><?php bp_activity_generated_content_part('user_display_name'); ?></a>
                    <?php if (class_exists("BP_Verified_Member"))
                        echo socialv()->socialv_get_verified_badge(bp_get_activity_user_id());
                    ?>
                </h5>

                <div class="bp-member-nickname">
                    <a href="<?php is_user_logged_in() ? bp_activity_generated_content_part('user_mention_url') : bp_activity_generated_content_part('user_url'); ?>">@<?php bp_activity_generated_content_part('user_mention_name'); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>