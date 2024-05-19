<?php

/**
 * SocialV\Utility\Custom_Helper\Helpers\Members class
 *
 * @package socialv
 */

namespace SocialV\Utility\Custom_Helper\Helpers;

use BP_Activity_Activity;
use BuddyPress_GIPHY;
use WP_Query;
use SocialV\Utility\Custom_Helper\Component;
use function SocialV\Utility\socialv;
use function add_action;

class Activity extends Component
{
    public $activity_filters;
    public $activity_class;
    public $socialv_option;
    private $display_posts_style;

    public function __construct()
    {
        $this->socialv_option  = $socialv_option = get_option('socialv-options');
        $this->display_posts_style = (class_exists('ReduxFramework') && $socialv_option['display_activities_posts_style'] == 'list') ? true : false;

        // Gallery
        $this->activity_filters = [
            'activity_update',
            'mpp_media_upload',
            'activity',
            'new_avatar',
            'updated_profile',
            'joined_group',
            'friendship_accepted,friendship_created',
            'bbp_topic_create',
            'created_group',
            'group_details_updated',
            'activity_share',
        ];

        remove_action("bp_register_activity_actions", "sv_register_activity_actions");
        add_action('bp_register_activity_actions', [$this, 'socialv_register_activity_actions']);

        // Activity Share 
        add_action('socialv_share_activity', [$this, 'socialv_share_activity'], 10, 1);

        if (class_exists('mediapress')) {
            add_filter('wp_video_shortcode', [$this, 'socialv_remove_poster_image_from_video_shortcode'], 10, 5);

            // Remove Mediapress notification url 
            remove_filter('bp_activity_get_permalink', 'mpp_filter_activity_permalink', 10);
            remove_action('bp_after_activity_post_form', 'mpp_activity_upload_buttons');
            remove_action('bp_after_activity_post_form', 'mpp_activity_dropzone');
            add_filter('wp_video_extensions', [$this, "socialv_append_video_types"]);
            add_action('socialv_activity_upload_buttons', [$this, 'socialv_activity_upload_buttons']);
            add_action('socialv_activity_upload_dropzone', [$this, 'socialv_activity_upload_dropzone']);
            remove_action('bp_activity_entry_content', 'mpp_activity_inject_attached_media_html');
            add_action('bp_activity_entry_content', [$this, 'socialv_mpp_activity_inject_attached_media_html']);
        }

        remove_filter('gamipress_bp_activity_details', 'gamipress_bp_points_activity_details', 10, 6);
        remove_filter('gamipress_bp_activity_details', 'gamipress_bp_achievement_activity_details', 10, 6);
        remove_filter('gamipress_bp_activity_details', 'gamipress_bp_step_activity_details', 10, 6);
        remove_filter('gamipress_bp_activity_details', 'gamipress_bp_rank_activity_details', 10, 6);
        remove_filter('gamipress_bp_activity_details', 'gamipress_bp_rank_requirement_activity_details', 10, 6);

        // Gif Plugin
        if (class_exists('BuddyPress_GIPHY')) :
            remove_action('bp_activity_post_form_options', array(BuddyPress_GIPHY::get_instance(), 'buddypress_giphy_post_gif_html'), 30);
            add_action('mpp_after_activity_upload_buttons', [$this, 'socialv_buddypress_giphy_post_gif_html'], 30);
        endif;

        // profile-update
        add_action('xprofile_updated_profile', [$this, "socialv_update_activity_action"], 10, 5);

        add_action("socialv_activity_header", [$this, "socialv_activity_header"]);
        add_action("socialv_social_share", [$this, "socialv_social_share"]);
        add_filter('bp_activity_recurse_comments_start_ul', function ($ul) {
            return "<ul class='activity-comments'>";
        });

        add_filter('bp_after_has_activities_parse_args', [$this, 'socialv_friends_only_activity_args']);
        add_filter('bp_has_activities', [$this, "socialv_reverse_activity_comments"]);
        add_action('wp_ajax_socialv_user_activity_callback', [$this, 'socialv_user_activity_callback']);
        add_action('wp_ajax_nopriv_socialv_user_activity_callback', [$this, 'socialv_user_activity_callback']);
        add_action('wp_ajax_socialv_activity_liked_users', [$this, 'socialv_activity_liked_users']);
        add_action('wp_ajax_nopriv_socialv_activity_liked_users', [$this, 'socialv_activity_liked_users']);

        remove_action('wp_ajax_activity_mark_unfav', 'bp_legacy_theme_unmark_activity_favorite');
        remove_action('wp_ajax_nopriv_activity_mark_unfav', 'bp_legacy_theme_unmark_activity_favorite');
        add_action('wp_ajax_activity_mark_unfav', [$this, 'socialv_unmark_activity_favorite']);
        add_action('wp_ajax_nopriv_activity_mark_unfav', [$this, 'socialv_unmark_activity_favorite']);

        add_action("socialv_activity_like_users", [$this, "socialv_activity_like_users"]);

        add_filter("bp_activity_content_before_save", function ($content, $obj) {
            if ($obj->type == "activity_update" && empty(trim($content))) {
                return "&nbsp;";
            }
            return $content;
        }, 9, 2);


        add_filter('bp_get_activity_content_body', function ($content) {
            $activity_content = preg_replace("/<p>(?:\s|&nbsp;)*?<\/p>/i", '', $content);

            if (empty(trim($activity_content))) {
                return '';
            }
            return $content;
        });

        add_filter("bp_get_activity_show_filters_options", function ($filters, $context) {
            foreach ($filters as $key => $val) {
                if (!in_array($key, $this->activity_filters)) {
                    unset($filters[$key]);
                }
            }
            return $filters;
        }, 2, 999);

        add_action("wp_footer", [$this, "get_users_activity_liked_modal"]);

        add_filter('bp_after_has_activities_parse_args', [$this, 'my_bp_activities_include_activity_types']);
        // set the content on activity blog post.
        if (isset($this->socialv_option['display_blog_post_type']) && $this->socialv_option['display_blog_post_type'] == '1') {
            add_filter('bp_get_activity_content_body', [$this, 'socialv_blogs_activity_content_with_read_more'], 9999, 2);
            add_filter('socialv_add_blog_post_as_activity_content_callback', [$this, 'socialv_add_blog_post_as_activity_content_callback'], 10, 3);
            add_filter('socialv_add_feature_image_blog_post_as_activity_content', [$this, 'socialv_add_feature_image_blog_post_as_activity_content_callback'], 10, 2);
        }

        // set the hide post option in activity page.
        if (isset($this->socialv_option['is_socialv_enable_hide_post']) && $this->socialv_option['is_socialv_enable_hide_post'] == '1') {
            add_action('socialv_activity_footer', [$this, 'socialv_activity_undo_post']);
        }

        // Set Comments order manage
        $comment_order = isset($this->socialv_option['display_comments_order']) ? $this->socialv_option['display_comments_order'] : 'ASC';
        if ($comment_order == 'DESC') {
            add_filter('bp_has_activities', function ($has) {
                global $activities_template;
                foreach ($activities_template->activities as &$a) {
                    if (is_array($a->children)) {
                        $a->children = array_reverse($a->children);
                    }
                }
                return $has;
            });
        }
        new PinActivity();
    }

