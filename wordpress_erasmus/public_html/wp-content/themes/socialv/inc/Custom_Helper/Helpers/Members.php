<?php

/**
 * SocialV\Utility\Custom_Helper\Helpers\Members class
 *
 * @package socialv
 */

namespace SocialV\Utility\Custom_Helper\Helpers;

use BP_Friends_Friendship;
use BP_XProfile_ProfileData;
use Exception;
use LP_Helper;
use LP_Profile;
use WC4BP_Loader;
use SocialV\Utility\Custom_Helper\Component;
use function add_action;
use function SocialV\Utility\socialv;

class Members  extends Component
{
    private $profileData;
    private $socialv_option;
    private $display_courses;
    private $display_req_btn;

    public function __construct()
    {
        if (class_exists('BP_XProfile_ProfileData')) {
            $this->profileData = new BP_XProfile_ProfileData();
        }
        $this->socialv_option  = $socialv_option = get_option('socialv-options');
        $this->display_courses = (class_exists('ReduxFramework') && class_exists('LearnPress') && $socialv_option['socialv_enable_profile_courses_tab'] == '1') ? true : false;
        $this->display_req_btn = (class_exists('ReduxFramework') && $socialv_option['display_user_request_btn'] == 'no') ? true : false;
        //Cover Image size set
        add_filter('bp_before_members_cover_image_settings_parse_args', array(&$this, 'socialv_xprofile_cover_image'), 10, 1);
        add_action('bp_directory_members_actions', [$this, 'socialv_get_current_user_profile_settings']);
        //Search Form
        add_filter('bp_directory_members_search_form', [$this, 'socialv_bp_directory_members_search_form']);
        add_filter('bp_message_search_form', [$this, 'socialv_bp_message_search_form']);

        // Navigation tab
        add_action('bp_setup_nav', [$this, 'socialv_change_bp_nav_position'], 100);
        add_action('bp_init', [$this, 'socialv_change_bp_nav_position'], 999);

        // Profile Page 
        add_action('socialv_before_members_content', [$this, 'socialv_before_members_content']);
        add_action('socialv_after_members_content', [$this, 'socialv_after_members_content']);
        //Header User Menu 
        add_action('socialv_user_profile_menu', [$this, 'socialv_user_profile_menu']);
        // edit Tabs
        add_action('socialv_account_menu_header_buttons', [$this, 'account_menu_header_buttons']);

        // Rename Account Tabs.
        add_action('bp_actions', [$this, 'rename_tabs'], 10);
        // Add Account Settings Pages.
        add_action('bp_actions', [$this, 'account_setting_menus']);
        add_action('socialv_settings_menus', [$this, 'settings_header']);

        // Account Notifications.
        remove_action('bp_notification_settings', 'bp_activity_screen_notification_settings', 1);
        remove_action('bp_notification_settings', 'messages_screen_notification_settings', 2);
        remove_action('bp_notification_settings', 'friends_screen_notification_settings');
        remove_action('bp_notification_settings', 'groups_screen_notification_settings');
        remove_action('bp_notification_settings', 'members_screen_notification_settings');
        add_action('bp_notification_settings', [$this, 'socialv_notification_settings']);

        // Notificaiton
        add_filter('bp_get_the_notification_mark_unread_link', [$this, 'socialv_bp_get_the_notification_mark_unread_link']);
        add_filter('bp_get_the_notification_mark_read_link', [$this, 'socialv_bp_get_the_notification_mark_read_link']);
        add_filter('bp_get_the_notification_delete_link', [$this, 'socialv_bp_get_the_notification_delete_link']);

        // Invitation Link
        add_filter('bp_get_the_members_invitation_resend_link', [$this, 'socialv_bp_get_the_members_invitation_resend_link']);
        add_filter('bp_get_the_members_invitation_delete_link', [$this, 'socialv_bp_get_the_members_invitation_delete_link']);


        // Friends Action Button
        add_action("init", function () {
            remove_action('wp_ajax_addremove_friend', 'bp_legacy_theme_ajax_addremove_friend');
            remove_action('wp_ajax_nopriv_addremove_friend', 'bp_legacy_theme_ajax_addremove_friend');
            remove_action('bp_member_header_actions',    'bp_send_public_message_button',  20);
            remove_action('bp_member_header_actions',    'bp_send_private_message_button', 20);
            if (bp_is_active('friends') && $this->display_req_btn == 'true')
                remove_action('bp_member_header_actions',    'bp_add_friend_button',           5);
        });
        if (!class_exists('BP_Better_Messages')) {
            add_action("bp_member_header_actions", [$this, "socialv_member_header_action"]);
        }
        add_action('wp_ajax_addremove_friend', [$this, 'bp_legacy_theme_ajax_addremove_friend']);
        add_action('wp_ajax_nopriv_addremove_friend', [$this, 'bp_legacy_theme_ajax_addremove_friend']);
        add_filter('bp_get_add_friend_button', [$this, 'socialv_bp_get_add_friend_button'], 10, 1);

        // custom ajax friend request accept/reject
        add_action('wp_ajax_socialv_ajax_addremove_friend', [$this, 'socialv_ajax_addremove_friend']);
        add_action('wp_ajax_nopriv_socialv_ajax_addremove_friend', [$this, 'socialv_ajax_addremove_friend']);

        //Forum
        if (class_exists('bbPress')) {
            add_filter('bbp_get_reply_class', [$this, 'socialv_bbp_get_reply_class']);
        }
        //Badges
        if (function_exists('GamiPress')) {
            add_filter('gamipress_get_achievement_earners_list',  [$this,  'socialv_gamipress_get_achievement_earners_list'], 10, 4);
            add_filter('gamipress_get_rank_earners_list',  [$this,  'socialv_gamipress_get_rank_earners_list'], 10, 4);
            add_filter('gamipress_points_classes', [$this,  'socialv_gamipress_points_classes'], 10, 3);
            add_filter('gamipress_rank_requirements_heading', [$this, 'socialv_gamipress_rank_requirements_heading'], 10, 2);
            add_filter('gamipress_rank_unlock_with_points_markup', [$this, 'socialv_gamipress_rank_unlock_with_points_markup'], 10, 6);
            remove_action('bp_before_member_header_meta', 'gamipress_bp_before_member_header');
        }

        //member media active menu 
        if (class_exists('mediapress'))
            $this->socialv_media_nav_menu_links_filter();

        add_filter('bp_core_fetch_avatar_no_grav', '__return_true');
        add_filter('bp_get_activities_member_rss_link', function ($link) {
            if (empty(trim($link)))
                $link = "#";

            return $link;
        });

        if (class_exists('WooCommerce')) {
            add_action("wc4bp_screen_settings", function () {
                remove_action('bp_template_content', 'wc4bp_screen_settings_content');
                add_action('bp_template_content',  [$this,  'socialv_screen_settings_content']);
            });
        }

        // user privacy and security settings nav menu
        add_action('bp_settings_setup_nav', [$this, 'socialv_privacy_and_security_settings']);
        remove_filter('bp_activity_get_where_conditions', 'sv_exclude_private_user_activities');
        add_filter('bp_activity_get_where_conditions', [$this, 'socialv_exclude_private_user_activities']);
        add_action('bp_actions', [$this, 'socialv_settings_action_notifications']);
        add_action('socialv_user_private_content', [$this, 'socialv_user_private_content']);
    }

    function socialv_media_nav_menu_links_filter()
    {
        $nav_lists = ["type/photo", "type/video", "type/audio", "type/doc"];
        $bp = buddypress();
        foreach ($nav_lists as $nav) {

            add_filter('bp_get_options_nav_' . $nav, function ($link, $subnav_item, $selected_item) use ($nav, $bp) {
                $current_menu[] = ($bp && $bp->action_variables) ? 'type/' . $bp->action_variables[0] : '';
                $current_menu[] = mediapress()->current_gallery ? 'type/' . mpp_get_gallery_type() : '';
                if (in_array($nav, $current_menu)) {
                    $list_type = bp_is_group() ? 'groups' : 'personal';
                    $link = '<li id="' . esc_attr($subnav_item->css_id . '-' . $list_type . '-li') . '" class="current selected"><a id="' . esc_attr($subnav_item->css_id) . '" href="' . esc_url($subnav_item->link) . '">' . $subnav_item->name . '</a></li>';
                }
                return $link;
            }, 10, 3);
        }
    }
    public function socialv_xprofile_cover_image($settings = array())
    {
        $settings['width']  = 1920;
        $settings['height'] = 400;
        return $settings;
    }


