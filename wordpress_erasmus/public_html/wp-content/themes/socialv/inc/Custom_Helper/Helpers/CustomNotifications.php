<?php

/**
 * SocialV\Utility\Custom_Helper\Helpers\Members class
 *
 * @package socialv
 */

namespace SocialV\Utility\Custom_Helper\Helpers;

use BP_Activity_Activity;
use BP_Notifications_Notification;
use SocialV\Utility\Custom_Helper\Component;
use function SocialV\Utility\socialv;
use function add_action;

class CustomNotifications  extends Component
{

    public function __construct()
    {
        add_filter('bp_notifications_get_registered_components', [$this, 'add_custom_notification_component']);
        add_filter('bp_notifications_get_notifications_for_user', [$this, 'custom_format_buddypress_notifications'], 9, 5);
        add_action('socialv_activity_shared', [$this, 'add_share_activity_user_notification'], 10, 2);
        remove_action("bbp_new_topic", "sv_new_topic_notification", 10);
        remove_action("bbp_new_reply", "sv_new_reply_notification", 10);
        add_action("bbp_new_topic", [$this, "socialv_new_topic_notification"], 10,4);
        add_action("bbp_new_reply", [$this, "socialv_new_reply_notification"], 10,5);
    }

    // notify forum subscribers
    function socialv_new_topic_notification($topic_id, $forum_id, $anonymous_data, $topic_author)
    {
        if (bp_is_active('notifications')) {
            $args['status']             = true;
            $args["component_name"]     = "forums";
            $args["component_action"]   = "sv_new_topic";
            $subscribers                = bbp_get_subscribers($forum_id);
            if (count($subscribers) > 0) {
                foreach ($subscribers as $subscriber_id) {
                    $args["user_to_notify"]     = $subscriber_id;
                    self::socialv_add_user_notification($topic_id, $args, $topic_author);
                }
            }
        }
    }

    // notify topic subscribers
    function socialv_new_reply_notification($reply_id, $topic_id, $forum_id, $anonymous_data, $reply_author)
    {
        if (bp_is_active('notifications')) {
            $args['status']             = true;
            $args["component_name"]     = "forums";
            $args["component_action"]   = "sv_new_topic_reply";
            $subscribers                = bbp_get_subscribers($topic_id);
            if (count($subscribers) > 0) {
                foreach ($subscribers as $subscriber_id) {
                    $args["user_to_notify"]     = $subscriber_id;
                    self::socialv_add_user_notification($reply_id, $args, $reply_author);
                }
            }
        }
    }

    function add_custom_notification_component($component_names = array())
    {
        // Force $component_names to be an array.
        if (!is_array($component_names)) {
            $component_names = array();
        }
        // Add 'custom' component to registered components array.
        array_push($component_names, 'socialv_activity_like_notification', 'socialv_share_post_notification');

        // Return component's with 'custom' appended.
        return $component_names;
    }

    function custom_format_buddypress_notifications($action, $item_id, $secondary_item_id, $total_items, $format = 'string')
    {
        if (!in_array($action, ['action_activity_liked', 'socialv_share_post', "sv_new_topic", "sv_new_topic_reply"]))
            return $action;
        if (!bp_is_active('activity') && $action != "sv_new_topic")
            return $action;

        $user_name      = bp_core_get_user_displayname($secondary_item_id);
        if ($total_items > 1) {
            $user_name .= sprintf(esc_html__(' And %d more users', 'socialv'), $total_items);
        }

        $args = [
            "action_activity_liked" => [
                "text"      => $user_name . esc_html__(' liked your post', 'socialv'),
                "filter"    => 'socialv_like_notification_string',
                "link"      => function_exists('bp_get_activity_directory_permalink') ? esc_url(bp_get_activity_directory_permalink() . "p/" . $item_id) : ''
            ],
            "socialv_share_post" => [
                "text"      => $user_name . esc_html__(' shared your post', 'socialv'),
                "filter"    => 'socialv_share_post_string',
                "link"      => function_exists('bp_get_activity_directory_permalink') ? esc_url(bp_get_activity_directory_permalink() . "p/" . $item_id) : ''
            ],
            "sv_new_topic" => [
                "text"      => sprintf(__('%s created new topic to %s', 'socialv'), $user_name, (function_exists('bbp_get_forum_title') ? bbp_get_forum_title(bbp_get_topic_forum_id($item_id)) : '')),
                "filter"    => 'socialv_new_topic_string',
                "link"      => get_permalink($item_id)
            ],
            "sv_new_topic_reply" => [
                "text"      => sprintf(__('%s replied to %s', 'socialv'), $user_name, (function_exists('bbp_get_topic_title') ? bbp_get_topic_title(bbp_get_reply_topic_id($item_id)) : '')),
                "filter"    => 'socialv_new_topic_string',
                "link"      => function_exists('bbp_get_reply_topic_id') ?  (get_permalink(bbp_get_reply_topic_id($item_id)) . "#post-" . $item_id) : ''
            ]
        ];

        $link    = $args[$action]["link"];
        $text    = $args[$action]["text"];
        $text    = "<a href='$link'>" . $text . "</a>";
        // WordPress Toolbar.

        if ('string' === $format) {
            return apply_filters($args[$action]["filter"], '' . $text . '', $text, $link);
        } else {
            return apply_filters($args[$action]["filter"], array(
                'text' => $text,
                'link' => $link
            ), $link, (int) $total_items, $text);
        }

        return $action;
    }

