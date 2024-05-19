<?php

/**
 * SocialV\Utility\Custom_Helper\Helpers\Groups class
 *
 * @package socialv
 */

namespace SocialV\Utility\Custom_Helper\Helpers;

use SocialV\Utility\Custom_Helper\Component;
use function add_action;
use function SocialV\Utility\socialv;

class Groups extends Component
{

    public function __construct()
    {
        //Search Form
        add_filter('bp_directory_groups_search_form', [$this, 'socialv_bp_directory_groups_search_form']);
        add_filter('bp_directory_members_search_form', [$this,  'socialv_bp_directory_members_search_form']);

        add_action('bp_actions', [$this, 'socialv_bp_groups_change_bp_nav_position']);
        add_action('bp_directory_groups_actions',  [$this, 'socialv_get_group_manage_group_buttons'], 999);
        add_filter('bp_get_group_type', [$this, 'socialv_bp_get_group_type'], 10, 2);
        //Default Group Image
        add_filter('bp_get_group_avatar', [$this, 'socialv_bp_default_get_group_avatar']);
        add_filter('bp_before_groups_cover_image_settings_parse_args', [$this, 'socialv_bp_before_default_cover_image_settings_parse_args'], 10, 1);
        add_filter('bp_before_members_cover_image_settings_parse_args', [$this, 'socialv_bp_before_default_cover_image_settings_parse_args'], 10, 1);
        add_filter('bp_core_default_avatar',    [$this, 'socialv_groups_default_avatar'], 10, 3);


        // Groups Action Button
        add_action("init", function () {
            remove_action('wp_ajax_joinleave_group', 'bp_legacy_theme_ajax_joinleave_group');
            remove_action('wp_ajax_nopriv_joinleave_group', 'bp_legacy_theme_ajax_joinleave_group');
        });
        add_action('wp_ajax_joinleave_group', [$this, 'bp_legacy_theme_ajax_joinleave_group']);
        add_action('wp_ajax_nopriv_joinleave_group', [$this, 'bp_legacy_theme_ajax_joinleave_group']);
        add_filter('bp_get_group_join_button', [$this, 'socialv_bp_get_group_join_button'], 10, 2);
        add_action('bp_before_group_body', [$this, 'socialv_bp_before_group_body']);
    }


    function bp_legacy_theme_ajax_joinleave_group()
    {
        if (!bp_is_post_request()) {
            return;
        }

        // Cast gid as integer.
        $group_id = (int) $_POST['gid'];

        if (groups_is_user_banned(bp_loggedin_user_id(), $group_id)) {
            return;
        }

        $group = groups_get_group($group_id);

        if (!$group) {
            return;
        }

        $action = '';
        if (isset($_POST['action'])) {
            $action = sanitize_key(wp_unslash($_POST['action']));
        }

        // Client doesn't distinguish between different request types, so we infer from user status.
        if (groups_is_user_member(bp_loggedin_user_id(), $group->id)) {
            $request_type = 'leave_group';
        } elseif (groups_check_user_has_invite(bp_loggedin_user_id(), $group->id) && 'joinleave_group' !== $action) {
            $request_type = 'accept_invite';
        } elseif ('private' === $group->status) {
            $request_type = 'request_membership';
        } else {
            $request_type = 'join_group';
        }

        switch ($request_type) {
            case 'join_group':
                if (!bp_current_user_can('groups_join_group', array('group_id' => $group->id))) {
                    esc_html_e('Error joining group', 'socialv');
                }

                check_ajax_referer('groups_join_group');

                if (!groups_join_group($group->id)) {
                    esc_html_e('Error joining group', 'socialv');
                } else {
                    echo '<a id="group-' . esc_attr($group->id) . '" class="group-button leave-group btn socialv-btn-outline-danger border-0" rel="leave" href="' . wp_nonce_url(bp_get_group_permalink($group) . 'leave-group', 'groups_leave_group') . '">' . esc_html__('Leave Group', 'socialv') . '</a>';
                }
                break;

            case 'accept_invite':
                if (!bp_current_user_can('groups_request_membership', array('group_id' => $group->id))) {
                    esc_html_e('Error accepting invitation', 'socialv');
                }

                check_ajax_referer('groups_accept_invite');

                if (!groups_accept_invite(bp_loggedin_user_id(), $group->id)) {
                    esc_html_e('Error requesting membership', 'socialv');
                } else {
                    echo '<a id="group-' . esc_attr($group->id) . '" class="group-button leave-group btn socialv-btn-outline-danger border-0" rel="leave" href="' . wp_nonce_url(bp_get_group_permalink($group) . 'leave-group', 'groups_leave_group') . '">' . esc_html__('Leave Group', 'socialv') . '</a>';
                }
                break;

            case 'request_membership':
                check_ajax_referer('groups_request_membership');

                if (!groups_send_membership_request(['user_id' => bp_loggedin_user_id(), 'group_id' => $group->id])) {
                    esc_html_e('Error requesting membership', 'socialv');
                } else {
                    echo '<a id="group-' . esc_attr($group->id) . '" class="group-button disabled pending membership-requested btn socialv-btn-outline-primary border-0" rel="membership-requested" href="' . bp_get_group_permalink($group) . '">' . esc_html__('Request Sent', 'socialv') . '</a>';
                }
                break;

            case 'leave_group':
                check_ajax_referer('groups_leave_group');

                if (!groups_leave_group($group->id)) {
                    esc_html_e('Error leaving group', 'socialv');
                } elseif ('public' === $group->status) {
                    echo '<a id="group-' . esc_attr($group->id) . '" class="group-button join-group btn socialv-btn-outline-primary border-0" rel="join" href="' . wp_nonce_url(bp_get_group_permalink($group) . 'join', 'groups_join_group') . '">' . esc_html__('Join Group', 'socialv') . '</a>';
                } else {
                    echo '<a id="group-' . esc_attr($group->id) . '" class="group-button request-membership btn socialv-btn-outline-primary border-0" rel="join" href="' . wp_nonce_url(bp_get_group_permalink($group) . 'request-membership', 'groups_request_membership') . '">' . esc_html__('Request Membership', 'socialv') . '</a>';
                }
                break;
        }

        exit;
    }

