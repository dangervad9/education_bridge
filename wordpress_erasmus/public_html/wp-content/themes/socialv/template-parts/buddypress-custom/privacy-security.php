<?php

/**
 * Current user account privacy and security settings
 *
 * Override to change in privacy and security
 * 
 * @version 1.0.0
 */
defined('ABSPATH') || exit;

if (!is_user_logged_in()) return;

$member_id = bp_displayed_user_id();
$account_type = bp_get_user_meta($member_id, "socialv_user_account_type", true);

do_action('socialv_before_account_privacy_template');
?>

<div class="card-inner">
    <div id="template-notices" role="alert" aria-atomic="true">
        <?php do_action('template_notices'); ?>
    </div>
    <form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/privacy-and-security'; ?>" method="post" id="privacy-form">
        <div class="card-head card-header-border d-flex align-items-center justify-content-between">
            <div class="head-title">
                <h4 class="card-title"><?php esc_html_e('Account privacy', 'socialv'); ?></h4>
            </div>
        </div>
        <div class="notification-settings">
            <ul class="list-inline m-0">
                <li class="notification-data" id="members-account-privacy">
                    <div class="notification-title">
                        <input type="checkbox" name="account_type" value="private" class="socialv-account-type" <?php checked("private", $account_type); ?> />
                        <label for="socialv-account-type"><?php esc_html_e("Private account", "socialv"); ?></label>
                        <p class="mb-0">
                            <?php esc_html_e("When your account is private, only your friends can see your profile and activities.", "socialv"); ?>
                        </p>
                    </div>
                </li>
                <?php do_action('socialv_account_privacy_settings'); ?>
            </ul>
        </div>
        <?php do_action('socialv_members_notification_settings_before_submit'); ?>
        <div class="form-edit-btn">
            <div class="submit">
                <input type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'socialv'); ?>" id="submit" class="auto btn socialv-btn-success" />
            </div>
        </div>

        <?php do_action('socialv_members_notification_settings_after_submit'); ?>

        <?php wp_nonce_field('socialv_settings_account_privacy'); ?>

    </form>
</div>