    static function socialv_add_user_notification($item_id, $args = [], $user_id = "")
    {
        $activity   = new BP_Activity_Activity($item_id);
        $user_id    = !empty($user_id) ? $user_id : get_current_user_id();

        if ($activity) {
            $user_to_notify = isset($args['activity_user_id']) ? $args['activity_user_id'] : $activity->user_id;
            $notify_user    = get_user_meta($user_to_notify, $args['enable_notification_key'], true);
            if ($notify_user == "no")
                return;
        }

        if (isset($args["user_to_notify"]))
            $user_to_notify = $args["user_to_notify"];

        if ($user_to_notify == $user_id)
            return;


        $notification_args = [
            'user_id'           => $user_to_notify,
            'item_id'           => $item_id,
            'secondary_item_id' => $user_id,
            'component_name'    => $args["component_name"],
            'component_action'  => $args["component_action"],
            'is_new'            => 1
        ];

        $existing = BP_Notifications_Notification::get($notification_args);

        if (!empty($existing) && !$args['status']) {
            return BP_Notifications_Notification::delete(array('id' => $existing[0]->id));
        } else {
            return bp_notifications_add_notification(array_merge($notification_args, ['date_notified' => bp_core_current_time()]));
        }
    }
    function add_share_activity_user_notification($activity_id, $shared_activity_id)
    {
        // notify-user
        if (bp_is_active('notifications')) {
            $args['status']                     = true;
            $args["component_name"]             = "socialv_share_post_notification";
            $args["component_action"]           = "socialv_share_post";
            $args['enable_notification_key']    = "notification_share_activity_post";
            $shared_activity = bp_activity_get(['in' => $shared_activity_id]);
            if (isset($shared_activity['activities'][0])) {
                $args["activity_user_id"] = $shared_activity['activities'][0]->user_id;
                self::socialv_add_user_notification($activity_id, $args);
            }
        }
    }
    function socialv_notification_avatar()
    {
        $notification = buddypress()->notifications->query_loop->notification;
        $component    = $notification->component_name;
        switch ($component) {
            case 'bp_verified_member':
                if ($notification->item_id === 0) {
                    $item_id = $notification->user_id;
                    $object  = 'user';
                }
                break;
            case 'groups':
                if (!empty($notification->item_id)) {
                    $item_id = $notification->item_id;
                    $object  = 'group';
                }
                break;
            case 'follow':
            case 'friends':
                if (!empty($notification->item_id)) {
                    $item_id = $notification->item_id;
                    $object  = 'user';
                }
                break;
            case has_action('bb_notification_avatar_' . $component):
                do_action('bb_notification_avatar_' . $component);
                break;
            default:
                if (!empty($notification->secondary_item_id)) {
                    $item_id = $notification->secondary_item_id;
                    $object  = 'user';
                } else {
                    $item_id = $notification->item_id;
                    $object  = 'user';
                }
                break;
        }
        if (isset($item_id, $object)) {
            $avatar_img = bp_core_fetch_avatar(
                array(
                    'item_id' => $item_id,
                    'object'  => $object,
                    'type'    => 'thumb',
                    'class' => 'avatar rounded-circle',
                    'width'         => 32,
                    'height'        => 32,
                )
            );
            if (!empty($avatar_img)) :
                echo '<span class="user-gap-img item-img"><div class="position-relative">' . $avatar_img;
                if ($object  === 'user') {
                    $user = new \WP_User($item_id); ?>
                    <span class="socialv-user-status <?php echo esc_attr(socialv()->socialv_is_user_online($user->ID)['status']); ?>"></span>
<?php
                }
                echo '</div></span>';
            endif;
        }
    }
}
