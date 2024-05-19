<?php

/**
 * SocialV\Utility\Custom_Helper\Helpers\Members class
 *
 * @package socialv
 */

namespace SocialV\Utility\Custom_Helper\Helpers;

use SocialV\Utility\Custom_Helper\Component;

class VerifiedMember  extends Component
{
    public static function getInstance()
    {
        return new VerifiedMember();
    }

    function socialv_get_user_badge($user_id)
    {
        global $bp_verified_member_admin;
        $display_unverified_badge = !empty($bp_verified_member_admin->settings->get_option('display_unverified_badge'));
        return $this->socialv_is_user_verified($user_id) ? $this->socialv_get_verified_badge() : ($display_unverified_badge ? $this->socialv_get_unverified_badge() : '');
    }
    public function socialv_is_user_verified($user_id)
    {
        if (empty($user_id)) {
            return false;
        }

        return $this->socialv_is_user_verified_by_role($user_id) || $this->socialv_is_user_verified_by_member_type($user_id) || $this->socialv_is_user_verified_by_meta($user_id);
    }
    public function socialv_get_verified_badge()
    {
        return apply_filters('bp_verified_member_verified_badge', '<span class="bp-verified-badge"></span>');
    }
    public function socialv_get_unverified_badge()
    {
        return apply_filters('bp_verified_member_verified_badge', '<span class="bp-unverified-badge"></span>');
    }
    public function socialv_is_user_verified_by_role($user_id)
    {
        if (empty($user_id)) {
            return false;
        }

        global $bp_verified_member_admin;
        $verified_roles = $bp_verified_member_admin->settings->get_option('verified_roles');
        $user           = get_userdata($user_id);

        return !empty($verified_roles) && !empty($user) && !empty($user->roles) && !empty(array_intersect($verified_roles, $user->roles));
    }
    public function socialv_is_user_verified_by_member_type($user_id)
    {
        if (empty($user_id)) {
            return false;
        }

        global $bp_verified_member_admin;
        $verified_member_types = $bp_verified_member_admin->settings->get_option('verified_member_types');
        $user_member_types     = bp_get_member_type($user_id, false);

        return !empty($verified_member_types) && !empty($user_member_types) && !empty(array_intersect($verified_member_types, $user_member_types));
    }
    public function socialv_is_user_verified_by_meta($user_id)
    {
        if (empty($user_id)) {
            return false;
        }

        global $bp_verified_member_admin;
        return !empty(get_user_meta($user_id, $bp_verified_member_admin->meta_box->meta_keys['verified'], true));
    }
}