    function socialv_bp_get_group_join_button($button, $group)
    {
        // Already a member.
        if (!empty($group->is_member)) {

            // Stop sole admins from abandoning their group.
            $group_admins = groups_get_group_admins($group->id);
            if ((1 == count($group_admins)) && (bp_loggedin_user_id() === (int) $group_admins[0]->user_id)) {
                return false;
            }
            // Setup button attributes.
            $button['link_class']        = 'group-button leave-group btn socialv-btn-outline-danger border-0';

            // Not a member.
        } else {
            switch ($group->status) {
                case 'hidden':
                    return false;

                case 'public':
                    $button['link_class'] = 'group-button join-group btn socialv-btn-outline-primary border-0';
                    break;

                case 'private':
                    if ($group->is_invited) {
                        $button['link_class']        = 'group-button accept-invite btn socialv-btn-outline-primary border-0';
                    } elseif ($group->is_pending) {
                        $button['link_class']        = 'group-button pending membership-requested btn socialv-btn-outline-primary border-0';
                    } else {
                        $button['link_class']        = 'group-button request-membership btn socialv-btn-outline-primary border-0';
                    }

                    break;
            }
        }
        return $button;
    }

    function socialv_bp_directory_groups_search_form()
    {
        $query_arg = bp_core_get_component_search_query_arg('groups');

        if (!empty($_REQUEST[$query_arg])) {
            $search_value = stripslashes($_REQUEST[$query_arg]);
        } else {
            $search_value = bp_get_search_default_text('groups');
        }
        $search_form_html = '<div class="socialv-bp-searchform"><form action="#" method="get" id="search-groups-form">
          <div class="search-input"><input type="text" class="form-control" name="s" id="groups_search" placeholder="' . esc_attr($search_value) . '" />
          <button type="submit" id="groups_search_submit" class="btn-search"  name="groups_search_submit"><i class="iconly-Search icli"></i></button>
          </div></form></div>';
        return $search_form_html;
    }


    function socialv_bp_directory_members_search_form()
    {
        $query_arg = bp_core_get_component_search_query_arg('members');
        if (!empty($_REQUEST[$query_arg])) {
            $search_value = stripslashes($_REQUEST[$query_arg]);
        } else {
            $search_value = bp_get_search_default_text('members');
        }
        $search_form_html = '<div class="socialv-bp-searchform"><form action="#" method="get" id="search-members-form"><div class="search-input"><input type="text" class="form-control" name="' . esc_attr($query_arg) . '" id="members_search" placeholder="' . esc_attr($search_value) . '" />
        <button type="submit" id="members_search_submit" class="btn-search"  name="members_search_submit"><i class="iconly-Search icli"></i></button>
        </div></form></div>';
        return $search_form_html;
    }

    // User Groups Posts
    public function socialv_group_posts_count($group_id)
    {
        global $bp, $wpdb;
        $sql = "SELECT COUNT(*) FROM {$bp->activity->table_name}  
                          WHERE component = 'groups' 
                          AND  type IN ('activity_update','mpp_media_upload')
                          AND   item_id = %d";
        $total_posts = $wpdb->get_var($wpdb->prepare($sql, [$group_id]));
        return $total_posts;
    }

    // User Group Cover Image
    public function socialv_group_banner_img($user_id, $dir)
    {
        $cover_img_url = bp_attachments_get_attachment('url', array(
            'object_dir' => $dir,
            'item_id'    => $user_id,
        ));
        if (empty($cover_img_url)) {
            $cover_img_url = get_template_directory_uri() . '/assets/images/redux/banner.jpg';
        } else {
            $cover_img_url = $cover_img_url;
        } ?>
        <div class="cover-img">
            <img src="<?php echo esc_url($cover_img_url); ?>" alt="<?php esc_attr_e('Cover Image', 'socialv') ?>" loading="lazy">
        </div>
    <?php }