    public function socialv_register_activity_actions()
    {

        $contexts =   ["sitewide", "member", "group", "activity"];
        $components =  ["sitewide", "members", "groups", "activity"];

        // Register the activity stream actions for all enabled gallery component.
        foreach ($components as $component) {
            bp_activity_set_action(
                $component,
                'activity_share',
                __('User shared activity', 'socialv'),
                false,
                __('Activity Shared', 'socialv'),
                $contexts
            );
        }
    }
    /**
     * Show Shared activity Post Start 
     **/
    function socialv_share_activity($activity_id)
    {
        global $wpdb;
        $activity = $wpdb->get_results("SELECT user_id, content, date_recorded, item_id, secondary_item_id, type from {$wpdb->base_prefix}bp_activity where id={$activity_id}");
        if (!empty($activity)) :
            $type = $activity[0]->type;
            $content = $activity[0]->content;
            $user_id = $activity[0]->user_id;
            $group_id = $activity[0]->item_id;
            $html = '<div class="shared-activity socialv-activity-parent ' . esc_attr($type) . '" id="activity-' . $activity_id . '">';
            $html .= $this->socialv_share_activity_header($activity_id);
            $html .= '<div class="activity-content">';
            // Profile Activity
            if (in_array($type, array('new_avatar', 'new_member', 'friendship_created', 'updated_profile'), true)) {
                $html .= $this->socialv_activity_content_avatar($user_id);
            }
            // Group Activity 
            else if (in_array($type, array('joined_group', 'created_group'), true)) {
                $html .= $this->socialv_activity_content_created_group($group_id);
            }
            // Media Activity
            else if ($type === 'mpp_media_upload') {
                $html .= '<div class="activity-inner">';
                if (preg_match('/\s/', $content)) {
                    $html  .= '<p>' . stripslashes($content) . '</p>';
                } else {
                    $html .= '';
                }
                $html .= '</div>';
                $html .= $this->socialv_get_mpp_injected_attached_media_html($activity_id);;
            }  // Blog Activity
            else if ($type === 'new_blog_post') {
                $blog_post = get_post($activity[0]->secondary_item_id);
                $content = apply_filters('socialv_add_blog_post_as_activity_content_callback', '', $blog_post, $activity);
                $html .=  '<div class="activity-inner">' . $content . '</div>';
            } else {
                $html .= '<div class="activity-inner">';
                if (!empty($content)) {
                    $html .= '<p>' . stripslashes($content) . '</p>';
                }
                // Gif Activity
                if (class_exists('BuddyPress_GIPHY')) :
                    $html .=  $this->socialv_activity_gif_content($activity_id);
                endif;
                $html .= '</div>';
            }
            $html .= '</div>';
            $html .= '</div>';
            echo $html;
        endif;
    }

    function socialv_activity_content_avatar($user_id)
    {
        $cover_src = bp_attachments_get_attachment('url', array(
            'item_id' => $user_id
        ));
        $profile_url = bp_core_fetch_avatar(array(
            'item_id'   => $user_id,
            'type'      => 'full',
            'width'     => 140,
            'height'    => 140,
            'class'     => 'rounded',
        ));
        $user_url =  bp_core_get_user_domain($user_id);
        $user_name =  bp_core_get_user_displayname($user_id);
        $meta_name =  bp_core_get_username($user_id);
        $meta_url =  wp_nonce_url(
            add_query_arg(
                array(
                    'r' => $meta_name,
                ),
                bp_get_activity_directory_permalink()
            )
        );
        $content = '<div class="activity-inner"><div class="bp-member-activity-preview socialv-profile-activity">';
        $content .= '<div class="bp-member-preview-cover">';
        $content .= '<a href="' . esc_url($user_url) . '">';
        if (!empty($cover_src)) :
            $content .= '<img src="' . esc_url($cover_src) . '" alt=" ' . esc_attr__('image', 'socialv') . '" loading="lazy" />.';
        else :
            $content .= '<img src="' . esc_url(SOCIALV_DEFAULT_COVER_IMAGE) . '" alt="' . esc_attr__('activity', 'socialv') . '" loading="lazy" />.';
        endif;
        $content .= '</a>';
        $content .= '</div>';

        $content .= '<div class="bp-member-short-description">';
        if (!empty($profile_url)) :
            $content .= '<div class="bp-member-avatar-content has-cover-image has-cover-image"><a href="' . esc_url($user_url) . '">' . wp_kses_post($profile_url) . '</a></div>';
        endif;
        $content .= '<div class="socialv-profile-detail">
                        <h5 class="bp-member-short-description-title">
                            <a href="' . esc_url($user_url) . '">' . esc_html($user_name) . '</a>
                        </h5>
                        <div class="bp-member-nickname">
                            <a href="' . esc_url(is_user_logged_in() ? $meta_url : $user_url) . '">@' . esc_html($meta_name) . '</a>
                        </div>
                     </div>';
        $content .= '</div></div></div>';
        return $content;
    }

    function socialv_activity_content_created_group($group_id)
    {
        $group = groups_get_group($group_id);
        $group_url = bp_get_group_permalink($group);
        $group_name = bp_get_group_name($group);
        $group_cover_src =  bp_get_group_cover_url($group);
        $group_profile =  bp_core_fetch_avatar(
            array(
                'item_id' => $group_id,
                'object'  => 'group',
                'type'    => 'full',
                'width'  => 140,
                'height'  => 140,
                'class' => 'rounded',
            )
        );
        $content = '<div class="activity-inner"><div class="bp-group-activity-preview socialv-group-activity">';
        $content .= '<div class="bp-group-preview-cover"><a href="' . esc_url($group_url) . '">';
        if (!empty($group_cover_src)) :
            $content .= '<img src="' . esc_url($group_cover_src) . '" alt="' . esc_attr__('image', 'socialv') . '" loading="lazy" />';
        else :
            $content .= '<img src="' . esc_url(SOCIALV_DEFAULT_COVER_IMAGE) . '" alt="' . esc_attr__('group', 'socialv') . '" loading="lazy" />';
        endif;
        $content .= '</a></div>';

        $content .= '<div class="bp-group-short-description">';
        if (!empty($group_profile)) :
            $content .=  '<div class="bp-group-avatar-content has-cover-image">
                        <a href="' . esc_url($group_url) . '">
                            ' . wp_kses_post($group_profile) . '
                        </a>
                    </div>';
        endif;

        $content .= '<div class="bp-group-short-description-title socialv-profile-detail"><a href="' . esc_url($group_url) . '">' . esc_html($group_name) . '</a>';
        $content .= '<div class="activity-group-meta">';
        $count = bp_get_group_total_members($group);
        $member_count = ($count != 1) ? esc_html__("Members", "socialv") . " " . $count : esc_html__("Member", "socialv") . " " . $count;
        $group_type = bp_get_group_type($group);
        $check_group_type = " " . strtolower($group_type);
        $args = [
            "group_type"    => $group_type,
            "member_count"  => $member_count
        ];
        $icons = [
            "public"    => "icon-web",
            "private"   => "iconly-Lock icli",
            "hidden"    => "iconly-Hide icli",
            "member"    => "iconly-User2 icli"
        ];

        $group_icon = "public";
        if (strpos($check_group_type, "public"))  $group_icon = "public";

        if (strpos($check_group_type, "private"))  $group_icon = "private";

        if (strpos($check_group_type, "hidden")) $group_icon = "hidden";
        if (!bp_is_group()) {
            $group_type = '<span class="socialv-group-type"><span> <i class="' . $icons[$group_icon] . '"></i>' . $args["group_type"] . '</span></span>';
        } else {
            $group_type = '<span class="socialv-group-type"><span>' . $args["group_type"] . '</span></span>';
        }
        $member_count = '<span class="socialv-group-members"><span><i class="' . $icons['member'] . '"></i>' . $args["member_count"] . '</span></span>';

        $content .= $group_type . $member_count;
        $content .= '</div>';
        $content .=  '</div></div></div></div>';
        return $content;
    }

