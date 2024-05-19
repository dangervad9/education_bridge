<?php

/**
 * Template part for displaying the Notification
 *
 * @package socialv
 */

use function SocialV\Utility\socialv;

$notication_count = '';
$total_notification = function_exists('bp_notifications_get_unread_notification_count') ? bp_notifications_get_unread_notification_count(get_current_user_id()) : '';
$socialv_options = get_option('socialv-options');
if (is_user_logged_in() && bp_has_notifications()) {
    $args1 = array(
        'user_id'      => bp_loggedin_user_id(),
        'per_page'     => $socialv_options['header_notification_limit'] ? $socialv_options['header_notification_limit'] : 10,
        'search_terms' => false,
        'is_new' => 1,
    );
    $args = $args1;

    if ($total_notification < 10) {
        $args2 = array(
            'user_id'      => bp_loggedin_user_id(),
            'per_page'     => $socialv_options['header_notification_limit'] ? $socialv_options['header_notification_limit'] : 10,
            'search_terms' => false,
            'is_new' => '',
        );
        $args = array_merge($args1, $args2);
    }
    $allNotifics = bp_has_notifications($args);
    $notication_count = 0;
    while (bp_the_notifications($allNotifics)) : bp_the_notification($allNotifics);
        global $bp;
        $is_read =  $bp->notifications->query_loop->notification->is_new;
        if ($is_read == true) {
            $notication_count = $notication_count + $is_read;
        }
    endwhile;
}
?>
<div class="dropdown dropdown-notifications">
    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="iconly-Notification icli" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php esc_attr_e('Notifications', 'socialv'); ?>"></i>
        <?php if ($notication_count > 0) : ?>
            <span class="notify-count"><?php echo esc_html(($notication_count > 9) ? '9+' : $notication_count); ?></span>
        <?php endif; ?>
    </button>

    <div class="dropdown-menu dropdown-menu-right">
        <div class="item-heading">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="heading-title"><?php esc_html_e('Notifications', 'socialv'); ?></h5>
                <?php if (is_user_logged_in() && bp_has_notifications()) : ?><a class="header-notification-setting" href="<?php echo esc_url(bp_core_get_user_domain(get_current_user_id()) . bp_get_settings_slug()) . '/notifications'; ?>"><i class="iconly-Setting icli"></i></a><?php endif; ?>
            </div>
        </div>
        <?php
        if (is_user_logged_in()) {
            $args1 = array(
                'user_id'      => bp_loggedin_user_id(),
                'per_page'     => $socialv_options['header_notification_limit'] ? $socialv_options['header_notification_limit'] : 10,
                'search_terms' => false,
                'is_new' => 1,
            );
            $args = $args1;

            if ($notication_count < 10) {
                $args2 = array(
                    'user_id'      => bp_loggedin_user_id(),
                    'per_page'     => $socialv_options['header_notification_limit'] ? $socialv_options['header_notification_limit'] : 10,
                    'search_terms' => false,
                    'is_new' => '',
                );
                $args = array_merge($args1, $args2);
            }
            $allNotifics = bp_has_notifications($args);
            if ($allNotifics) {
        ?>
                <div class="item-body">
                    <form method="post" id="notifications-bulk-management">
                        <?php while (bp_the_notifications($allNotifics)) : bp_the_notification($allNotifics);
                            global $bp;
                            $is_read =  $bp->notifications->query_loop->notification->is_new;
                        ?>
                            <div class="d-flex socialv-notification-box socialv-notification-info <?php echo esc_attr(($is_read == true) ? 'socialv-unread' : 'socialv-read'); ?>">
                                <?php socialv()->socialv_notification_avatar(); ?>
                                <div class="flex-grow-1 item-details ms-3">
                                    <p class="m-0 notification-text"><?php bp_the_notification_description(); ?></p>
                                    <div class="item-time"><?php bp_the_notification_time_since(); ?></div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </form>
                </div>
                <div class="item-footer">
                    <a href="<?php bp_notifications_permalink(); ?>" class="view-btn"><?php esc_html_e('View All Notifications', 'socialv'); ?></a>
                </div>
            <?php
            } else { ?>
                <div class="item-body">
                    <p class="no-message m-0"><?php esc_html_e('Sorry, no notification were found.', 'socialv'); ?></p>
                </div>
            <?php
            }
        } else { ?>
            <div class="item-body">
                <p class="no-message m-0"><?php esc_html_e('Sorry, no notification were found.', 'socialv'); ?></p>
            </div>
        <?php } ?>
    </div>
</div>