    public function bp_legacy_theme_ajax_addremove_friend()
    {
        if (!bp_is_post_request()) {
            return;
        }

        // Cast fid as an integer.
        $friend_id = (int) $_POST['fid'];

        $user = get_user_by('id', $friend_id);
        if (!$user) {
            die(esc_html__('No member found by that ID.', 'socialv'));
        }

        // Trying to cancel friendship.
        if ('is_friend' == \BP_Friends_Friendship::check_is_friend(bp_loggedin_user_id(), $friend_id)) {
            check_ajax_referer('friends_remove_friend');

            if (!friends_remove_friend(bp_loggedin_user_id(), $friend_id)) {
                echo esc_html__('Friend could not be canceled.', 'socialv');
            } else {
                echo '<a id="friend-' . esc_attr($friend_id) . '" class="friendship-button not_friends add btn btn-sm socialv-btn-success text-capitalize" rel="add" href="' . wp_nonce_url(bp_loggedin_user_domain() . bp_get_friends_slug() . '/add-friend/' . $friend_id, 'friends_add_friend') . '">' . esc_html__('Add Friend', 'socialv') . '</a>';
            }

            // Trying to request friendship.
        } elseif ('not_friends' == \BP_Friends_Friendship::check_is_friend(bp_loggedin_user_id(), $friend_id)) {
            check_ajax_referer('friends_add_friend');

            if (!friends_add_friend(bp_loggedin_user_id(), $friend_id)) {
                echo esc_html__(' Friend could not be requested.', 'socialv');
            } else {
                echo '<a id="friend-' . esc_attr($friend_id) . '" class="remove friendship-button pending_friend requested btn btn-sm socialv-btn-danger text-capitalize" rel="remove" href="' . wp_nonce_url(bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests/cancel/' . $friend_id . '/', 'friends_withdraw_friendship') . '" class="requested">' . esc_html__('Cancel Request', 'socialv') . '</a>';
            }

            // Trying to cancel pending request.
        } elseif ('pending' == \BP_Friends_Friendship::check_is_friend(bp_loggedin_user_id(), $friend_id)) {
            check_ajax_referer('friends_withdraw_friendship');

            if (friends_withdraw_friendship(bp_loggedin_user_id(), $friend_id)) {
                echo '<a id="friend-' . esc_attr($friend_id) . '" class="friendship-button not_friends add btn btn-sm socialv-btn-success text-capitalize" rel="add" href="' . wp_nonce_url(bp_loggedin_user_domain() . bp_get_friends_slug() . '/add-friend/' . $friend_id, 'friends_add_friend') . '">' . esc_html__('Add Friend', 'socialv') . '</a>';
            } else {
                echo esc_html__("Friend request could not be cancelled.", 'socialv');
            }

            // Request already pending.
        } else {
            echo esc_html__('Request Pending', 'socialv');
        }

        exit;
    }

    function socialv_ajax_addremove_friend()
    {
        $response = array(
            'feedback' => sprintf(
                '<div class="bp-feedback error bp-ajax-message"><p>%s</p></div>',
                esc_html__('Something went wrong. Please try again.', 'socialv')
            ),
        );
        // Bail if not a POST action.
        if (!bp_is_post_request()) {
            wp_send_json_error($response);
        }

        if (empty($_POST['friendship_id']) || !bp_is_active('friends')) {
            wp_send_json_error($response);
        }

        // Cast fid as an integer.
        $friend_id = (int) $_POST['friendship_id'];

        // Check if the user exists only when the Friend ID is not a Frienship ID.
        if (isset($_POST['data_action']) && $_POST['data_action'] !== 'friends_accept_friendship' && $_POST['data_action'] !== 'friends_reject_friendship') {
            $user = get_user_by('id', $friend_id);
            if (!$user) {
                wp_send_json_error(
                    array(
                        'feedback' => sprintf(
                            '<div class="bp-feedback error">%s</div>',
                            esc_html__('No member found by that ID.', 'socialv')
                        ),
                    )
                );
            }
        }

        // In the 2 first cases the $friend_id is a friendship id.
        if (!empty($_POST['data_action']) && 'friends_accept_friendship' === $_POST['data_action']) {
            if (!friends_accept_friendship($friend_id)) {
                wp_send_json_error(
                    array(
                        'feedback' => sprintf(
                            '<div class="bp-feedback error">%s</div>',
                            esc_html__('There was a problem accepting that request. Please try again.', 'socialv')
                        ),
                    )
                );
            } else {
                wp_send_json_success(
                    array(
                        'feedback' => sprintf(
                            '<div class="bp-feedback success">%s</div>',
                            esc_html__('Friendship accepted.', 'socialv')
                        ),
                        'type'     => 'success',
                        'is_user'  => true,
                    )
                );
            }

            // Rejecting a friendship
        } elseif (!empty($_POST['data_action']) && 'friends_reject_friendship' === $_POST['data_action']) {
            if (!friends_reject_friendship($friend_id)) {
                wp_send_json_error(
                    array(
                        'feedback' => sprintf(
                            '<div class="bp-feedback error">%s</div>',
                            esc_html__('There was a problem rejecting that request. Please try again.', 'socialv')
                        ),
                    )
                );
            } else {
                wp_send_json_success(
                    array(
                        'feedback' => sprintf(
                            '<div class="bp-feedback success">%s</div>',
                            esc_html__('Friendship rejected.', 'socialv')
                        ),
                        'type'     => 'success',
                        'is_user'  => true,
                    )
                );
            }
        }
    }

    function socialv_bp_get_add_friend_button($button_args)
    {
        $button_args = array();

        if (bp_is_user()) {
            $potential_friend_id = bp_displayed_user_id();
        } else {
            $potential_friend_id = bp_get_member_user_id();
        }

        if (empty($potential_friend_id)) {
            $potential_friend_id = bp_get_potential_friend_id($potential_friend_id);
        }

        $friendship_status = bp_is_friend($potential_friend_id);

        if (empty($friendship_status)) {
            return $button_args;
        }
        switch ($friendship_status) {
            case 'pending':
                $button_args = array(
                    'id'                => 'pending',
                    'component'         => 'friends',
                    'must_be_logged_in' => true,
                    'block_self'        => true,
                    'wrapper_class'     => 'friendship-button pending_friend',
                    'wrapper_id'        => 'friendship-button-' . $potential_friend_id,
                    'link_href'         => wp_nonce_url(bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests/cancel/' . $potential_friend_id . '/', 'friends_withdraw_friendship'),
                    'link_text'         => __('Cancel Request', 'socialv'),
                    'link_title'        => __('Cancel Request', 'socialv'),
                    'link_id'           => 'friend-' . $potential_friend_id,
                    'link_rel'          => 'remove',
                    'link_class'        => 'friendship-button pending_friend requested btn btn-sm socialv-btn-danger text-capitalize',
                );
                break;

            case 'awaiting_response':
                $button_args = array(
                    'id'                => 'awaiting_response',
                    'component'         => 'friends',
                    'must_be_logged_in' => true,
                    'block_self'        => true,
                    'wrapper_class'     => 'friendship-button awaiting_response_friend',
                    'wrapper_id'        => 'friendship-button-' . $potential_friend_id,
                    'link_href'         => bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests/',
                    'link_text'         => __('Accept Request', 'socialv'),
                    'link_title'        => __('Accept Request', 'socialv'),
                    'link_id'           => 'friend-' . $potential_friend_id,
                    'link_rel'          => 'remove',
                    'link_class'        => 'friendship-button awaiting_response_friend requested btn btn-sm socialv-btn-primary text-capitalize',
                );
                break;

            case 'is_friend':
                $button_args = array(
                    'id'                => 'is_friend',
                    'component'         => 'friends',
                    'must_be_logged_in' => true,
                    'block_self'        => false,
                    'wrapper_class'     => 'friendship-button is_friend',
                    'wrapper_id'        => 'friendship-button-' . $potential_friend_id,
                    'link_href'         => wp_nonce_url(bp_loggedin_user_domain() . bp_get_friends_slug() . '/remove-friend/' . $potential_friend_id . '/', 'friends_remove_friend'),
                    'link_text'         => __('Unfriend', 'socialv'),
                    'link_title'        => __('Unfriend', 'socialv'),
                    'link_id'           => 'friend-' . $potential_friend_id,
                    'link_rel'          => 'remove',
                    'link_class'        => 'friendship-button is_friend remove btn btn-sm socialv-btn-orange text-capitalize',
                );
                break;

            default:
                $button_args = array(
                    'id'                => 'not_friends',
                    'component'         => 'friends',
                    'must_be_logged_in' => true,
                    'block_self'        => true,
                    'wrapper_class'     => 'friendship-button not_friends',
                    'wrapper_id'        => 'friendship-button-' . $potential_friend_id,
                    'link_href'         => wp_nonce_url(bp_loggedin_user_domain() . bp_get_friends_slug() . '/add-friend/' . $potential_friend_id . '/', 'friends_add_friend'),
                    'link_text'         => __('Add Friend', 'socialv'),
                    'link_title'        => __('Add Friend', 'socialv'),
                    'link_id'           => 'friend-' . $potential_friend_id,
                    'link_rel'          => 'add',
                    'link_class'        => 'friendship-button not_friends add btn btn-sm socialv-btn-success text-capitalize',
                );
                break;
        }
        return $button_args;
    }


    function socialv_bp_directory_members_search_form()
    {
        $query_arg = bp_core_get_component_search_query_arg('members');

        if (!empty($_REQUEST[$query_arg])) {
            $search_value = stripslashes($_REQUEST[$query_arg]);
        } else {
            $search_value = bp_get_search_default_text('members');
        }
        $search_form_html = '<div class="socialv-bp-searchform"><form action="#" method="get" id="search-members-form">
          <div class="search-input"><input type="text" class="form-control" name="s" id="members_search" placeholder="' . esc_attr($search_value) . '" />
          <button type="submit" id="members_search_submit" class="btn-search"  name="members_search_submit"><i class="iconly-Search icli"></i></button>
          </div></form></div>';
        return $search_form_html;
    }

    function socialv_bp_message_search_form()
    {
        $default_search_value = bp_get_search_default_text('messages');

        $search_submitted     = !empty($_REQUEST['s']) ? stripslashes($_REQUEST['s']) : $default_search_value;
        $search_placeholder   = ($search_submitted === $default_search_value) ? ' placeholder="' .  esc_attr($search_submitted) . '"' : '';
        $search_value         = ($search_submitted !== $default_search_value) ? ' value="'       .  esc_attr($search_submitted) . '"' : '';

        ob_start();
        $search_form_html = '<div class="socialv-bp-searchform"><form action="#" method="get" id="search-message-form"><div class="search-input"><input type="text" class="form-control" name="s" id="messages_search" ' . $search_placeholder . $search_value . ' />
        <button type="submit" id="messages_search_submit" class="btn-search"  name="messages_search_submit" /><i class="iconly-Search icli"></i></button>
        </div></form></div>';
        return $search_form_html;
    }


    /**
     * Get the verified badge HTML.
     *
     * @return string The badge HTML.
     */
    public function socialv_get_verified_badge($user_id)
    {
        $verified = get_user_meta($user_id, 'bp_verified_member', true);
        if ($verified == 1) {
            return apply_filters('bp_verified_member_verified_badge', '<span class="bp-verified-badge"></span>');
        }
    }

    // User Check Online Status
    public function socialv_is_user_online($user_id)
    {
        $last_activity = bp_get_user_last_activity($user_id);
        $curr_time = time();
        $diff = $curr_time - strtotime($last_activity);
        $time = 5 * 60; // must be in seconds
        if (!empty(is_user_logged_in()) && $diff < $time) {
            $status_text = esc_html__('online', 'socialv');
            $status = 'online';
        } else {
            $status_text = esc_html__('offline', 'socialv');
            $status = 'offline';
        }
        // Apply user_status filter
        return array('status' => $status, 'status_text' => $status_text);
    }


    function bp_custom_get_send_private_message_link($to_id, $subject = false, $message = false)
    {
        //if user is not logged, do not prepare the link
        if (!is_user_logged_in())
            return false;

        $compose_url = bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?';
        if ($to_id)
            $compose_url .= ('r=' . bp_core_get_username($to_id));
        if ($subject)
            $compose_url .= ('&subject=' . $subject);
        if ($message)
            $compose_url .= ('&content=' . $message);

        return wp_nonce_url($compose_url);
    }

    //User Social
    function socialv_member_social_socials_info($user_id)
    {
        $social_icon_array = [
            'Facebook'         => 'icon-facebook',
            'Twitter'            => 'icon-twitter',
            'Dribbble'     => 'icon-dribbble',
            'Behance'     => 'icon-behance',
            'YouTube'     => 'icon-youtube',
            'Instagram'     => 'icon-instagram',
            'Googleplus'     => 'icon-googleplus',
            'linkedin'     => 'icon-linkedin',
            'Pinterest'     => 'icon-pinterest',
            'Flickr'     => 'icon-flickr',
            'Skype'     => 'icon-skype',
            'RSS'     => 'icon-rss',
            'Telegram'  => 'icon-telegram',
            'Snapchat'  => 'icon-snapchat',
            'Email'  => 'icon-email'
        ];
?>
        <div class="socialv-profile-left col-lg-4">
            <?php
            // Points
            if (function_exists('GamiPress') && function_exists('gamipress_bp_get_option')) :
                $points_placement = gamipress_bp_get_option('points_placement', array());
                $points_type = gamipress_bp_get_option('members_points_types', array());
                $points_type = implode(',', $points_type);
                if (in_array('top', $points_placement)) {
                    echo do_shortcode('[gamipress_points type=' . $points_type . ' user_id=' . $user_id . ']');
                }
            endif;
            ?>
            <ul class="item-social list-inline">
                <?php if (class_exists('BP_XProfile_ProfileData') && $this->profileData) {
                    foreach ($social_icon_array as $key => $value) :
                        $hidden_fields = bp_xprofile_get_hidden_fields_for_user();
                        $field_id = xprofile_get_field_id_from_name($key);
                        $social_field_value = $this->profileData::get_value_byid($field_id, $user_id);
                        if (!empty($social_field_value) && !in_array(xprofile_get_field_id_from_name($key), $hidden_fields)) : ?>
                            <li class="<?php echo esc_attr($key); ?>"><a href="<?php echo esc_url($social_field_value); ?>" target="_blank"><i class="<?php echo esc_attr($value); ?>"></i></a></li>
                <?php endif;
                    endforeach;
                } ?>
            </ul>
        </div>
    <?php }


    // User Comments
    function socialv_count_user_comments($user_id)
    {
        $args = [
            'display_comments' => 'stream',
            'filter'           => [
                'user_id' => $user_id,
                'object'  => [
                    'activity',
                    'groups'
                ],
                'action'  => [
                    'activity_comment'
                ]
            ]
        ];
        return count(bp_activity_get($args)['activities']);
    }

    function countFormat($num)
    {
        if ($num > 1000) {

            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('K', 'M', 'B', 'T');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];
            return $x_display;
        }
        return $num;
    }

    //User Posts
    function socialv_get_total_post_updates_count()
    {
        global $wpdb, $bp;
        $user_id = 0;
        if (bp_displayed_user_id()) {
            $user_id = bp_displayed_user_id();
        }

        $query = "SELECT COUNT(*) as count FROM {$bp->activity->table_name} 
        WHERE component IN ('activity','groups') 
        AND  type IN ('activity_update','mpp_media_upload')
        AND hide_sitewide = 0
        AND   user_id=$user_id";

        $query = apply_filters("socialv_total_updates_count_query", $query);

        $total_posts = $wpdb->get_results($query);
        $post_count = apply_filters("socialv_total_updates_counts", $total_posts[0]->count);
        if (!empty($total_posts)) {
            echo esc_html($post_count);
        }
    }

    // User views
    function socialv_set_postviews($user_id)
    {
        $count_key = 'post_views_count';
        $count = get_post_meta($user_id, $count_key, true);

        if ($count == '') {
            $count = 0;
            delete_post_meta($user_id, $count_key);
            add_post_meta($user_id, $count_key, '0');
            return $count;
        } else {
            $count++;
            update_post_meta($user_id, $count_key, $count);
            if ($count == '1') {
                return $count;
            } else {
                return $count;
            }
        }
    }

    function socialv_get_postviews($user_id)
    {
        $count_key = 'post_views_count';
        $count = $this->countFormat(get_post_meta($user_id, $count_key, true));
        echo esc_html($count);
    }

    public function socialv_change_bp_nav_position()
    {
        $nav = buddypress()->members->nav;

        $nav->edit_nav(array(
            'name' => esc_html__('Timeline', 'socialv'),
            'position' => 10,
        ), 'activity');
        $nav->edit_nav(array(
            'name' => esc_html__('About', 'socialv'),
            'position' => 20,
        ), 'profile');
        $nav->edit_nav(array(
            'position' => 30,
        ), 'friends');
        $nav->edit_nav(array(
            'position' => 40,
        ), 'groups');
        $nav->edit_nav(array(
            'position' => 60,
        ), 'badges');
        $nav->edit_nav(array(
            'name' => esc_html__('All Update', 'socialv'),
        ), 'just-me', 'activity');

        // Media
        if (class_exists('mediapress')) {
            $nav->edit_nav(array(
                'name' => esc_html__('Media', 'socialv')
            ), MPP_GALLERY_SLUG);
            $nav->edit_nav(array(
                'name' => esc_html__('All', 'socialv')
            ), 'my-galleries', MPP_GALLERY_SLUG);

            bp_core_remove_subnav_item(MPP_GALLERY_SLUG, 'create');
        }
        if ($this->display_courses == true) {
            bp_core_new_nav_item(array(
                'name' => esc_html__('Courses', 'socialv'),
                'slug' => 'courses',
                'position' => 60,
                'screen_function' => array($this, 'learnpress_load_template'),
                'parent_url'      => bp_loggedin_user_domain() . '/courses/',
                'parent_slug'     => buddypress()->profile->slug,
                'default_subnav_slug' => 'courses'
            ));
        }
    }

    //Profile Page Edit Form
    function account_menu_header_buttons()
    {
        // Get Data.
        $user_id = bp_displayed_user_id();
        $member_year = date('Y', strtotime(get_the_author_meta('user_registered', $user_id)));
        $profile_url = bp_core_get_user_domain($user_id) . bp_get_profile_slug() . '/';
        $header_buttons = array(
            'home' => array(
                'icon' => 'iconly-Home icli',
                'title' => esc_html__('Home', 'socialv'),
                'url' => home_url(),
                'slug' => 'home',
            ),
            'profile' => array(
                'icon' => 'iconly-Profile icli',
                'title' => esc_html__('View Profile', 'socialv'),
                'url' => bp_core_get_user_domain($user_id),
                'slug' => 'profile',
            ),
            'messages' => array(
                'icon' => 'iconly-Message icli',
                'title' => esc_html__('Messages', 'socialv'),
                'url' =>  bp_core_get_user_domain($user_id) . 'messages',
                'slug' => 'messages',
            ),
            'avatar' => array(
                'icon' => 'iconly-Upload icli',
                'title' => esc_html__('Profile Avatar', 'socialv'),
                'url' => $profile_url . 'change-avatar',
                'slug' => 'change-avatar',
            ),
            'cover' => array(
                'icon' => 'iconly-Image icli',
                'title' => esc_html__('Profile Cover', 'socialv'),
                'url' => $profile_url . 'change-cover-image',
                'slug' => 'change-cover-image',
            ),
            'logout' => array(
                'url' => wp_logout_url(),
                'icon' => 'iconly-Logout icli',
                'title' => esc_html__('Logout', 'socialv'),
                'slug' => 'logout',
            )
        );

        if (!buddypress()->avatar->show_avatars) {
            if (isset($header_buttons['avatar'])) {
                unset($header_buttons['avatar']);
            }
        }

        if (!bp_displayed_user_use_cover_image_header()) {
            if (isset($header_buttons['cover'])) {
                unset($header_buttons['cover']);
            }
        }
        // Get Class Name.
        $current = bp_current_action();
    ?>
        <div class="card-main">
            <div class="card-inner">
                <div class="socialv-account-head">
                    <div class="socialv-account-img">
                        <?php echo bp_core_fetch_avatar(array('item_id' => $user_id, 'type' => 'full', 'width' => '80', 'height'  => '80', 'class' => 'avatar rounded')); ?>
                    </div>
                    <div class="socialv-account-head-content">
                        <h4><?php echo bp_get_displayed_user_fullname(); ?></h4>
                        <span><?php printf(esc_html__('Member since %1$s', 'socialv'), $member_year); ?></span>
                    </div>
                </div>

                <div class="socialv-head-buttons">
                    <ul class="socialv-head-buttons-inner list-inline m-0">
                        <?php foreach ($header_buttons as $key => $button) :
                            // Get Menu Class Name.
                            $active_class = ($current == $button['slug']) ? ' current' : null;
                        ?>
                            <li class="socialv-button-item socialv-<?php echo esc_attr($key); ?>-button <?php echo esc_attr($active_class); ?>"><a href="<?php echo esc_url($button['url']); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo esc_attr($button['title']); ?>"><i class="<?php echo esc_attr($button['icon']); ?>"></i></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }

    function settings_header()
    {
        $this->account_menu();
    }

    /**
     * Settings Actions.
     */
    function rename_tabs()
    {

        if (bp_is_active('settings')) {
            $bp = buddypress();

            // Get Settings Slug.
            $settings_slug = bp_get_settings_slug();
            // Change Notifications Title from "Email" to "Notifications".
            $bp->members->nav->edit_nav(array('name' => esc_html__('Notifications', 'socialv')), 'notifications', $settings_slug);

            global $current_user; //get the current user

            if (bp_loggedin_user_id() && in_array("demo-user", $current_user->roles)) {
                bp_core_remove_subnav_item('settings', 'general');
            } else {
                $bp->members->nav->edit_nav(array('name' => esc_html__('Email & Password', 'socialv'),  'position' => 1), 'general', $settings_slug);
            }
        }
    }

    /**
     * Setup Widget Settings Pages.
     */
    function account_setting_menus()
    {

        if (!bp_core_can_edit_settings()) {
            return false;
        }

        global $bp;
        $user_id = bp_displayed_user_id();
        if (bp_is_active('settings')) {
            if (apply_filters('socialv_create_account_settings_page', true)) {

                $settings_url = bp_core_get_user_domain($user_id) . bp_get_settings_slug();
                $settings_slug = bp_get_settings_slug();
                $is_super_admin = is_super_admin(bp_displayed_user_id());

                global $current_user; //get the current user
                if (bp_loggedin_user_id() && isset($current_user->roles) && in_array('demo-user', $current_user->roles)) {
                    $userlogin = $current_user->ID;
                } else {
                    $userlogin = '';
                }
                foreach ($this->account_settings_pages() as $slug => $page) {

                    // Get Navbar Args
                    $nav_args = array(
                        'slug' => $slug,
                        'name' => $page['name'],
                        'parent_url' => $settings_url,
                        'parent_slug' => $settings_slug,
                        'screen_function' => array($this, 'load_template'),
                    );
                    if ('delete-account' == $slug) {
                        $nav_args['user_has_access'] = $is_super_admin || !$userlogin;
                    }
                }
                bp_core_new_subnav_item($nav_args);
            }
        }

        unset($page);
    }
    /**
     * Load Template.
     */
    function load_template()
    {
        bp_core_load_template('buddypress/members/single/plugins');
    }

    /**
     * Account Settings Menu.
     */
    function account_menu()
    {
        // Get Menu Data.
        $menu_settings = array(
            'slug'        => 'settings',
            'menu_list'  => $this->account_settings_pages(),
            'menu_title' => esc_html__('Account Settings', 'socialv')
        );

        $this->get_menu($menu_settings, 'settings');
    }
    /**
     * Menu Content
     */
    function get_menu($args, $current_component)
    {
        // Get Menu.
        $menu = $args['menu_list'];

        // Get Current Page.
        $current = bp_current_action();


        $current_widget = $current;

        // Get Buddypress Variables.
        $bp = buddypress();

        // Get Tab Navigation  Menu
        $account_nav = $bp->members->nav->get_secondary(array('parent_slug' => $current_component));

        if (empty($account_nav)) {
            return;
        }

        // Show Menu
        echo "<ul class='list-inline m-0'>";

        // Hide Following Pages For Menus.
        $hide_pages = array('classic', 'home', 'social-networks', 'change-avatar', 'change-cover-image');

        $user_id = bp_displayed_user_id();

        // Get Menu.
        foreach ($account_nav as $page) {

            // Get Page Slug.
            $slug = $page['slug'];

            // Hide Pages & Hide Tab if user has no access
            if (in_array($slug, $hide_pages) || empty($page['user_has_access']) || 'edit' == $slug) {
                continue;
            }

            // Get Menu Class Name.
            $menu_class = ($current_widget == $slug) ? 'class=current' : null;

            // Get Page Url.
            if (isset($page['group_slug'])) {
                $page_url = trailingslashit(bp_displayed_user_domain() . $page['group_slug']);
            } elseif ('settings' == $args['slug']) {
                $page_url =  bp_core_get_user_domain($user_id) . bp_get_settings_slug() . '/' . $slug;
            }

            // Get Icon
            echo '<li ' . $menu_class .  '>';
            echo "<a href='$page_url'>{$page['name']}</a>";
            echo '</li>';
        }

        echo '</ul>';
    }
    /**
     * Account Settings Pages.
     */
    function account_settings_pages()
    {
        // Init Pages.
        $pages = array();

        // Add Spam Account nav item.
        if (bp_current_user_can('bp_moderate') && !bp_is_my_profile()) {

            $pages['capabilities'] = array(
                'name'    => esc_html__('Capabilities Settings', 'socialv'),
                'icon'    => 'iconly-Setting icli',
                'order'    => 50
            );
        }


        if (apply_filters('bp_settings_show_user_data_page', true)) {

            $pages['data'] = array(
                'name'    => esc_html__('Export Data', 'socialv'),
                'icon'    => 'iconly-Chart icli',
                'order'    => 80
            );
        }

        if ((!bp_disable_account_deletion() && bp_is_my_profile()) || bp_current_user_can('delete_users')) {
            $pages['delete-account'] = array(
                'name'    => esc_html__('Delete Account', 'socialv'),
                'icon'    => 'iconly-Delete icli',
                'order'    => 60
            );
        }

        return apply_filters('socialv_account_settings_pages', $pages);
    }


    function socialv_notification_settings()
    {
        // Bail early if invitations and requests are not allowed--they are the only members notification so far.
        if (!bp_get_members_invitations_allowed() && (!bp_get_membership_requests_required() || !user_can(bp_displayed_user_id(), 'bp_moderate'))) {
            return;
        }
        if (bp_get_members_invitations_allowed()) :
            if (!$allow_acceptance_emails = bp_get_user_meta(bp_displayed_user_id(), 'notification_members_invitation_accepted', true)) {
                $allow_acceptance_emails = 'yes';
            }
        ?>
            <li class="notification-data" id="members-notification-settings-invitation_accepted">
                <div class="notification-title">
                    <h6><?php esc_html_e('Someone accepts your membership invitation', 'socialv'); ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-members-invitation-accepted-yes"><input type=radio name="notifications[notification_members_invitation_accepted]" id="notification-members-invitation-accepted-yes" value="yes" <?php checked($allow_acceptance_emails, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-members-invitation-accepted-no"><input type=radio name="notifications[notification_members_invitation_accepted]" id="notification-members-invitation-accepted-no" value="no" <?php checked($allow_acceptance_emails, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
        <?php
        endif;
        if (bp_get_membership_requests_required() && user_can(bp_displayed_user_id(), 'bp_moderate')) :
            if (!$allow_request_emails = bp_get_user_meta(bp_displayed_user_id(), 'notification_members_membership_request', true)) {
                $allow_request_emails = 'yes';
            }
        ?>
            <li class="notification-data" id="members-notification-settings-submitted_membership_request">
                <div class="notification-title">
                    <h6><?php echo esc_html_x('Someone has requested site membership', 'Member settings on notification settings page', 'socialv') ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-members-submitted_membership_request-yes"><input type=radio name="notifications[notification_members_membership_request]" id="notification-members-submitted_membership_request-yes" value="yes" <?php checked($allow_request_emails, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-members-submitted_membership_request-no"><input type=radio name="notifications[notification_members_membership_request]" id="notification-members-submitted_membership_request-no" value="no" <?php checked($allow_request_emails, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
            <?php
        endif;
        // Activity Notifications.
        if (bp_is_active('activity')) :
            if (bp_activity_do_mentions()) {
                if (!$mention = bp_get_user_meta(bp_displayed_user_id(), 'notification_activity_new_mention', true)) {
                    $mention = 'yes';
                }
            }

            if (!$reply = bp_get_user_meta(bp_displayed_user_id(), 'notification_activity_new_reply', true)) {
                $reply = 'yes';
            }
            if (bp_activity_do_mentions()) : ?>
                <li class="notification-data" id="activity-notification-settings-mentions">
                    <div class="notification-title">
                        <h6><?php esc_html_e('Mentions Notifications', 'socialv'); ?></h6>
                    </div>
                    <div class="notification-switch">
                        <span class="radio-switch">
                            <label class="notification-activity-new-mention-yes"><input type=radio name="notifications[notification_activity_new_mention]" value="yes" <?php checked($mention, 'yes', true) ?> />
                                <span><i class="icon-dash"></i></span>
                            </label><label class="notification-activity-new-mention-no"><input type=radio name="notifications[notification_activity_new_mention]" value="no" <?php checked($mention, 'no', true) ?> />
                                <span><i class="icon-dash"></i></span>
                            </label>
                        </span>
                    </div>
                </li>
            <?php endif; ?>
            <li class="notification-data" id="activity-notification-settings-replies">
                <div class="notification-title">
                    <h6><?php esc_html_e('Replies Notifications', 'socialv'); ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-activity-new-reply-yes"><input type=radio name="notifications[notification_activity_new_reply]" value="yes" <?php checked($reply, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-activity-new-reply-no"><input type=radio name="notifications[notification_activity_new_reply]" value="no" <?php checked($reply, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
            <?php
            if (!$new_like = bp_get_user_meta(bp_displayed_user_id(), 'notification_activity_new_like', true)) {
                $new_like = 'yes';
            } ?>
            <li class="notification-data" id="activity-notification-new-settings">
                <div class="notification-title">
                    <h6><?php (function_exists('iqonic_is_reaction_plugin_active')) ? esc_html_e("Reaction Notifications", "socialv") : esc_html_e("Like Notifications", "socialv"); ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-activity-new-like-yes"><input type=radio name="notifications[notification_activity_new_like]" value="yes" <?php checked($new_like, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-activity-new-like-no"><input type=radio name="notifications[notification_activity_new_like]" value="no" <?php checked($new_like, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
            <?php
            if (!$share_post = bp_get_user_meta(bp_displayed_user_id(), 'notification_share_activity_post', true)) {
                $share_post = 'yes';
            } ?>
            <li class="notification-data" id="activity-notification-new-settings">
                <div class="notification-title">
                    <h6><?php esc_html_e('Share on activity Notifications', 'socialv'); ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-share-activity-yes"><input type=radio name="notifications[notification_share_activity_post]" value="yes" <?php checked($share_post, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-share-activity-no"><input type=radio name="notifications[notification_share_activity_post]" value="no" <?php checked($share_post, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
        <?php
        endif;

        // Messages Notifications.
        if (bp_is_active('messages')) :
            if (!$new_messages = bp_get_user_meta(bp_displayed_user_id(), 'notification_messages_new_message', true)) {
                $new_messages = 'yes';
            } ?>
            <li class="notification-data" id="messages-notification-settings-new-message">
                <div class="notification-title">
                    <h6><?php esc_html_e('Messages Notifications', 'socialv'); ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-messages-new-messages-yes"><input type=radio name="notifications[notification_messages_new_message]" value="yes" <?php checked($new_messages, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-messages-new-messages-no"><input type=radio name="notifications[notification_messages_new_message]" value="no" <?php checked($new_messages, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
        <?php
        endif;

        // Friends Notifications.
        if (bp_is_active('friends')) :
            if (!$send_requests = bp_get_user_meta(bp_displayed_user_id(), 'notification_friends_friendship_request', true)) {
                $send_requests = 'yes';
            }

            if (!$accept_requests = bp_get_user_meta(bp_displayed_user_id(), 'notification_friends_friendship_accepted', true))
                $accept_requests = 'yes'; ?>
            <li class="notification-data" id="friends-notification-settings-request">
                <div class="notification-title">
                    <h6><?php esc_html_e('Friendship Requested Notifications', 'socialv'); ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-friends-friendship-request-yes"><input type=radio name="notifications[notification_friends_friendship_request]" value="yes" <?php checked($send_requests, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-friends-friendship-request-no"><input type=radio name="notifications[notification_friends_friendship_request]" value="no" <?php checked($send_requests, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
            <li class="notification-data" id="friends-notification-settings-accepted">
                <div class="notification-title">
                    <h6><?php esc_html_e('Friendship Accepted Notifications', 'socialv'); ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-friends-friendship-accepted-yes"><input type=radio name="notifications[notification_friends_friendship_accepted]" value="yes" <?php checked($accept_requests, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-friends-friendship-accepted-no"><input type=radio name="notifications[notification_friends_friendship_accepted]" value="no" <?php checked($accept_requests, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
        <?php
        endif;

        // Groups Notifications.
        if (bp_is_active('groups')) :
            if (!$group_invite = bp_get_user_meta(bp_displayed_user_id(), 'notification_groups_invite', true))
                $group_invite  = 'yes';

            if (!$group_update = bp_get_user_meta(bp_displayed_user_id(), 'notification_groups_group_updated', true))
                $group_update  = 'yes';

            if (!$group_promo = bp_get_user_meta(bp_displayed_user_id(), 'notification_groups_admin_promotion', true))
                $group_promo   = 'yes';

            if (!$group_request = bp_get_user_meta(bp_displayed_user_id(), 'notification_groups_membership_request', true))
                $group_request = 'yes';

            if (!$group_request_completed = bp_get_user_meta(bp_displayed_user_id(), 'notification_membership_request_completed', true)) {
                $group_request_completed = 'yes';
            } ?>
            <li class="notification-data" id="groups-notification-settings-invitation">
                <div class="notification-title">
                    <h6><?php esc_html_e('Group Invitations Notifications', 'socialv'); ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-groups-invite-yes"><input type=radio name="notifications[notification_groups_invite]" value="yes" <?php checked($group_invite, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-groups-invite-no"><input type=radio name="notifications[notification_groups_invite]" value="no" <?php checked($group_invite, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
            <li class="notification-data" id="groups-notification-settings-info-updated">
                <div class="notification-title">
                    <h6><?php esc_html_e('Group information Notifications', 'socialv'); ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-groups-group-updated-yes"><input type=radio name="notifications[notification_groups_group_updated]" value="yes" <?php checked($group_update, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-groups-group-updated-no"><input type=radio name="notifications[notification_groups_group_updated]" value="no" <?php checked($group_update, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
            <li class="notification-data" id="groups-notification-settings-promoted">
                <div class="notification-title">
                    <h6><?php esc_html_e('Group Admin Promotion Notifications', 'socialv'); ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-groups-admin-promotion-yes"><input type=radio name="notifications[notification_groups_admin_promotion]" value="yes" <?php checked($group_promo, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-groups-admin-promotion-no"><input type=radio name="notifications[notification_groups_admin_promotion]" value="no" <?php checked($group_promo, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
            <li class="notification-data" id="groups-notification-settings-request">
                <div class="notification-title">
                    <h6><?php esc_html_e('Join Group Notifications', 'socialv'); ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-groups-membership-request-yes"><input type=radio name="notifications[notification_groups_membership_request]" value="yes" <?php checked($group_request, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-groups-membership-request-no"><input type=radio name="notifications[notification_groups_membership_request]" value="no" <?php checked($group_request, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
            <li class="notification-data" id="groups-notification-settings-request-completed">
                <div class="notification-title">
                    <h6><?php esc_html_e('Group Membership Request Notifications', 'socialv'); ?></h6>
                </div>
                <div class="notification-switch">
                    <span class="radio-switch">
                        <label class="notification-groups-membership-request-completed-yes"><input type=radio name="notifications[notification_membership_request_completed]" value="yes" <?php checked($group_request_completed, 'yes', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label><label class="notification-groups-membership-request-completed-no"><input type=radio name="notifications[notification_membership_request_completed]" value="no" <?php checked($group_request_completed, 'no', true) ?> />
                            <span><i class="icon-dash"></i></span>
                        </label>
                    </span>
                </div>
            </li>
        <?php
        endif;
    }

    function socialv_bp_get_the_notification_mark_unread_link($retval, $user_id = 0)
    {
        return sprintf('<a href="%1$s" class="unread btn socialv-btn-outline-primary p-0 border-0" data-bs-toggle="tooltip" data-bs-placement="top" title="' . esc_attr__('Make as Unread', 'socialv') . '">%2$s</a>', esc_url(bp_get_the_notification_mark_unread_url($user_id)), '<i class="iconly-Hide icli"></i>');
    }

    function socialv_bp_get_the_notification_mark_read_link($retval, $user_id = 0)
    {
        return sprintf('<a href="%1$s" class="read btn socialv-btn-outline-primary p-0 border-0" data-bs-toggle="tooltip" data-bs-placement="top" title="' . esc_attr__('Make as Read', 'socialv') . '">%2$s</a>', esc_url(bp_get_the_notification_mark_read_url($user_id)), '<i class="iconly-Show icli"></i>');
    }

    function socialv_bp_get_the_notification_delete_link($retval, $user_id = 0)
    {
        return sprintf('<a href="%1$s" class="delete btn socialv-btn-outline-danger p-0 border-0" data-bs-toggle="tooltip" data-bs-placement="top" title="' . esc_attr__('Delete', 'socialv') . '">%2$s</a>', esc_url(bp_get_the_notification_delete_url($user_id)), '<i class="iconly-Delete icli"></i>');
    }

    function socialv_before_members_content()
    {
        if (class_exists('BP_Better_Messages') && bp_current_action() == 'bp-messages') {
        } else {
            $user_id = bp_displayed_user_id(); ?>
            <div id="item-header" role="complementary">

                <?php
                /**
                 * If the cover image feature is enabled, use a specific header
                 */
                if (bp_displayed_user_use_cover_image_header()) :
                    bp_get_template_part('members/single/cover-image-header');
                else :
                    bp_get_template_part('members/single/member-header');
                endif;
                ?>

            </div><!-- #item-header -->
        <?php
        }
    }

    function socialv_after_members_content()
    {
        $user_id = bp_displayed_user_id();
        $account_type = bp_get_user_meta($user_id, "socialv_user_account_type", true);
        $logged_in_user_id = get_current_user_id();

        if (class_exists('BP_Better_Messages') && bp_current_action() == 'bp-messages') {
        } else {
            $user_id = bp_displayed_user_id(); ?>
            <div class="card-main socialv-profile-box">
                <div class="card-inner">
                    <div class="item-header-cover-image-wrapper">
                        <div id="item-header-cover-image">

                            <div id="item-header-content" class="row align-items-center">
                                <?php
                                if ($this->socialv_member_social_socials_info($user_id)) {
                                    $this->socialv_member_social_socials_info($user_id);
                                } ?>
                                <div class="socialv-profile-center col-lg-4">
                                    <div class="header-avatar zoom-gallery ">
                                        <?php if (bp_is_my_profile() && !bp_disable_avatar_uploads()) { ?>
                                            <a href="<?php bp_members_component_link('profile', 'change-avatar'); ?>" class="link-change-profile-image" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e('Change Profile Photo', 'socialv'); ?>">
                                                <?php
                                                if (function_exists('socialv') && isset(buddypress()->buddyboss)) { ?>
                                                    <i class="bb-icon-edit-thin"></i>
                                                <?php } else { ?>
                                                    <i class="iconly-Camera icli"></i>
                                                <?php
                                                }
                                                ?>
                                            </a>
                                        <?php } ?>
                                        <?php if (is_user_logged_in()) {
                                            if (function_exists('friends_check_friendship') && !friends_check_friendship($logged_in_user_id, $user_id) && $user_id != $logged_in_user_id && $account_type == 'private') { ?>
                                            <?php echo bp_core_fetch_avatar(array(
                                                    'type'    => 'full',
                                                    'class' => 'rounded',
                                                    'width' => 150,
                                                    'height' => 150
                                                ));
                                            } else { ?>
                                                <a href=" <?php echo esc_url(get_avatar_url($user_id)); ?>" class="popup-zoom">
                                                    <?php echo bp_core_fetch_avatar(array(
                                                        'type'    => 'full',
                                                        'class' => 'rounded',
                                                        'width' => 150,
                                                        'height' => 150
                                                    )); ?>
                                                </a>
                                        <?php }
                                        } else {
                                            echo bp_core_fetch_avatar(array(
                                                'type'    => 'full',
                                                'class' => 'rounded',
                                                'width' => 150,
                                                'height' => 150
                                            ));
                                        } ?>
                                        <div class="chat-status"><span class="<?php echo esc_attr($this->socialv_is_user_online($user_id)['status']); ?>"><?php echo esc_html($this->socialv_is_user_online($user_id)['status_text']); ?></span></div>
                                    </div><!-- #item-header-avatar -->
                                    <?php if (bp_is_active('activity') && bp_activity_do_mentions()) : ?>
                                        <h5 class="profile-user-nicename"><?php echo bp_get_displayed_user_fullname(); ?></h5>
                                    <?php endif;

                                    do_action('bp_before_member_header_meta');  ?>
                                    <div class="socialv-userinfo">
                                        <?php
                                        $location =  xprofile_get_field_data('location', $user_id);
                                        $websites =  xprofile_get_field_data('website', $user_id);
                                        $hidden_fields = bp_xprofile_get_hidden_fields_for_user();
                                        if (!empty($location) && !in_array(xprofile_get_field_id_from_name('location'), $hidden_fields)) : ?>
                                            <div class="info-meta"><i class="iconly-Location icli"></i><span class="socialv-profile-member-location"><?php echo esc_html($location); ?></span></div>
                                        <?php endif;
                                        if (!empty($websites) && !in_array(xprofile_get_field_id_from_name('website'), $hidden_fields)) :
                                            $remove = array("http://", "https://");
                                            $website_text = str_replace($remove, "", $websites);
                                        ?>
                                            <div class="info-meta"><i class="icon-web"></i><span class="socialv-profile-member-website"><a href="<?php echo esc_url($websites); ?>"><?php echo wp_kses($website_text, 'website'); ?></a></span></div>
                                        <?php endif;
                                        // Additonal Meta Add
                                        do_action('socialv_member_header_fields'); ?>
                                    </div>

                                    <div class="socialv-profile-tab-button" id="members-dir-list">
                                        <!--  Button -->
                                        <?php
                                        do_action('bp_member_header_actions');
                                        do_action('bp_profile_header_meta');
                                        ?>

                                    </div>
                                    <?php do_action('bp_after_member_header');  ?>
                                </div>
                                <div class="socialv-profile-right col-lg-4">
                                    <ul class="socialv-user-meta list-inline">
                                        <?php if ($this->socialv_option['display_user_post'] == 'yes') : ?>
                                            <li>
                                                <h5><?php $this->socialv_get_total_post_updates_count(); ?></h5> <?php esc_html_e('Posts', 'socialv'); ?>
                                            </li>
                                        <?php endif;
                                        if ($this->socialv_option['display_user_comments'] == 'yes') :  ?>
                                            <li>
                                                <?php $count = $this->socialv_count_user_comments($user_id);
                                                printf(_n('<h5>%1$s</h5> Comment', '<h5>%1$s</h5> Comments', $count, 'socialv'), number_format_i18n($count)); ?>
                                            </li>
                                        <?php endif;
                                        if ($this->socialv_option['display_user_views'] == 'yes') :  ?>
                                            <li>
                                                <h5><?php $this->socialv_get_postviews($user_id); ?></h5> <?php esc_html_e('Views', 'socialv'); ?>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>

                            </div><!-- #item-header-content -->

                        </div><!-- #item-header-cover-image -->
                    </div><!-- .item-header-cover-image-wrapper -->
                </div>
            </div>

            <div class="card-main card-space card-space-bottom">
                <div class="card-inner p-0">
                    <div id="item-nav">
                        <div class="item-list-tabs no-ajax socialv-tab-lists" id="object-nav">
                            <?php
                            $bp = buddypress();
                            if (bp_core_can_edit_settings()) :
                                $profile_tab     = $bp->members->nav->get_primary();
                                if ($profile_tab > 8) : ?>
                                    <div class="left" onclick="slide('left',event)"><i class="iconly-Arrow-Left-2 icli"></i></div>
                                    <div class="right" onclick="slide('right',event)"><i class="iconly-Arrow-Right-2 icli"></i></div>
                                <?php endif;
                            else : ?>
                                <div class="left" onclick="slide('left',event)"></div>
                                <div class="right" onclick="slide('right',event)"></div>
                            <?php endif; ?>
                            <ul class="list-inline socialv-tab-container custom-nav-slider">
                                <?php bp_get_displayed_user_nav(); ?>
                                <?php do_action('bp_member_options_nav'); ?>
                            </ul>
                        </div>
                    </div><!-- #item-nav -->
                </div>
            </div>
        <?php
        }
    }

    function socialv_member_header_action()
    {
        if (is_user_logged_in() && $this->socialv_option['display_user_message_btn'] == 'yes' && function_exists('friends_get_friend_user_ids')) : ?>
            <a class="btn socialv-btn-primary text-capitalize" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e('Message', 'socialv'); ?>" href="<?php echo esc_url(socialv()->bp_custom_get_send_private_message_link(bp_get_member_user_id())); ?>"><?php esc_html_e('Message', 'socialv') ?></a>
        <?php endif;
    }
    function socialv_bbp_get_reply_class($classes)
    {
        $classes[] = 'main-bp_members';
        return $classes;
    }

    function socialv_bp_get_the_members_invitation_resend_link($retval, $user_id = 0)
    {

        return sprintf('<a href="%1$s" class="read btn socialv-btn-outline-primary p-0 border-0" data-bs-toggle="tooltip" data-bs-placement="top" title="' . esc_attr__('Resend', 'socialv') . '">%2$s</a>', esc_url(bp_get_the_members_invitations_resend_url($user_id)), '<i class="iconly-Send icli"></i>');
    }

    function socialv_bp_get_the_members_invitation_delete_link($retval, $user_id = 0)
    {
        if (bp_get_the_members_invitation_property('accepted')) {
            $message = esc_html__('Delete', 'socialv');
        } else {
            $message = esc_html__('Cancel', 'socialv');
        }
        return sprintf('<a href="%1$s" class="delete btn socialv-btn-outline-danger p-0 border-0" data-bs-toggle="tooltip" data-bs-placement="top" title="' . esc_attr($message) . '">%2$s</a>', esc_url(bp_get_the_members_invitations_delete_url($user_id)), '<i class="iconly-Shield-Fail icli"></i>');
    }



    function socialv_gamipress_get_achievement_earners_list($output, $achievement_id, $args, $earners)
    {

        $args = apply_filters('gamipress_get_achievement_earners_list_args', $args, $achievement_id);

        // Grab our users
        $earners = gamipress_get_achievement_earners($achievement_id, $args);
        $output = '';

        // Only generate output if we have earners
        if (!empty($earners)) {


            $heading_text = apply_filters('gamipress_achievement_earners_heading', esc_html__('People who have earned this', 'socialv'), $achievement_id, $args);


            $output .= '<ul class="list-img-group list-inline m-0">';

            foreach ($earners as $user) {


                $user_url = apply_filters('gamipress_achievement_earner_user_url', get_author_posts_url($user->ID), $user->ID, $achievement_id, $args);


                $user_display = apply_filters('gamipress_achievement_earner_user_display', $user->display_name, $user->ID, $achievement_id, $args);

                $user_content = '<li>'
                    . '<a href="' . $user_url . '">'
                    . get_avatar($user->ID)
                    . '<span class="earner-display-name">' . $user_display . '</span>'
                    . '</a>'
                    . '</li>';

                $output .= apply_filters('gamipress_get_achievement_earners_list_user', $user_content, $user->ID, $achievement_id, $args);
            }

            $output .= '</ul>';
            // Loop through each user and build our output
            $output .= '<p class="socialv-achievement-earn-user mb-0">' . $heading_text . '</p>';
        }

        return $output;
    }

    function socialv_gamipress_get_rank_earners_list($output, $rank_id, $args, $earners)
    {

        $args = apply_filters('gamipress_get_rank_earners_list_args', $args, $rank_id);

        // Grab our users
        $earners = gamipress_get_rank_earners($rank_id, $args);
        $output = '';

        // Only generate output if we have earners
        if (!empty($earners)) {

            $heading_text = apply_filters('gamipress_rank_earners_heading', __('People who have this rank:', 'socialv'), $rank_id, $args);

            $output .= '<ul class="list-img-group list-inline m-0">';

            foreach ($earners as $user) {

                $user_url = get_author_posts_url($user->ID);

                $user_url = apply_filters('gamipress_rank_earner_user_url', $user_url, $user->ID, $rank_id, $args);

                $user_display = apply_filters('gamipress_rank_earner_user_display', $user->display_name, $user->ID, $rank_id, $args);

                $user_content = '<li>'
                    . '<a href="' . $user_url . '">'
                    . get_avatar($user->ID)
                    . '<span class="earner-display-name">' . $user_display . '</span>'
                    . '</a>'
                    . '</li>';

                $output .= apply_filters('gamipress_get_rank_earners_list_user', $user_content, $user->ID, $rank_id, $args);
            }

            $output .= '</ul>';
            // Loop through each user and build our output
            $output .= '<p class="socialv-achievement-earn-user mb-0">' . $heading_text . '</p>';
        }

        return $output;
    }

    function socialv_user_profile_menu()
    {
        // Get User ID.
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;
        // New Array
        $links = array();
        $is_xprofile_active = bp_is_active('xprofile');
        $is_settings_active = bp_is_active('settings');
        // Account Settings
        if ($is_settings_active) {
            global $current_user;
            if (bp_loggedin_user_id() && isset($current_user->roles) && in_array('demo-user', $current_user->roles)) {
                $links['account'] = array(
                    'icon'    => 'iconly-Setting icli',
                    'href'    => bp_core_get_user_domain($user_id) . bp_get_settings_slug() . '/notifications/',
                    'title'    => esc_html__('Account Settings', 'socialv')
                );
            } else {
                $links['account'] = array(
                    'icon'    => 'iconly-Setting icli',
                    'href'    => bp_core_get_user_domain($user_id) . bp_get_settings_slug(),
                    'title'    => esc_html__('Account Settings', 'socialv')
                );
            }
        }

        // Profile Settings
        if ($is_xprofile_active) {
            $links['profile'] = array(
                'icon'    => 'iconly-Profile icli',
                'href'    => bp_core_get_user_domain($user_id) . 'profile/edit/group/1',
                'title'    => esc_html__('Profile Settings', 'socialv')
            );
        }


        if ($is_xprofile_active) {
            // Change Photo Link
            $links['change-photo'] = array(
                'icon'    => 'iconly-Image icli',
                'href'    => bp_core_get_user_domain($user_id) . 'profile/change-avatar',
                'title'    => esc_html__('Change Avatar', 'socialv')
            );
        }

        if ($is_settings_active) {
            global $current_user;
            if (bp_loggedin_user_id() && isset($current_user->roles) && !in_array('demo-user', $current_user->roles)) {
                // Change Password Link
                $links['change-password'] = array(
                    'icon'    => 'iconly-Lock icli',
                    'href'    => bp_core_get_user_domain($user_id) . bp_get_settings_slug() . '/general',
                    'title'    => esc_html__('Change Password', 'socialv')
                );
            }
        }
        $content = '<ul class="user-profile-menu">';
        $content .= '<li class="menu-item">
        <a href="' . esc_url(bp_core_get_user_domain(get_current_user_id())) . '">
            <i class="iconly-Profile icli"></i>
            <span class="menu-title">' . esc_html__('Profile Info', 'socialv') . '</span>
        </a>
    </li>';
        foreach ($links as $link) :
            $content .= '<li class="menu-item">
            <a href="' . esc_url($link['href']) . '">
                <i class="' . esc_attr($link['icon']) . '"></i>
                <span class="menu-title">' . esc_html($link['title']) . '</span>
            </a>
        </li>';
        endforeach;
        do_action('socialv_user_menu_list_after');
        echo apply_filters('socialv_user_menu_filter_content_data', $content);
        echo '</ul>';
    }

    /**
     * Get Members Directory User settings Button
     */
    function socialv_get_current_user_profile_settings($user_id = false)
    {

        if (!is_user_logged_in() || !bp_is_members_directory()) {
            return false;
        }
        if (!$user_id) {
            // For members loop.
            $user_id = bp_get_member_user_id();

            // For user profile.
            if (bp_is_user()) {
                $user_id = bp_displayed_user_id();
            }
        }

        if ($user_id != bp_loggedin_user_id()) {
            return false;
        }

        ?>
        <?php if (bp_is_active('xprofile')) : ?>
            <div class="friendship-button generic-button"> <a href="<?php echo esc_url(bp_core_get_user_domain($user_id) . 'profile/edit/group/1'); ?>" class="friendship-button profile-settings btn btn-sm socialv-btn-info text-capitalize"><?php esc_html_e('Profile Settings', 'socialv'); ?></a></div>
        <?php endif; ?>

    <?php
    }

    function socialv_gamipress_points_classes($classes, $points_types, $a)
    {
        $is_current_user = (absint($a['user_id']) === get_current_user_id());
        $classes = array(
            'gamipress-user-points',
            ($is_current_user ? 'gamipress-is-current-user' : ''),
            'gamipress-columns-3',
            'gamipress-layout-' . $a['layout'],
            'gamipress-align-' . $a['align']
        );
        return $classes;
    }


    function learnpress_load_template()
    {
        add_action('bp_template_content', [$this, 'socialv_bp_custom_screen_content']);
        bp_core_load_template('buddypress/members/single/plugins');
    }

    function socialv_bp_custom_screen_content()
    { ?>

        <div class="lp-content-area socialv-lp_courses_list">
            <div class="card-main">
                <div class="card-inner pt-0 pb-0">
                    <div class="row align-items-center socialv-sub-tab-lists" id="subnav">
                        <div class="col-12 item-list-tabs no-ajax ">
                            <div class="socialv-subtab-lists">
                                <div class="left" onclick="slide('left',event)">
                                    <i class="iconly-Arrow-Left-2 icli"></i>
                                </div>
                                <div class="right" onclick="slide('right',event)">
                                    <i class="iconly-Arrow-Right-2 icli"></i>
                                </div>
                                <div class="socialv-subtab-container custom-nav-slider">
                                    <ul class="nav learn-press-profile-course__tab__inner list-inline m-0">
                                        <li><a class="nav-link show active" data-bs-toggle="tab" data-bs-target="#all" href="#all" role="tab" aria-controls="all" aria-selected="true"><?php esc_html_e('All', 'socialv') ?></a></li>
                                        <li><a class="nav-link" data-bs-toggle="tab" data-bs-target="#in_progress" href="#in_progress" role="tab" aria-controls="in_progress" aria-selected="false"><?php esc_html_e('In Progress', 'socialv') ?></a></li>
                                        <li><a class="nav-link" data-bs-toggle="tab" data-bs-target="#finished" href="#finished" role="tab" aria-controls="finished" aria-selected="false"><?php esc_html_e('Finished', 'socialv') ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-space course-tab-panels tab-content">
                <?php
                $this->get_tab_course_content('all');
                $this->get_tab_course_content('in_progress');
                $this->get_tab_course_content('finished');
                ?>
            </div>
        </div>
        <?php
    }


    function get_tab_course_content($options = '')
    {
        global $wpdb;
        $section = '';
        $user_id = get_current_user_id();
        $user = learn_press_get_user($user_id);
        $items_per_page = isset($this->socialv_option['default_post_per_page']) ? $this->socialv_option['default_post_per_page'] : 12;
        $paged = isset($_GET['paged']) ? abs((int) $_GET['paged']) : 1;
        $offset = ($paged * $items_per_page) - $items_per_page;
        $table_name = $wpdb->prefix . 'learnpress_user_items';
        switch ($options) {
            case 'all':
                $total_query = "SELECT COUNT(*) FROM `$table_name` WHERE status IN ('enrolled','finished')  AND user_id = $user_id";
                $section = $wpdb->get_results("SELECT item_id FROM `$table_name` WHERE status IN ('enrolled','finished')  AND user_id = $user_id LIMIT $offset , $items_per_page", OBJECT);
        ?>
                <div class="tab-pane course-tab-panel-all fade show active" id="all">
                    <ul class="learn-press-courses" data-layout="grid">
                        <?php
                        if (count($section) > 0) {
                            foreach ($section as $id) {
                                $this->socialv_course_content($user, $id);
                            }
                        } else {
                            echo '<li class="no-course">' . esc_html__('No Courses Available', 'socialv') . '</li>';
                        }
                        ?>
                    </ul>
                    <?php $this->learpress_course_pagination($total_query, $paged, $items_per_page);   ?>
                </div>
            <?php
                break;
            case 'in_progress':
                $total_query = "SELECT COUNT(*) FROM `$table_name` WHERE status = 'enrolled' AND user_id = $user_id";
                $section = $wpdb->get_results("SELECT item_id FROM `$table_name` WHERE status = 'enrolled' AND user_id = $user_id LIMIT $offset , $items_per_page", OBJECT); ?>
                <div class="tab-pane course-tab-panel-all fade" id="in_progress">
                    <ul class="learn-press-courses" data-layout="grid">
                        <?php if (count($section) > 0) {
                            foreach ($section as $id) {
                                $this->socialv_course_content($user, $id);
                            }
                        } else {
                            echo '<li class="no-course">' . esc_html__('No Courses Available', 'socialv') . '</li>';
                        }
                        ?>
                    </ul>
                    <?php $this->learpress_course_pagination($total_query, $paged, $items_per_page);   ?>
                </div>
            <?php
                break;
            case 'finished':
                $total_query = "SELECT COUNT(*) FROM `$table_name` WHERE status = 'finished' AND user_id = $user_id";
                $section = $wpdb->get_results("SELECT item_id FROM `$table_name` WHERE status = 'finished' AND user_id = $user_id LIMIT $offset , $items_per_page", OBJECT); ?>
                <div class="tab-pane course-tab-panel-all fade" id="finished">
                    <ul class="learn-press-courses" data-layout="grid">
                        <?php if (count($section) > 0) {
                            foreach ($section as $id) {
                                $this->socialv_course_content($user, $id);
                            }
                        } else {
                            echo '<li class="no-course">' . esc_html__('No Courses Available', 'socialv') . '</li>';
                        }
                        ?>
                    </ul>
                    <?php $this->learpress_course_pagination($total_query, $paged, $items_per_page);   ?>
                </div>
        <?php
                break;
        }
        return $section;
    }

    function learpress_course_pagination($total_query, $paged, $items_per_page)
    {
        global $wpdb;
        $total_pages = $wpdb->get_var($total_query);
        if ($total_pages > $items_per_page) {
            echo paginate_links(
                apply_filters(
                    'learn_press_pagination_args',
                    array(
                        'base' => add_query_arg('paged', '%#%'),
                        'format' => '',
                        'total' => $total_pages,
                        'current' => $paged,
                        'prev_next' => true,
                        'prev_text'       => '<i class="iconly-Arrow-Left-2 icli"></i>',
                        'next_text'       => '<i class="iconly-Arrow-Right-2 icli"></i>',
                        'type' => 'list',
                        'add_args' => false,
                        'add_fragment' => ''
                    )
                )
            );
        }
    }
    function socialv_course_content($user, $id)
    {
        $course_data = $user->get_course_data($id->item_id);
        $course_result = $course_data->get_result();
        $course_id = $id->item_id;
        $terms = get_the_terms($course_id, 'course_category');
        $image_url =    wp_get_attachment_image_src(get_post_thumbnail_id($course_id), 'course_thumbnail');
        if (!empty($image_url[0])) {
            $image_url = $image_url[0];
        } else {
            $image_url = LP()->image('no-image.png');
        }
        $passing_condition = $course_data->get_passing_condition();
        ?>
        <li class="course-box course">
            <div class="course-item">
                <div class="course-wrap-thumbnail">
                    <div class="course-thumbnail">
                        <a href="<?php echo esc_url(get_permalink($course_id)); ?>">
                            <img src="<?php echo esc_url($image_url); ?>" loading="lazy" alt="<?php esc_attr_e('post-img', 'socialv'); ?>">
                        </a>
                    </div>
                </div><!-- START .course-content -->
                <div class="course-content">
                    <?php if (!empty($terms)) : ?>
                        <div class="course-header">
                            <div class="course-categories">
                                <?php
                                foreach ($terms as $term) {
                                    echo '<a href=' . esc_url(get_term_link($term)) . ' rel="tag">' . esc_html($term->name) . '</a>';
                                } ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <a href="<?php echo get_the_permalink($course_id); ?>" class="course-permalink">
                        <h3 class="course-title"><?php echo get_the_title($course_id); ?></h3>
                    </a>
                    <div class="separator"></div>

                    <div class="course-results-progress">
                        <div class="course-progress">
                            <div class="learn-press-progress lp-course-progress " data-value="<?php echo esc_attr($course_result['result']); ?>" data-passing-condition="<?php echo esc_attr($passing_condition); ?>">
                                <div class="progress-bg">
                                    <div class="progress-active lp-progress-value" style="left: <?php echo esc_attr($course_result['result']); ?>%;">
                                    </div>
                                </div>
                                <div class="lp-passing-conditional" data-content="<?php printf(esc_html__('Passing condition: %s%%', 'socialv'), $passing_condition); ?>" style="left: <?php echo esc_attr($passing_condition); ?>%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="course-info">
                        <div class="course-footer">
                            <?php if (class_exists('LP_Addon_Course_Review') && function_exists('learn_press_get_course_rate')) :
                                $course_rate_res   = learn_press_get_course_rate($course_id, false);
                                $course_rate       = $course_rate_res['rated']; ?>
                                <div class="course-ratings">
                                    <?php echo '<span class="course-rating-total">' . number_format($course_rate, 1) . '</span>';
                                    socialv()->socialv_review_content($course_id);
                                    ?>
                                </div>
                            <?php endif; ?>
                            <div class="course-price">
                                <span class="free"><?php echo esc_html($course_result['result']); ?>%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    <?php
    }

    // Ranks /Levels List

    function socialv_gamipress_rank_requirements_heading($requirements_heading, $count)
    {
        $requirements_heading = '<div class="requirements-title"><span>' . esc_html__(((count($count) == 1) ? 'Requirement:' : 'Requirements:'), 'socialv')  . '</span>';
        $requirements_heading .= '<span class="count-number">' . count($count) . '</span></div>';
        return $requirements_heading;
    }

    function socialv_gamipress_rank_unlock_with_points_markup($output, $rank_id, $user_id, $points, $points_type, $template_args)
    {
        $rank_title = gamipress_get_post_field('post_title', $rank_id);
        $points_formatted = gamipress_format_points($points, $points_type);

        $confirmation = apply_filters('gamipress_rank_unlock_with_points_confirmation', true, $rank_id, $user_id, $points, $points_type, $template_args);

        $button_text = sprintf(__('Unlock', 'socialv'), $points_formatted);
        $button_text = apply_filters('gamipress_rank_unlock_with_points_button_text', $button_text, $rank_id, $user_id, $points, $points_type, $template_args);

        ob_start(); ?>
        <div class="gamipress-rank-unlock-with-points" data-id="<?php echo esc_html($rank_id); ?>">
            <button type="button" class="gamipress-rank-unlock-with-points-button btn-sm socialv-btn-primary border-0"><?php echo wp_kses($button_text, 'socialv'); ?></button>
            <?php if ($confirmation) : ?>
                <div class="gamipress-rank-unlock-with-points-confirmation" style="display: none;">
                    <p><?php echo sprintf(__('Do you want to unlock %s using %s?', 'socialv'), $rank_title, $points_formatted); ?></p>
                    <button type="button" class="gamipress-rank-unlock-with-points-confirm-button  btn-sm socialv-btn-success border-0"><?php esc_html_e('Yes', 'socialv'); ?></button>
                    <button type="button" class="gamipress-rank-unlock-with-points-cancel-button  btn-sm socialv-btn-danger border-0"><?php esc_html_e('No', 'socialv'); ?></button>
                </div>
            <?php endif; ?>
            <div class="gamipress-spinner" style="display: none;"></div>
        </div>
        <?php $output = ob_get_clean();
        return $output;
    }

    function socialv_screen_settings_content()
    {
        try {
            if (!$shop_reviews = bp_get_user_meta(bp_displayed_user_id(), 'notification_activity_shop_reviews', true)) {
                $shop_reviews = 'yes';
            }
            if (!$shop_purchases = bp_get_user_meta(bp_displayed_user_id(), 'notification_activity_shop_purchases', true)) {
                $shop_purchases = 'yes';
            }
        ?>
            <form action="<?php wc4bp_settings_link(); ?>" method="POST">
                <div class="notification-settings">
                    <ul class="list-inline m-0">
                        <li class="notification-data" id="shop-notification-settings-reviews">
                            <div class="notification-title">
                                <h6><?php esc_html_e('Post to activity stream all reviews written by me', 'socialv'); ?></h6>
                            </div>
                            <div class="notification-switch">
                                <span class="radio-switch">
                                    <label class="reviews-2-activity-yes"><input type=radio name="wc4bp[reviews_2_activity]" id="reviews-2-activity-yes" value="yes" <?php checked($shop_reviews, 'yes', true) ?> />
                                        <span><i class="icon-dash"></i></span>
                                    </label><label class="reviews-2-activity-no"><input type=radio name="wc4bp[reviews_2_activity]" id="reviews-2-activity-no" value="no" <?php checked($shop_reviews, 'no', true) ?> />
                                        <span><i class="icon-dash"></i></span>
                                    </label>
                                </span>
                            </div>
                        </li>
                        <li class="notification-data" id="shop-notification-settings-purchases">
                            <div class="notification-title">
                                <h6><?php esc_html_e('Post to activity stream all purchases I\'ve made', 'socialv'); ?></h6>
                            </div>
                            <div class="notification-switch">
                                <span class="radio-switch">
                                    <label class="purchases-2-activity-yes"><input type=radio name="wc4bp[purchases_2_activity]" id="purchases-2-activity-yes" value="yes" <?php checked($shop_purchases, 'yes', true) ?> />
                                        <span><i class="icon-dash"></i></span>
                                    </label><label class="purchases-2-activity-no"><input type=radio name="wc4bp[purchases_2_activity]" id="purchases-2-activity-no" value="no" <?php checked($shop_purchases, 'no', true) ?> />
                                        <span><i class="icon-dash"></i></span>
                                    </label>
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
                <?php
                /**
                 * Setting screen for Activity Stream executed
                 */
                do_action('wc4bp_screen_notification_activity_settings');
                ?>
                <div class="form-edit-btn">
                    <div class="submit">
                        <input type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'socialv'); ?>" id="submit" class="auto btn socialv-btn-success">
                    </div>
                </div>

            </form>
<?php
        } catch (Exception $exception) {
            WC4BP_Loader::get_exception_handler()->save_exception($exception->getTrace());
        }
    }

    // user privacy and security settings start
    public function socialv_privacy_and_security_settings()
    {
        if (!bp_is_active('settings')) {
            return;
        }

        // Determine user to use.
        if (bp_loggedin_user_domain()) {
            $user_domain = bp_loggedin_user_domain();
        } else {
            return;
        }

        // Get the settings slug.
        $settings_slug = bp_get_settings_slug();

        bp_core_new_subnav_item(array(
            'name'            => esc_html__('Privacy and security', 'socialv'),
            'slug'            => 'privacy-and-security',
            'parent_url'      => trailingslashit($user_domain . $settings_slug),
            'parent_slug'     => $settings_slug,
            'screen_function' => [$this, 'socialv_privacy_and_security_screen'],
            'position'        => 31,
            'user_has_access' => bp_core_can_edit_settings()
        ), 'members');
    }
    public function socialv_privacy_and_security_screen()
    {
        add_action('bp_template_content', [$this, 'socialv_privacy_and_security_template']);

        bp_core_load_template(apply_filters('bp_settings_screen_xprofile', '/members/single/settings/profile'));
    }
    public function socialv_privacy_and_security_template()
    {
        get_template_part("template-parts/buddypress-custom/privacy", "security");
    }
    public function socialv_exclude_private_user_activities($where_conditions)
    {
        if ($this->socialv_option["display_activity_showing_friends"] == "yes") {
            $current_user_id = get_current_user_id();
            if (function_exists('friends_get_friend_user_ids')) {
                $exclude = friends_get_friend_user_ids($current_user_id);
            }
            $exclude[] = $current_user_id;

            $args = [
                'fields'        => 'ids',
                'meta_key'      => 'socialv_user_account_type',
                'meta_value'    => 'private',
                'exclude'       => $exclude
            ];

            $users = get_users($args);

            if (!empty($users)) {
                $user_ids = implode(",", $users);
                $where_conditions["private_user_not_in"] = "a.user_id NOT IN ($user_ids)";
            }
        }
        return $where_conditions;
    }
    
    public function socialv_settings_action_notifications()
    {
        if (!bp_is_post_request()) {
            return;
        }

        // Bail if no submit action.
        if (!isset($_POST['submit'])) {
            return;
        }

        // Bail if not in settings.
        if (!bp_is_settings_component() || !bp_is_current_action('privacy-and-security')) {
            return;
        }
        // 404 if there are any additional action variables attached
        if (bp_action_variables()) {
            bp_do_404();
            return;
        }

        check_admin_referer('socialv_settings_account_privacy');

        if (isset($_POST['account_type'])) {
            if ($_POST['account_type'] == "private") {
                bp_update_user_meta(bp_displayed_user_id(), "socialv_user_account_type", "private");
            }
        } else {
            bp_update_user_meta(bp_displayed_user_id(), "socialv_user_account_type", "public");
        }
        // Switch feedback for super admins.
        if (bp_is_my_profile()) {
            bp_core_add_message(__('Your notification settings have been saved.',        'socialv'), 'success');
        } else {
            bp_core_add_message(__("This user's notification settings have been saved.", 'socialv'), 'success');
        }

        /**
         * Fires after the notification settings have been saved, and before redirect.
         *
         * @since 1.5.0
         */
        do_action('socialv_account_privacy_settings_after_save');

        bp_core_redirect(bp_displayed_user_domain() . bp_get_settings_slug() . '/privacy-and-security/');
    }

    public function socialv_user_private_content($user_id)
    {
        echo '<div class="card-main"><div class="card-inner socialv-locked-profile text-center"><i class="iconly-Lock icli"></i>';
        printf(__('<h5>%s locked his profile</h5><p>Only his friends can see what he shares on his profile.</p>', 'socialv'), bp_get_displayed_user_fullname());
        echo '</div></div>';
    }
    // user privacy and security settings end
}