    function socialv_activity_gif_content($activity_id)
    {
        $bp_activity_gif_data = bp_activity_get_meta($activity_id, '_bp_activity_gif_data', true);
        if (!empty($bp_activity_gif_data['bp_activity_gif'])) {
            $content = '<div class="activity-attached-gif-container">
                <div class="gif-image-container">
                    <div class="gif-player">
                        <img src="' . esc_url($bp_activity_gif_data['bp_activity_gif']) . '" />
                    </div>
                </div>
            </div>';
            return  $content;
        }
    }

    function socialv_share_activity_header($activity_id, $args = [])
    {
        global $wpdb;
        global $activities_template;

        $activity = $wpdb->get_results("SELECT user_id, action, content, date_recorded, type from {$wpdb->base_prefix}bp_activity where id={$activity_id}");
        $user_id = $activity[0]->user_id;

        $action = $activity[0]->action;
        $date_recorded = $activity[0]->date_recorded;
        $r = bp_parse_args(
            $args,
            array(
                'no_timestamp' => false,
            )
        );
        $time_since = sprintf(
            '<span class="time-since" data-livestamp="%1$s">%2$s</span>',
            bp_core_get_iso8601_date($date_recorded),
            bp_core_time_since($date_recorded)
        );
        $userlink = bp_core_get_userlink($user_id);
        $profile_link = trailingslashit(bp_core_get_user_domain($user_id) . bp_get_profile_slug());
        $user_profile_link = '<a href="' . $profile_link . '">' . bp_core_get_user_displayname($user_id) . '</a>';

        // Add badge HTML if the user is verified
        $user_badge = (bp_get_activity_user_id() != $user_id) ? socialv()->socialv_get_verified_badge($user_id) : '';
        $activity_action = str_replace($userlink, $userlink . $user_badge . ' <span class="activity-subtext">', $action);
        $activity_action = str_replace($user_profile_link, $user_profile_link . $user_badge . '<span class="activity-subtext">', $activity_action);
        $activity_action .= "</span>";
        $loop_avatar_width = apply_filters("activity_loop_avatar_width", "65");
        $loop_avatar_height = apply_filters("activity_loop_avatar_height", "65");
        $content = '<div class="socialv-activity-header">
            <div class="socialv-activity-header-left">
                <div class="activity-avatar-sv">
                    <a href="' . bp_get_activity_user_link() . '">
                    ' . bp_get_activity_avatar('user_id=' . $user_id . '&type=full&width=' . $loop_avatar_width . '&height=' . $loop_avatar_height . '&class=rounded-circle') . '
                    </a>
                </div>
            </div>
            <div class="activity-header-wrapper">
                <div class="activity-header">
                    ' . apply_filters_ref_array('bp_get_activity_action', array(
            $activity_action,
            &$activities_template->activity,
            $r
        )) . '
                    ' . wp_kses($time_since, 'post') . '
                </div>
            </div>
        </div>';
        return $content;
    }

    /**
     * Show Shared activity Post End 
     **/

    function socialv_update_activity_action($user_id, $posted_field_ids, $errors, $old_values, $new_values)
    {

        $is_update_displayname = false;
        foreach ($old_values as $value) {
            if (in_array(bp_core_get_user_displayname(get_current_user_id()), $value))
                $is_update_displayname = true;
        }
        if ($is_update_displayname && bp_has_activities(bp_ajax_querystring('activity') . '&action=mpp_media_upload&user_id=' . $user_id)) {
            while (bp_activities()) : bp_the_activity();
                $ac = new BP_Activity_Activity(bp_get_activity_id());
                $ac->save();
            endwhile;
        }
    }
    function socialv_friends_only_activity_args($args)
    {
        if (isset($this->socialv_option['display_activity_showing_friends']) && $this->socialv_option['display_activity_showing_friends'] == 'no') {
            if (!bp_is_activity_directory() || !is_user_logged_in() || !empty($args['scope'])) {
                return $args;
            }

            $user_id = get_current_user_id();

            $user_ids = [];

            if (function_exists('friends_get_friend_user_ids')) {
                $user_ids = friends_get_friend_user_ids($user_id);
            }

            // include user's own too?
            array_push($user_ids, $user_id);

            $args['user_id'] = $user_ids;
        }

        return $args;
    }
    function socialv_reverse_activity_comments($has)
    {
        global $activities_template;

        foreach ($activities_template->activities as &$a) {
            if (is_array($a->children))
                $a->children = array_reverse($a->children);
        }

        return $has;
    }
    function my_bp_activities_include_activity_types($retval)
    {

        if (empty($retval['action'])) {
            $actions = bp_activity_get_actions_for_context();
            foreach ($actions as $action) {

                // Friends activity collapses two filters into one.
                if (in_array($action['key'], array('friendship_accepted', 'friendship_created'))) {
                    $action['key'] = 'friendship_accepted,friendship_created';
                }

                // The 'activity_update' filter is already used by the Activity component.
                if ('bp_groups_format_activity_action_group_activity_update' === $action['format_callback']) {
                    continue;
                }
                if (isset($this->socialv_option['display_blog_post_type']) && $this->socialv_option['display_blog_post_type'] == '1') {
                    if (!in_array($action['key'], ["new_blog_comment", "activity_comment"]))
                        $filters[] = $action['key'];
                } else {
                    if (!in_array($action['key'], ["new_blog_post", "new_blog_comment", "activity_comment"]))
                        $filters[] = $action['key'];
                }
            }
            $filters = array_merge($filters, $this->activity_filters);
            $retval['action'] = apply_filters("socialv_add_actions_to_activity", $filters);
        }
        if (bp_is_user_activity() && !bp_activity_can_favorite()) {
            $retval['object'] = 'activity';
            $retval['primary_id'] = 'groups';
        }
        return $retval;
    }

    // Remove the 'poster' parameter from the shortcode
    public function socialv_remove_poster_image_from_video_shortcode($html, $atts, $video, $post_id, $library)
    {
        $html = str_replace(' poster=', '', $html);
        return $html;
    }

    public function socialv_append_video_types($exts)
    {
        $exts[] = 'mov';
        return $exts;
    }

    public function socialv_activity_upload_buttons()
    {
        $component    = mpp_get_current_component();
        $component_id = mpp_get_current_component_id();

        // If activity upload is disabled or the user is not allowed to upload to current component, don't show.
        if (!mpp_is_activity_upload_enabled($component) || !mpp_user_can_upload($component, $component_id)) {
            return;
        }

        // if we are here, the gallery activity stream upload is enabled,
        // let us see if we are on user profile and gallery is enabled.
        if (!mpp_is_enabled($component, $component_id)) {
            return;
        }
        // if we are on group page and either the group component is not enabled or gallery is not enabled for current group, do not show the icons.
        if (function_exists('bp_is_group') && bp_is_group() && (!mpp_is_active_component('groups') || !(function_exists('mpp_group_is_gallery_enabled') && mpp_group_is_gallery_enabled()))) {
            return;
        }
        // for now, avoid showing it on single gallery/media activity stream.
        if (mpp_is_single_gallery() || mpp_is_single_media()) {
            return;
        }

?>
        <div class="mpp-upload-buttons socialv-upload-file">
            <div id="mpp-activity-upload-buttons">
                <?php do_action('mpp_before_activity_upload_buttons'); // allow to add more type.  
                ?>

                <?php if (mpp_is_active_type('photo') && mpp_component_supports_type($component, 'photo')) : ?>
                    <a href="#" id="mpp-photo-upload" data-media-type="photo" title="<?php esc_attr_e('Upload photo', 'socialv'); ?>">
                        <label class="socialv-upload-btn-labels">
                            <span class="upload-icon"><i class="iconly-Image-2 icli"></i> </span>
                            <span><?php esc_html_e("Photos", "socialv"); ?></span>
                        </label>
                    </a>
                <?php endif; ?>

                <?php if (mpp_is_active_type('audio') && mpp_component_supports_type($component, 'audio')) : ?>
                    <a href="#" id="mpp-audio-upload" data-media-type="audio" title="<?php esc_attr_e('Upload audio', 'socialv'); ?>">
                        <label class="socialv-upload-btn-labels">
                            <span class="upload-icon"><i class="iconly-Game icli"></i></span>
                            <span><?php esc_html_e("Audios", "socialv"); ?> </span>
                        </label>
                    </a>
                <?php endif; ?>

                <?php if (mpp_is_active_type('video') && mpp_component_supports_type($component, 'video')) : ?>
                    <a href="#" id="mpp-video-upload" data-media-type="video" title="<?php esc_attr_e('Upload video', 'socialv'); ?>">
                        <label class="socialv-upload-btn-labels">
                            <span class="upload-icon"><i class="iconly-Video icli"></i></span>
                            <span><?php esc_html_e("Videos", "socialv"); ?> </span>
                        </label>
                    </a>
                <?php endif; ?>

                <?php if (mpp_is_active_type('doc') && mpp_component_supports_type($component, 'doc')) : ?>
                    <a href="#" id="mpp-doc-upload" data-media-type="doc" title="<?php esc_attr_e('Upload document', 'socialv'); ?>">
                        <label class="socialv-upload-btn-labels">
                            <span class="upload-icon"><i class="iconly-Document icli"></i></span>
                            <span> <?php esc_html_e("Documents", "socialv"); ?> </span>
                        </label>
                    </a>
                <?php endif; ?>

            </div>
            <?php do_action('mpp_after_activity_upload_buttons'); // allow to add more type.  
            ?>
        </div>
    <?php
    }

    function socialv_activity_upload_dropzone()
    {
    ?>
        <div id="mpp-activity-media-upload-container" class="mpp-media-upload-container mpp-upload-container-inactive">
            <!-- mediapress upload container -->
            <a href="#" class="mpp-upload-container-close" title="<?php esc_attr_e('Close', 'socialv'); ?>"><span>x</span></a>
            <!-- append uploaded media here -->
            <div id="mpp-uploaded-media-list-activity" class="mpp-uploading-media-list">
                <ul class="list-inline"></ul>
            </div>

            <?php do_action('mpp_after_activity_upload_medialist'); ?>

            <?php if (mpp_is_file_upload_enabled('activity')) : ?>
                <!-- drop files here for uploading -->
                <?php mpp_upload_dropzone('activity'); ?>
                <?php do_action('mpp_after_activity_upload_dropzone'); ?>
                <!-- show any feedback here -->
                <div id="mpp-upload-feedback-activity" class="mpp-feedback">
                    <ul></ul>
                </div>
            <?php endif; ?>
            <input type='hidden' name='mpp-context' class='mpp-context' value="activity" />
            <?php do_action('mpp_after_activity_upload_feedback'); ?>

            <?php if (mpp_is_remote_enabled('activity')) : ?>
                <!-- remote media -->
                <div class="mpp-remote-media-container">
                    <div class="mpp-feedback mpp-remote-media-upload-feedback">
                        <ul></ul>
                    </div>
                    <div class="mpp-remote-add-media-row mpp-remote-add-media-row-activity">
                        <input type="text" placeholder="<?php esc_attr_e('Enter a link', 'socialv'); ?>" value="" name="mpp-remote-media-url" id="mpp-remote-media-url" class="mpp-remote-media-url" />
                        <button id="mpp-add-remote-media" class="mpp-add-remote-media"><i class="icon-add"></i></button>
                    </div>

                    <?php wp_nonce_field('mpp_add_media', 'mpp-remote-media-nonce'); ?>
                </div>
                <!-- end of remote media -->
            <?php endif; ?>

        </div><!-- end of mediapress form container -->
    <?php
    }

    public function socialv_activity_header($args = [])
    {
        global $activities_template;

        $activity =  $activities_template->activity;
        $activity_id = bp_get_activity_id();
        $user_id = $activity->user_id;
        $activity_action = $activity->action;
        $date_recorded = $activity->date_recorded;

        $r = bp_parse_args(
            $args,
            array(
                'no_timestamp' => false,
            )
        );

        $time_since = sprintf(
            '<span class="time-since" data-livestamp="%1$s">%2$s</span>',
            bp_core_get_iso8601_date($date_recorded),
            bp_core_time_since($date_recorded)
        );


        $userlink = bp_core_get_userlink($user_id);

        $profile_link = trailingslashit(bp_core_get_user_domain($activity->user_id) . bp_get_profile_slug());
        $user_profile_link = '<a href="' . $profile_link . '">' . bp_core_get_user_displayname($activity->user_id) . '</a>';
        $activity_action = str_replace($userlink, $userlink . ' <span class="activity-subtext">', $activity_action);
        $activity_action = str_replace($user_profile_link, $user_profile_link . '<span class="activity-subtext">', $activity_action);
        $activity_action .= "</span>";
        $loop_avatar_width = apply_filters("activity_loop_avatar_width", "65");
        $loop_avatar_height = apply_filters("activity_loop_avatar_height", "65");

    ?>
        <div class="socialv-activity-header-left">
            <div class="activity-avatar-sv">
                <a href="<?php bp_activity_user_link(); ?>">
                    <?php bp_activity_avatar('type=full&width=' . $loop_avatar_width . '&height=' . $loop_avatar_height . '&class=rounded-circle'); ?>
                </a>
            </div>
        </div>
        <div class="activity-header-wrapper">
            <div class="activity-header">
                <!-- action -->
                <?php
                echo apply_filters_ref_array('bp_get_activity_action', array(
                    $activity_action,
                    &$activities_template->activity,
                    $r
                ));
                ?>

                <!-- time since -->
                <?php echo wp_kses($time_since, 'post'); ?>

            </div>
            <?php if (is_user_logged_in()) : ?>
                <div class="socialv-activity-header-right">

                    <div class="dropdown">
                        <a class="btn-dropdown" href="javascript:vloid(0);" role="button" id="context-<?php echo esc_attr($activity_id); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon-toggle-dot"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="context-<?php echo esc_attr($activity_id); ?>">
                            <?php if (bp_activity_can_favorite()) : ?>
                                <li>
                                    <?php if (!bp_get_activity_is_favorite()) : ?>

                                        <a href="<?php bp_activity_favorite_link(); ?>" class="dropdown-item fav">
                                            <?php esc_html_e("Add Favorite", "socialv"); ?>
                                        </a>

                                    <?php else : ?>

                                        <a href="<?php bp_activity_unfavorite_link(); ?>" class="dropdown-item unfav">
                                            <?php esc_html_e("Remove Favorite", "socialv"); ?>
                                        </a>

                                    <?php endif; ?>

                                </li>
                            <?php endif; ?>

                            <li>
                                <?php if ($this->is_socialv_user_pin(bp_get_activity_id(), "_socialv_user_pinned_activity")) : ?>
                                    <a class="dropdown-item socialv-user-activity-btn has-socialv-pin" data-id="<?php echo esc_attr($activity_id); ?>" href="javascript:void(0)" data-unpin="<?php esc_attr_e("Unpin", "socialv"); ?>" data-pin="<?php esc_attr_e("Pin to Top", "socialv"); ?>">
                                        <?php esc_html_e("Unpin", "socialv"); ?>
                                    </a>
                                <?php else : ?>
                                    <a class="dropdown-item socialv-user-activity-btn has-socialv-pin" data-id="<?php echo esc_attr($activity_id); ?>" href="javascript:void(0)" data-unpin="<?php esc_attr_e("Unpin", "socialv"); ?>" data-pin="<?php esc_attr_e("Pin to Top", "socialv"); ?>">
                                        <?php esc_html_e("Pin to Top", "socialv"); ?>
                                    </a>
                                <?php endif; ?>
                            </li>

                            <?php if (shortcode_exists("imt_report_button")) : ?>
                                <li>
                                    <?php echo do_shortcode("[imt_report_button id=$activity_id type=activity classes='dropdown-item']"); ?>
                                </li>
                            <?php endif; ?>
                            <?php
                            if (isset($this->socialv_option['is_socialv_enable_hide_post']) && $this->socialv_option['is_socialv_enable_hide_post'] == '1') {
                                if (get_current_user_id() !== bp_get_activity_user_id()) { ?>
                                    <li><a href="javascript:void(0)" data-type="hide" data-activity_id="<?php echo esc_attr($activity_id); ?>" data-id="<?php echo esc_attr($user_id); ?>" class="dropdown-item hide-post-btn">
                                            <?php esc_html_e("Hide Post", "socialv"); ?>
                                        </a></li>
                            <?php }
                            } ?>
                            <?php if (bp_activity_user_can_delete()) : ?>
                                <a class="dropdown-item socialv_delete-activity" href="<?php bp_activity_delete_url(); ?>" data-success="<?php esc_attr_e('Activity deleted successfully', 'socialv') ?>">
                                    <?php esc_html_e("Delete", "socialv") ?>
                                </a>
                            <?php endif; ?>

                            <?php do_action("socialv_before_activity_header_right_end"); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    function socialv_activity_group_meta()
    {
        global $activities_template;

        $group = bp_get_group($activities_template->activity->item_id);
        $count = bp_get_group_total_members($group->id);
        $member_count = ($count != 1) ? esc_html__("Members", "socialv") . " " . $count : esc_html__("Member", "socialv") . " " . $count;
        $group_type = bp_get_group_type($group->id);

        $check_group_type = " " . strtolower($group_type);
        $args = [
            "group_type"    => $group_type,
            "member_count"  => $member_count
        ];

        $icons = [
            "public"    => "icon-web",
            "private"   => "iconly-Lock icli",
            "hidden"    => "iconly-Hide icli",
            "member"    => "iconly-User2 icli"
        ];

        $group_icon = "public";
        if (strpos($check_group_type, "public"))  $group_icon = "public";

        if (strpos($check_group_type, "private"))  $group_icon = "private";

        if (strpos($check_group_type, "hidden")) $group_icon = "hidden";
        if (!bp_is_group()) {
            $group_type = '<span class="socialv-group-type"><span> <i class="' . $icons[$group_icon] . '"></i>' . $args["group_type"] . '</span></span>';
        } else {
            $group_type = '<span class="socialv-group-type"><span>' . $args["group_type"] . '</span></span>';
        }
        $member_count = '<span class="socialv-group-members"><span><i class="' . $icons['member'] . '"></i>' . $args["member_count"] . '</span></span>';

        $content = $group_type . $member_count;
        return apply_filters("socialv_activity_group_meta_html", $content, $args, $icons);
    }

    public function socialv_mpp_activity_inject_attached_media_html()
    {
        $activity_id = bp_get_activity_id();
        echo $this->socialv_get_mpp_injected_attached_media_html($activity_id);
    }

    public function socialv_get_mpp_injected_attached_media_html($activity_id = false)
    {
        $activity_id = $activity_id ? $activity_id : bp_get_activity_id();;
        $media_ids = mpp_activity_get_attached_media_ids($activity_id);
        if (empty($media_ids)) {
            return;
        }

        $lightbox = mpp_get_option('load_lightbox');
        $lightbox_enabled = !empty($lightbox) ? 1 : 0;
        $gallery_class   = $lightbox_enabled ? ' zoom-gallery' : '';
        $count = count($media_ids);
        $no_of_media = ($count >= 5) ? '5' : $count;
        ob_start();
        if ($this->display_posts_style == true) {
            if ($count > 1) {
                echo '<div class="swiper socialv-gallery-status socialv-swiper-slider' . $gallery_class . '"> <div class="swiper-wrapper">';
                $loop_inner_class = "swiper-slide";
            } else {
                echo '<div class="socialv-gallery-status' . $gallery_class . '">';
                $loop_inner_class = "grid-item";
            }
            foreach ($media_ids as $key => $media_id) {
                if ($key > 5) break;
                $media = mpp_get_media($media_id);
                if ($media) { ?>
                    <div class="<?php echo esc_attr($loop_inner_class); ?>">
                        <div class="video-wrap">
                            <?php echo $this->socialv_generate_image_div($media, $activity_id, $count); ?>
                        </div>
                    </div>
                <?php   }
            }
            if ($count > 1) {
                echo '</div><div class="swiper-pagination"></div>';
            }
            echo '</div>';
        } else {

            // =======Grid Style===========

            echo '<div class="row post-row column-' . $no_of_media . $gallery_class . '">';
            foreach ($media_ids as $key => $media_id) {
                $media = mpp_get_media($media_id);
                if ($media) {
                    $class = 'post-column ';
                    $div_inner = '';
                    if ($count == 1) {
                        $class .= 'col-12';
                        $div_inner = $this->socialv_generate_image_div($media, $activity_id, $count);
                    } elseif ($count == 2) {
                        $class .= 'col-6';
                        $div_inner .= $this->socialv_generate_image_div($media, $activity_id, $count);
                    } elseif ($count == 3) {
                        $class .= ($key == 0) ? 'col-12' : 'col-6';
                        $div_inner .= $this->socialv_generate_image_div($media, $activity_id, $count);
                    } elseif ($count == 4) {
                        $class .= 'col-6';
                        $div_inner .= $this->socialv_generate_image_div($media, $activity_id, $count);
                    } elseif ($count >= 5) {
                        $class .= ($key < 5) ? 'col-12' : 'd-none';
                        $div_inner .= $this->socialv_generate_image_div($media, $activity_id, $count);
                        $div_inner .= ($count > 5 && $key == 4) ? ('<span class=socialv-media-total>+' . esc_html($count - 5) . '</span>') : '';
                    }
                    if ($count >= 5 && $key == 0) {
                        echo '<div class="col-6 post-column"><div class="row post-row two">';
                    } elseif ($count >= 5 && $key == 2) {
                        echo '</div></div><div class="col-6 post-column"><div class="row post-row three">';
                    }
                    echo '<div class="' . esc_attr($class) . '">' . $div_inner . '</div>';
                    if ($count >= 5) {
                        if ($media->type == 'audio' && $key == 3) {
                            echo '</div></div>';
                        } else if ($media->type != 'audio' && $key == 4) {
                            echo '</div></div>';
                        }
                    }
                }
            }
            echo '</div>';

            // =====================
        }

        return ob_get_clean();
    }

    // Helper function to generate inner image div
    function socialv_generate_image_div($media, $activity_id, $count)
    {
        $type = $media->type;
        $media_id = $media->id;
        $media_src = '';
        $link_wrapper = ($this->display_posts_style == false && $count != 1) ? ('<a class="mpp-activity-item-title" href="' . mpp_get_media_permalink($media_id) . '" title="' . esc_attr(mpp_get_media_title($media_id)) . '" data-mpp-type="' . esc_attr($type) . '" data-mpp-activity-id="' . esc_attr($activity_id) . '" data-mpp-media-id="' . esc_attr($media_id) . '">' . mpp_get_media_title($media_id) . '</a>') : '';

        if ($type == 'photo') {
            $is_external = mpp_get_media_meta($media_id, "_mpp_source", true);
            if ($is_external) {
                $media_src = $is_external;
                $img_attrs = "target=_blank";
            } else {
                $media_src = mpp_get_media_src('full', $media);
                $img_attrs = "class=popup-zoom mpp-media mpp-activity-media mpp-activity-media-" . $type;
            }

            $bg_img = (($this->socialv_option['is_post_blur_style'] == 'no') || ($this->display_posts_style == false && $count == 1)) ? ('style="background-image: url(' . esc_url($media_src) . ') "') : '';
            $full_img_class = (($this->socialv_option['is_post_blur_style'] == 'yes') && $count == 1) ? 'single-post-img' : '';

            $div_html = '<div class="post-wrap-inner mpp-' . $type . '-content mpp-activity-' . $type . '-content ' . $full_img_class . '" ' .  $bg_img . ' >
                        <a href="' . esc_url($media_src) . '" ' . esc_attr($img_attrs) . '>
                            <img src="' . esc_url($media_src) . '" class="mpp-attached-media-item" alt="' . esc_attr__('Status Image', 'socialv') . '" loading="lazy">
                        </a></div>';

            return $div_html;
        } elseif ($type == 'video') {
            if (mpp_is_oembed_media($media)) {
                return '<div class="post-wrap-inner mpp-activity-media-list mpp-activity-video-player">' . mpp_get_oembed_content($media, 'full') . $link_wrapper . '</div>';
            } else {
                $media_file = mpp_get_media_src('', $media);
                return '<div class="post-wrap-inner mpp-activity-media-list mpp-activity-video-player">' . do_shortcode("[video src=" . $media_file . " controls]") . $link_wrapper . '</div>';
            }
        } elseif ($type == 'audio') {
            $link_wrapper = ($count > 5) ? $link_wrapper : '';
            $div_html = '<div class="post-wrap-inner mpp-activity-media-list mpp-activity-audio-player"><audio src="' . mpp_get_media_src('', $media) . '" controls></audio>' . $link_wrapper . '</div>';
            return $div_html;
        } else {
            $url   = !mpp_is_doc_viewable($media) ? mpp_get_media_src('', $media) : mpp_get_media_permalink($media);
            $class = !mpp_is_doc_viewable($media) ? 'mpp-no-lightbox' : '';
            $target = !mpp_is_doc_viewable($media) ? '' : 'target=_blank';
            $div_html = '<div class="post-wrap-inner mpp-activity-media-list" data-mpp-type="' . esc_attr($type) . '">
                        <a href="' . esc_url($url) . '" ' . esc_attr($target) . ' class="mpp-media mpp-activity-media mpp-activity-media-doc ' . esc_attr($class) . '" data-mpp-type="' . esc_attr($type) . '" data-mpp-activity-id="' . esc_attr($activity_id) . '" data-mpp-media-id="' . esc_attr($media_id) . '">
                            <img src="' . mpp_get_media_src('thumbnail', $media_id) . '" class="mpp-attached-media-item " title="' . esc_attr(mpp_get_media_title($media_id)) . '" loading="lazy" />
                        </a></div>';

            return $div_html;
        }
    }

    function socialv_social_share()
    {
        $url   = urlencode(bp_get_activity_directory_permalink() . "p/" . bp_get_activity_id());
        $title = rawurlencode(strip_tags(bp_get_activity_action()));
        $args = [
            'facebook' => [
                'url'  => "http://www.facebook.com/sharer/sharer.php?u=$url",
                'icon' => 'icon-facebook',
                'title' => esc_html__('Facebook', 'socialv'),
                'parameter' => 'target=_blank',
            ],
            'twitter'  => [
                'url'  => "https://twitter.com/intent/tweet?source=$url&text=$title:$url",
                'icon' => 'icon-twitter',
                'title' => esc_html__('Twitter', 'socialv'),
                'parameter' => 'target=_blank',
            ],
            'linkedin' => [
                'url'  => "http://www.linkedin.com/shareArticle?mini=true&url=$url&title=$title",
                'icon' => 'icon-linkedin',
                'title' => esc_html__('LinkedIn', 'socialv'),
                'parameter' => 'target=_blank',
            ],
            'pinterest' => [
                'url'  => "http://pinterest.com/pin/create/button/?url=$url&description=$title",
                'icon' => 'icon-pinterest',
                'title' => esc_html__('Pinterest', 'socialv'),
                'parameter' => 'target=_blank',
            ],
            // Share activity Post
            'share_activity' => [
                'url'  => ((bp_get_activity_type() === 'activity_share') ? bp_activity_get_meta(bp_get_activity_id(), 'shared_activity_id', true) : bp_get_activity_id()),
                'icon' => 'icon-share-box',
                'title' => esc_html__('Share on activity', 'socialv'),
                'parameter' => '',
            ],

        ];
        $content = "";
        foreach ($args as $key => $share) {
            $class = !empty($share['class']) ? $key . "-share " . $share['class'] : $key . "-share";
            $content .= '<li><a href="' . $share['url'] . '" ' . esc_attr($share['parameter']) . ' class=' . esc_attr($class) . '><i class="' . esc_attr($share['icon']) . '"></i>' . $share['title'] . '</a></li>';
        }
        $content = "<ul class='sharing-options'>$content</ul>";
        echo apply_filters("socialv_activity_social_share", $content, $args);
    }

    function is_socialv_user_pin($activity_id, $key)
    {
        $user = wp_get_current_user();
        $user_id = $user->ID;

        $posts = get_user_meta($user_id, $key, true);
        $post_array = explode(', ', $posts);

        if (in_array($activity_id, $post_array)) {
            return true;
        }

        return false;
    }

    function is_socialv_user_likes($id, $key)
    {
        $user = wp_get_current_user();
        $user_id = $user->ID;

        if ($key == "_socialv_activity_liked_users") {
            $posts = bp_activity_get_meta($id, $key, true);
        } else {
            $posts = get_post_meta($id, $key, true);
        }
        $post_array = explode(', ', $posts);

        if (in_array($user_id, $post_array)) {
            return true;
        }

        return false;
    }

    function socialv_blog_total_user_likes($id, $key)
    {
        $post_array = '';

        if ($key == "_socialv_activity_liked_users") {
            $posts = bp_activity_get_meta($id, $key, true);
        } else {
            $posts = get_post_meta($id, $key, true);
        }
        if (!empty($posts)) {
            $post_array = explode(', ', $posts);
            return count($post_array);
        }

        return '';
    }

    function socialv_user_activity_callback()
    {
        $id = json_decode($_GET['id']); // Get the ajax call
        $meta_key = $_GET['meta_key'];
        $feedback = '';
        $user = wp_get_current_user();
        $user_id = $user->ID;
        if ($meta_key == "_socialv_user_pinned_activity") {
            $feedback = $this->socialv_set_user_pin($id, $meta_key, $user_id);
        } else {
            if ($this->socialv_set_user_likes($id, $meta_key, $user_id)) {
                $feedback = $this->socialv_blog_total_user_likes($id, $meta_key);
            }
        }
        wp_send_json_success($feedback);
        wp_die();
    }

    function socialv_set_user_pin($id, $meta_key, $user_id)
    {
        $currentvalue = get_user_meta($user_id, $meta_key, true);

        $post_array = explode(', ', $currentvalue);

        if (!in_array($id, $post_array)) {
            if (!empty($currentvalue)) {
                $newvalue = $currentvalue . ', ' . $id;
            } else {
                $newvalue = $id;
            }
            if (update_user_meta($user_id, $meta_key, $newvalue, $currentvalue)) {
                $feedback = array("has_activity" => $this->is_socialv_user_pin($id, $meta_key), "status" => true);
            }
        } else {
            $key = array_search($id, $post_array);
            unset($post_array[$key]);

            if (update_user_meta($user_id, $meta_key, implode(", ", $post_array), $currentvalue)) {
                $feedback = array("has_activity" => $this->is_socialv_user_pin($id, $meta_key), "status" => false);
            }
        }

        return $feedback;
    }

    function socialv_set_user_likes($activity_id, $meta_key, $user_id)
    {
        if ($meta_key == "_socialv_activity_liked_users") {
            $currentvalue = bp_activity_get_meta($activity_id, $meta_key, true);
        } else {
            $currentvalue = get_post_meta($activity_id, $meta_key, true);
        }

        $post_array = explode(', ', $currentvalue);

        if (!in_array($user_id, $post_array)) {
            if (!empty($currentvalue)) {
                $newvalue = $currentvalue . ', ' . $user_id;
            } else {
                $newvalue = $user_id;
            }

            if ($meta_key == "_socialv_activity_liked_users" && bp_activity_update_meta($activity_id, $meta_key, $newvalue, $currentvalue)) {

                $args = array("has_activity" => $this->is_socialv_user_likes($user_id, $meta_key), "status" => true);
            } else {
                if ($meta_key == "_socialv_posts_liked_users" && update_post_meta($activity_id, $meta_key, $newvalue, $currentvalue)) {
                    $args = array("has_activity" => $this->is_socialv_user_likes($activity_id, $meta_key), "status" => true);
                }
            }
        } else {
            $key = array_search($user_id, $post_array);
            unset($post_array[$key]);

            if ($meta_key == "_socialv_activity_liked_users" && bp_activity_update_meta($activity_id, $meta_key, implode(", ", $post_array), $currentvalue)) {
                $args = array("has_activity" => $this->is_socialv_user_likes($user_id, $meta_key), "status" => false);
            } else {
                if ($meta_key == "_socialv_posts_liked_users" && update_post_meta($activity_id, $meta_key, implode(", ", $post_array), $currentvalue)) {
                    $args = array("has_activity" => $this->is_socialv_user_likes($user_id, $meta_key), "status" => false);
                }
            }
        }
        // notify-user
        if ($meta_key == "_socialv_activity_liked_users") {
            $args["component_name"] = "socialv_activity_like_notification";
            $args["component_action"] = "action_activity_liked";
            $args['enable_notification_key'] = "notification_activity_new_like";
            CustomNotifications::socialv_add_user_notification($activity_id, $args);
        }
        return $args;
    }

    function socialv_unmark_activity_favorite()
    {
        if (!bp_is_post_request()) {
            return;
        }

        if (!isset($_POST['nonce'])) {
            return;
        }

        // Either the 'mark' or 'unmark' nonce is accepted, for backward compatibility.
        $nonce = wp_unslash($_POST['nonce']);
        if (!wp_verify_nonce($nonce, 'mark_favorite') && !wp_verify_nonce($nonce, 'unmark_favorite')) {
            return;
        }

        if (bp_activity_remove_user_favorite($_POST['id']))
            esc_html_e('Add Favorite', 'socialv');
        else
            esc_html_e('Remove Favorite', 'socialv');

        exit;
    }
    function socialv_activity_like_users($users = "")
    {
        if (!empty($users)) {
            $users = array_reverse(explode(', ', $users));

            $users = array_diff($users, self::socialv_get_blocked_block_by_list(bp_get_activity_user_id()));
            $users = array_values($users);
            $count_likes = count($users);

            if ($count_likes > 0) {
                $user_length =  $count_likes > 5 ? 4 : $count_likes - 1;
                ?>
                <div class="liked-member">
                    <ul class="member-thumb-group list-img-group">
                        <?php
                        for ($i = 0; $i <= $user_length; $i++) :
                            $profile_link = bp_core_get_user_domain($users[$i]);
                        ?>
                            <li>
                                <a href="<?php echo esc_url($profile_link); ?>">
                                    <?php bp_activity_avatar('user_id=' . $users[$i]); ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                    <span class="total-member"><?php echo esc_html__("Liked by ", "socialv"); ?>
                        <a href="<?php echo esc_url(bp_core_get_user_domain($users[0])); ?>">
                            <?php echo bp_core_get_user_displayname($users[0]); ?>
                        </a>
                        <?php if ($count_likes != 1) : ?>
                            <?php echo esc_html__(" And ", "socialv"); ?>
                            <a href="javascript:void(0);" class="socialv-get-liked-users" data-id="<?php echo esc_attr(bp_get_activity_id()); ?>">
                                <?php echo esc_html($count_likes - 1); ?>
                                <?php echo (esc_html($count_likes - 1) > 1) ? esc_html__(" Others", "socialv") : esc_html__(" Other", "socialv"); ?>
                            </a>
                        <?php endif; ?>
                    </span>
                </div>
        <?php }
        }
    }
    function get_users_activity_liked_modal()
    {
        ?>
        <!-- Modal -->
        <div class="modal fade" id="liked-users-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered friend-list-popup">
                <div class="modal-content card-main">
                    <div class="card-inner">
                        <div class="name-list">
                            <h5 class="m-0"><?php echo esc_html__("People Who like this post", "socialv"); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    function socialv_activity_liked_users()
    {
        $activity_id = json_decode($_GET['id']); // Get the ajax call
        $users_likes = bp_activity_get_meta($activity_id, "_socialv_activity_liked_users", true);
        if (!empty($users_likes)) {
            $blocked_users = self::socialv_get_blocked_block_by_list();
            $users = array_reverse(explode(', ', $users_likes));
            echo "<ul class='p-0 m-0'>";
            foreach ($users as $user_id) :
                if (in_array($user_id, $blocked_users)) continue;

                $user_data = get_userdata($user_id);
                $profile_link = bp_core_get_user_domain($user_id);
                $uname = "@" . $user_data->user_login;

        ?>
                <li>
                    <div class="user-who-liked">
                        <a href="<?php echo esc_url($profile_link); ?>">
                            <span class="mr-2"><?php bp_activity_avatar('class=rounded-circle&user_id=' . $user_id); ?></span>
                        </a>
                        <div class="like-details">
                            <a href="<?php echo esc_url($profile_link); ?>">
                                <h6 class="mb-1 mt-0">
                                    <?php echo bp_core_get_user_displayname($user_id); ?>
                                    <?php
                                    if (class_exists("BP_Verified_Member"))
                                        echo VerifiedMember::getInstance()->socialv_get_user_badge($user_id);
                                    ?>
                                </h6>
                                <p class="m-0"><?php echo esc_html($uname); ?></p>
                            </a>
                            <div class="liked">
                                <i class="iconly-Heart icbo"></i>
                            </div>
                        </div>

                    </div>
                </li>
        <?php
            endforeach;
            echo "</ul>";
        }
        die();
    }
    public function socialv_get_blocked_block_by_list($user_id = null)
    {

        if (!is_user_logged_in()) return [];

        $user_id = $user_id == null ? 69 : $user_id;

        $users = '';
        if (function_exists("imt_get_blocked_members_ids")) {
            $user_blocked = imt_get_blocked_members_ids($user_id);
            $users = !empty($user_blocked) ? implode(",", $user_blocked) : '';
        }
        if (function_exists("imt_get_blocked_members_ids")) {
            $user_block_by = imt_get_members_blocked_by_ids($user_id);
            $users .= !empty($user_block_by) ? "," . implode(",", $user_block_by) : '';
        }

        return !empty($users) ? explode(",", $users) : [];
    }


    /**
     * Buddypress_giphy_post_gif_html
     */
    public function socialv_buddypress_giphy_post_gif_html()
    {
        global $bp;
        $bpgp_settings = get_site_option('bpgp_settings');

        if (!isset($bpgp_settings['groups_gif_support']) && $bp->current_component == 'groups') {
            return;
        }

        if (!isset($bpgp_settings['profiles_gif_support']) && $bp->current_component == 'activity' && $bp->current_action == 'just-me') {
            return;
        }
        ?>

        <div class="post-elements-buttons-item bp-giphy-html-container mpp-upload-buttons socialv-upload-file">
            <div class="bp-giphy-media-search">
                <a class="bp-giphy-icon" title="<?php esc_attr_e('Choose a gif', 'socialv'); ?>"><label class="socialv-upload-btn-labels"><span class="upload-icon"><i class="wb-icons wb-icon-gif"></i></span><span><?php esc_html_e('Gif', 'socialv'); ?></span></label></a>
                <div class="bp-giphy-media-search-dropdown"></div>
            </div>
        </div>
    <?php
    }


    function socialv_blogs_activity_content_with_read_more($content, $activity)
    {
        if (('blogs' === $activity->component) && isset($activity->secondary_item_id) && 'new_blog_' . get_post_type($activity->secondary_item_id) === $activity->type) {
            $blog_post = get_post($activity->secondary_item_id);
            // If we converted content to an object earlier, flip it back to a string.
            $content = apply_filters('socialv_add_blog_post_as_activity_content_callback', '', $blog_post, $activity);
        }
        return $content;
    }



    function socialv_add_feature_image_blog_post_as_activity_content_callback($content, $blog_post_id)
    {
        if (!empty($blog_post_id) && !empty(get_post_thumbnail_id($blog_post_id))) {
            $content .= sprintf(' <a class="bb-post-img-link" href="%s"></a><div class="blog-post-image" style="background:url(%s)"><div class="blog-post-image-inner"><img src="%s" /></div></div>', esc_url(get_permalink($blog_post_id)), esc_url(wp_get_attachment_image_url(get_post_thumbnail_id($blog_post_id), 'full')), esc_url(wp_get_attachment_image_url(get_post_thumbnail_id($blog_post_id), 'full')));
        }

        return $content;
    }


    function socialv_add_blog_post_as_activity_content_callback($content, $blog_post, $activity)
    {
        if (is_a($blog_post, 'WP_Post')) {
            $content_img = '<div class="socialv-blog-box">' . apply_filters('socialv_add_feature_image_blog_post_as_activity_content', '', $blog_post->ID);
            $post_title  = sprintf('<h4 class="entry-title"><a class="socialv-post-title-link" href="%s"><span>%s</span></a></h4>', esc_url(get_permalink($blog_post->ID)), esc_html($blog_post->post_title));
            $content     = bp_create_excerpt(bp_strip_script_and_style_tags(html_entity_decode(get_the_excerpt($blog_post->ID))));
            if (false !== strrpos($content, __('&hellip;', 'socialv'))) {
                $content     = str_replace(' [&hellip;]', '&hellip;', $content);
                $content     = apply_filters_ref_array('bp_get_activity_content', array($content, $activity));
                preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $content, $matches);
                if (isset($matches) && array_key_exists(0, $matches) && !empty($matches[0])) {
                    $iframe  = $matches[0];
                    $content = strip_tags(preg_replace('/<iframe.*?\/iframe>/i', '', $content), '<a>');

                    $content .= $iframe;
                }
                $content = sprintf('%1$s <div class="socialv-blog-detail px-0 pb-0">%2$s %3$s', $content_img, $post_title, wpautop($content));
            } else {
                $content = apply_filters_ref_array('bp_get_activity_content', array($content, $activity));
                $content = strip_tags($content, '<a><iframe><img><span><div>');
                preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $content, $matches);
                if (isset($matches) && array_key_exists(0, $matches) && !empty($matches[0])) {
                    $content = $content;
                }
                $content = sprintf('%1$s <div class="socialv-blog-detail px-0 pb-0">%2$s %3$s', $content_img, $post_title, wpautop($content));
            }

            // Set view post button for activity post content.
            $activity_permalink = esc_url(get_permalink($blog_post->ID));
            $content      .= sprintf(
                '<div class="blog-button"><a href="%1$s" class="socialv-button socialv-button-link view-blog">%2$s</a></div>',
                $activity_permalink,
                esc_html__('View Post', 'socialv'),
            );
            $content .= '</div></div>';
        }
        return $content;
    }


    function socialv_activity_undo_post()
    {
        $activity_id = bp_get_activity_id(); ?>
        <div class="undo_activity_post" style="display: none">
            <div class="d-flex justify-content-between mb-3 gap-3">
                <div class="d-flex gap-3">
                    <i class="iconly-Close-Square icli fs-3 mt-1"></i>
                    <div class="wrp-main">
                        <?php echo '<h6>' . esc_html__("Post hidden", "socialv") . '</h6>';
                        echo '<p class=mt-1>' . esc_html__("You won't see this post in your Feed.", "socialv") . '</p>'; ?>
                    </div>
                </div>
                <span class="undo-btn mt-2"><a href="javascript:void(0)" data-type="undo" data-activity_id="<?php bp_activity_id();  ?>" data-id="<?php echo get_current_user_id(); ?>" class="hide-post-btn">
                        <?php esc_html_e("undo", "socialv"); ?>
                    </a></span>
            </div>
            <?php if (shortcode_exists("imt_report_button")) : ?>
                <div class="d-flex justify-content-between">
                    <div class="d-flex gap-3">
                        <i class="iconly-Info-Square icli fs-3 mt-1"></i>
                        <div class="wrp-main">
                            <?php
                            $name = esc_html__("Report Post", "socialv");
                            $content =  esc_html__("I'm concerned about this post.", "socialv");
                            echo do_shortcode("[imt_report_button id=$activity_id type=activity  name='<h6>$name</h6>' content='<p class=mt-1>$content</p>']"); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
<?php
    }
}

