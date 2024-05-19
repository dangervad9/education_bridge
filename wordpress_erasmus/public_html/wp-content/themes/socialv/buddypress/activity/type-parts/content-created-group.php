<?php

/**
 * BuddyPress - `created_group` activity type content part.
 *
 * This template is only used to display the `created_group` activity type content.
 *
 * @since 10.0.0
 * @version 10.0.0
 */

use function SocialV\Utility\socialv;

?>
<?php if (bp_is_group()) : ?>
    <div class="bp-group-activity-preview socialv-group-activity">
        <div class="bp-group-preview-cover">
            <a href="<?php bp_group_permalink(); ?>">
                <?php if (!empty(bp_get_group_cover_url())) : ?>
                    <img src="<?php echo bp_get_group_cover_url(); ?>" alt="<?php esc_attr_e('image', 'socialv'); ?>" loading="lazy" />
                <?php else : ?>
                    <img src="<?php echo esc_url(SOCIALV_DEFAULT_COVER_IMAGE); ?>" alt="<?php esc_attr_e('group', 'socialv'); ?>" loading="lazy" />
                <?php endif; ?>
            </a>
        </div>

        <div class="bp-group-short-description">
            <?php if (bp_get_group_avatar()) : ?>
                <div class="bp-group-avatar-content <?php echo bp_get_group_avatar() ? 'has-cover-image' : ''; ?>">
                    <a href="<?php bp_group_permalink(); ?>">
                        <?php if (!empty(bp_get_group_avatar_url())) :
                            echo bp_core_fetch_avatar(array('item_id'    => bp_get_group_id(), 'avatar_dir' => 'group-avatars', 'object'     => 'group', 'width'      => 140, 'height'     => 140, 'class' => 'rounded', 'type' => 'full'));
                        else : ?>
                            <img src="<?php echo esc_url(BP_AVATAR_DEFAULT); ?>" class=" avatar aligncenter avatar-140 rounded" alt="<?php esc_attr_e('image', 'socialv'); ?>" loading="lazy" />
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="bp-group-short-description-title socialv-profile-detail">
                <a href="<?php echo bp_get_group_permalink(); ?>">
                    <?php bp_group_name(); ?>
                </a>
                <div class="activity-group-meta">
                    <?php echo socialv()->socialv_activity_group_meta(); ?>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="bp-group-activity-preview socialv-group-activity">
        <div class="bp-group-preview-cover">
            <a href="<?php bp_activity_generated_content_part('group_url'); ?>">
                <?php if (bp_activity_has_generated_content_part('group_cover_image')) : ?>
                    <img src="<?php bp_activity_generated_content_part('group_cover_image'); ?>" alt="<?php esc_attr_e('image', 'socialv'); ?>" loading="lazy" />
                <?php else : ?>
                    <img src="<?php echo esc_url(SOCIALV_DEFAULT_COVER_IMAGE); ?>" alt="<?php esc_attr_e('group', 'socialv'); ?>" loading="lazy" />
                <?php endif; ?>
            </a>
        </div>

        <div class="bp-group-short-description">
            <?php if (bp_activity_has_generated_content_part('group_profile_photo')) : ?>
                <div class="bp-group-avatar-content <?php echo bp_activity_has_generated_content_part('group_cover_image') ? 'has-cover-image' : ''; ?>">
                    <a href="<?php bp_activity_generated_content_part('group_url'); ?>">
                        <?php if (bp_activity_has_generated_content_part('group_profile_photo')) : ?>
                            <img src="<?php bp_activity_generated_content_part('group_profile_photo'); ?>" class=" avatar aligncenter avatar-140 rounded" alt="<?php esc_attr_e('image', 'socialv'); ?>" loading="lazy" />
                        <?php else : ?>
                            <img src="<?php echo esc_url(BP_AVATAR_DEFAULT); ?>" class=" avatar aligncenter avatar-140 rounded" alt="<?php esc_attr_e('image', 'socialv'); ?>" loading="lazy" />
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="bp-group-short-description-title socialv-profile-detail">
                <a href="<?php bp_activity_generated_content_part('group_url'); ?>">
                    <?php bp_activity_generated_content_part('group_name'); ?>
                </a>
                <div class="activity-group-meta">
                    <?php echo socialv()->socialv_activity_group_meta(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>