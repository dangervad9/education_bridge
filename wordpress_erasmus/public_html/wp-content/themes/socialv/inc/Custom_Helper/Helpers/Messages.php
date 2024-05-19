<?php

/**
 * SocialV\Utility\Custom_Helper\Helpers\Messages class
 *
 * @package socialv
 */

namespace SocialV\Utility\Custom_Helper\Helpers;
use Better_Messages_BuddyPress;
use SocialV\Utility\Custom_Helper\Component;
use function add_action;

class Messages  extends Component
{
    public $socialv_option;
    public function __construct()
    {
        $this->socialv_option = get_option('socialv-options');
        if (version_compare(Better_Messages()->version, '2.1.8', '>=')) {
            if (class_exists('Better_Messages_BuddyPress') && Better_Messages()->settings['userListButton'] == '1' ) {
                remove_action('bp_directory_members_actions', array(Better_Messages_BuddyPress::instance(), 'pm_link_legacy'), 10);
                add_action('bp_directory_members_actions', [$this, 'socialv_pm_link_legacy'], 10);
            }
            if (class_exists('Redux') && $this->socialv_option['display_user_message_btn'] == 'yes') {
                add_action('bp_member_header_actions', [$this, 'socialv_user_pm_link_legacy']);
            }
        }
    }


    public function socialv_user_pm_link_legacy()
    {
        if (!is_user_logged_in()) return false;
        $user_id = Better_Messages()->functions->get_member_id();
        if (get_current_user_id() === $user_id) return false;
        if (
            Better_Messages()->settings['bpForceMiniChat'] === '1'
            && function_exists('bp_displayed_user_id')
        ) {
            echo '<a href="' . Better_Messages_BuddyPress::instance()->pm_link() . '" class="bpbm-pm-button open-mini-chat btn socialv-btn-primary text-capitalize" data-user-id="' .  $user_id . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . esc_attr__('Message', 'socialv') . '">' . esc_html__('Message', 'socialv') . '</a>';
        } else {
            echo '<a href="' . Better_Messages_BuddyPress::instance()->pm_link() . '" class="btn socialv-btn-primary text-capitalize" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . esc_attr__('Message', 'socialv') . '">' .  esc_html__('Message', 'socialv') . '</a>';
        }
    }

    public function socialv_pm_link_legacy()
    {
        if (!is_user_logged_in()) return false;
        $user_id = Better_Messages()->functions->get_member_id();
        if (get_current_user_id() === $user_id) return false;
        if (
            Better_Messages()->settings['bpForceMiniChat'] === '1'
            && function_exists('bp_displayed_user_id')
        ) {
            echo '<a href="' . Better_Messages_BuddyPress::instance()->pm_link() . '" class="bpbm-pm-button open-mini-chat message-btn" data-user-id="' .  $user_id . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . esc_attr__('Message', 'socialv') . '"><i class="iconly-Message icli"></i></a>';
        } else {
            echo '<a href="' . Better_Messages_BuddyPress::instance()->pm_link() . '" class="message-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . esc_attr__('Message', 'socialv') . '"><i class="iconly-Message icli"></i></a>';
        }
    }


}