    function socialv_bp_groups_members_template_part()
    {
    ?>
        <div class="card-main">
            <div class="card-inner pt-0 pb-0">
                <div class="row align-items-center socialv-sub-tab-lists" id="subnav">
                    <div class="col-md-7 col-xl-7 item-list-tabs no-ajax ">
                        <ul class="list-inline m-0">
                            <li class="socialv-search">
                                <?php bp_directory_members_search_form(); ?>
                            </li>
                            <?php do_action('bp_members_directory_member_sub_types'); ?>
                        </ul>
                    </div>
                    <div class="col-md-5 col-xl-5">
                        <div id="group_members-order-select" class="last filter select-two-container socialv-data-filter-by position-relative">
                            <label for="group_members-order-by"><?php esc_html_e('Order By:', 'socialv'); ?></label>
                            <select id="group_members-order-by">
                                <option value="last_joined"><?php esc_html_e('Newest', 'socialv'); ?></option>
                                <option value="first_joined"><?php esc_html_e('Oldest', 'socialv'); ?></option>

                                <?php if (bp_is_active('activity')) : ?>
                                    <option value="group_activity"><?php esc_html_e('Group Activity', 'socialv'); ?></option>
                                <?php endif; ?>

                                <option value="alphabetical"><?php esc_html_e('Alphabetical', 'socialv'); ?></option>

                                <?php do_action('bp_groups_members_order_options'); ?>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-main card-space">
            <div class="card-inner">
                <div id="members-group-list" class="group_members dir-list">
                    <?php bp_get_template_part('groups/single/members'); ?>
                </div>
            </div>
        </div>
    <?php
    }

    function socialv_bp_groups_change_bp_nav_position()
    {
        if (bp_is_group()) {
            $nav = buddypress()->groups->nav;
            // Media
            if (class_exists('mediapress')) {
                $nav->edit_nav(array(
                    'name' => esc_html__('Media', 'socialv')
                ), MPP_GALLERY_SLUG, bp_current_item());


                bp_core_remove_subnav_item(MPP_GALLERY_SLUG, 'create', 'groups');
            }
        }
    }



    function socialv_get_group_manage_group_buttons()
    {
        if (!is_user_logged_in()) {
            return false;
        }
        // Check if Current User is admin.
        if (false == groups_is_user_admin(get_current_user_id(), bp_get_group_id())) {
            return false;
        }
    ?>
        <div class="group-button public generic-button manage-group-btn">
            <a href="<?php echo bp_get_group_admin_permalink(); ?>" class="group-button manage-group btn socialv-btn-outline-primary border-0"><?php esc_html_e('Manage Group', 'socialv'); ?></a>
        </div>
        <?php
    }



    function socialv_bp_get_group_type($type, $group)
    {
        if (bp_is_group()) {
            if ('public' === $group->status) {
                $type = '<h5><i class="icon-web"></i></h5>' . esc_html__("Public", 'socialv');
            } elseif ('hidden' === $group->status) {
                $type = '<h5><i class="iconly-Hide icli"></i></h5>' . esc_html__("Hidden", 'socialv');
            } elseif ('private' === $group->status) {
                $type = '<h5><i class="iconly-Lock icli"></i></h5>' . esc_html__("Private", 'socialv');
            } else {
                $type = ucwords($group->status) . ' ' . esc_html__('Group', 'socialv');
            }
        }
        return $type;
    }


    function socialv_bp_default_get_group_avatar($avatar)
    {
        if (strpos($avatar, 'group-avatars')) {
            return $avatar;
        } else {
            return '<img class="avatar rounded" loading="lazy" src="' . esc_url(BP_AVATAR_DEFAULT) . '" alt="' . esc_attr__('image', 'socialv') . '" width="90" height="90" />';
        }
    }



    function socialv_bp_before_default_cover_image_settings_parse_args($settings = array())
    {
        $settings['default_cover'] = SOCIALV_DEFAULT_COVER_IMAGE;

        return $settings;
    }


    function socialv_groups_default_avatar($avatar, $params)
    {
        if (isset($params['object']) && 'group' === $params['object']) {
            if (isset($params['type']) && 'thumb' === $params['type']) {
                $file = BP_AVATAR_DEFAULT;
            } else {
                $file = BP_AVATAR_DEFAULT;
            }

            $avatar = $file;
        }

        return $avatar;
    }


    function socialv_more_content_js()
    {
        wp_enqueue_script("socialv-more-content", get_template_directory_uri() . '/assets/js/more-content.min.js',  array('jquery'), socialv()->get_version(), true);
    }

    function socialv_bp_before_group_body()
    {
        $is_member = groups_is_user_member(get_current_user_id(), bp_get_group_id());
        if (bp_get_group_status() == 'private' && !$is_member  && !bp_current_user_can('bp_moderate')) {  ?>
            <div class="card-main card-space-bottom">
                <div class="card-inner socialv-locked-profile text-center"><i class="iconly-Lock icli"></i>
                    <?php printf(__('<h5>This Group is Private</h5><p>Join this group to view or participate in discussions.</p>', 'socialv')); ?>
                </div>
            </div>
<?php }
    }
}
