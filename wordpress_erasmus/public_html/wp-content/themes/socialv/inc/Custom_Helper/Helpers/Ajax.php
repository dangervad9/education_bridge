<?php

/**
 * SocialV\Utility\Custom_Helper\Helpers\Ajax class
 *
 * @package socialv
 */

namespace SocialV\Utility\Custom_Helper\Helpers;

use SocialV\Utility\Custom_Helper\Component;
use function SocialV\Utility\socialv;
use function add_action;

class Ajax extends Component
{
    public $socialv_option;
    public function __construct()
    {
        $this->socialv_option = get_option('socialv-options');
        //Search Member
        add_action('wp_ajax_ajax_search_member', [$this, 'socialv_ajax_search_member']);
        add_action('wp_ajax_nopriv_ajax_search_member', [$this, 'socialv_ajax_search_member']);

        //Search Group
        add_action('wp_ajax_ajax_search_group', [$this, 'socialv_ajax_search_group']);
        add_action('wp_ajax_nopriv_ajax_search_group', [$this, 'socialv_ajax_search_group']);

        //Search Post
        add_action('wp_ajax_ajax_search_post', [$this, 'socialv_ajax_search_post']);
        add_action('wp_ajax_nopriv_ajax_search_post', [$this, 'socialv_ajax_search_post']);

        // Activity Share - Post activity share
        add_action('wp_ajax_socialv_post_share_activity', array($this, 'socialv_post_share_activity'));
        add_action('wp_ajax_nopriv_socialv_post_share_activity', array($this, 'socialv_post_share_activity'));

        //Search Product
        if (class_exists('WooCommerce')) {
            add_action('wp_ajax_ajax_search_product', [$this, 'socialv_ajax_search_product']);
            add_action('wp_ajax_nopriv_ajax_search_product', [$this, 'socialv_ajax_search_product']);
        }
        if (class_exists('LearnPress')) {
            add_action('wp_ajax_ajax_search_course', [$this, 'socialv_ajax_search_course']);
            add_action('wp_ajax_nopriv_ajax_search_course', [$this, 'socialv_ajax_search_course']);
        }
        // set the hide post option in activity page.
        if (isset($this->socialv_option['is_socialv_enable_hide_post']) && $this->socialv_option['is_socialv_enable_hide_post'] == '1') {
            add_action('wp_ajax_hide_activity_post', [$this, 'socialv_hide_activity_post']);
            add_action('wp_ajax_nopriv_hide_activity_post', [$this, 'socialv_hide_activity_post']);
        }
    }

    // AJAX || Post an Activity Share
    public function socialv_post_share_activity()
    {
        if (!is_user_logged_in()) {
            return;
        }
        global $wpdb;
        $table = $wpdb->base_prefix . 'bp_activity';
        $shared_activity_id = $_POST['activity_id'];
        $activity = $wpdb->get_results("SELECT user_id, primary_link FROM {$table} where id={$shared_activity_id}");
        $activity_user_id = $activity[0]->user_id;
        $current_user_id = get_current_user_id();
        if ($activity_user_id == $current_user_id) {
            $action = '<a href="' . bp_core_get_user_domain($activity_user_id) . '">' . get_the_author_meta('display_name', $activity_user_id) . '</a>' . esc_html__(' shared his post', 'socialv');
        } else {
            $action = '<a href="' . bp_core_get_user_domain($current_user_id) . '">' . get_the_author_meta('display_name', $current_user_id) . '</a> ' . sprintf(esc_html__('shared %s post', 'socialv'), '<a href="' . bp_core_get_user_domain($activity_user_id) . '">' . get_the_author_meta('display_name', $activity_user_id) . '</a>');
        }

        $wpdb->insert(
            $table,
            array(
                'user_id'       => $current_user_id,
                'component'     => 'activity',
                'type'          => 'activity_share',
                'action'        => $action,
                'content'       => '',
                'primary_link'  => $activity[0]->primary_link,
                'date_recorded' => current_time('mysql')
            ),
            array(
                '%d', '%s', '%s', '%s', '%s', '%s', '%s'
            )
        );
        $activity_id = $wpdb->insert_id;

        bp_activity_update_meta($activity_id, 'shared_activity_id', $shared_activity_id);

        if ($activity_id) {
            $res = true;
            do_action("socialv_activity_shared", $activity_id, $shared_activity_id, $current_user_id);
        } else {
            $res = false;
        }

        wp_send_json($res, 200);
    }

    public function socialv_ajax_search_member()
    {
        $search_text = isset($_POST['keyword']) ? sanitize_text_field($_POST['keyword']) : '';
        $data = '';
        if (bp_has_members(array(
            'per_page' => $this->socialv_option['header_search_limit'] ? $this->socialv_option['header_search_limit'] : 5,
            'search_terms'    => $search_text,
            'search_columns'  => array('name'),
        ))) :
            while (bp_members()) : bp_the_member();
                $user_id = bp_get_member_user_id();
                $data .= '<li>
				<div class="socialv-author-heading">
                    <div class="item-avatar">
                        <a href="' . bp_get_member_permalink() . '">' . bp_get_member_avatar('type=thumb&width=50&height=50') . '</a>
                    </div>
                    <div class="item">
                        <h6 class="item-title fn">
                        	<a href="' . bp_get_member_permalink() . '">' . bp_get_member_name() . '</a>'
                    . socialv()->socialv_get_verified_badge($user_id) . '
                        </h6>
                        <div class="item-meta">' . bp_get_member_last_active() . '</div>
                    </div>
                </div>
				</li>';
            endwhile;
        else :
            $data .= '<li class="no-result">' . esc_html__('No Member Found', 'socialv') . '</li>';
        endif;
        wp_send_json_success($data);
    }

    public function socialv_ajax_search_group()
    {
        $value = isset($_POST['keyword']) ? sanitize_text_field($_POST['keyword']) : '';
        $data = '';
        if (bp_has_groups(array(
            'per_page' => $this->socialv_option['header_search_limit'] ? $this->socialv_option['header_search_limit'] : 5,
            'search_terms'    => $value,
            'type' => "alphabetical",
            'search_columns'  => array('name'),
        ))) :

            while (bp_groups()) : bp_the_group();

                $data .= '<li>
				<div class="socialv-author-heading">
                    <div class="item-avatar">
                        <a href="' . bp_get_group_permalink() . '">' . bp_core_fetch_avatar(array('item_id'    => bp_get_group_id(), 'avatar_dir' => 'group-avatars', 'object'     => 'group', 'width'      => 50, 'height'     => 50, 'class' => 'rounded-circle')) . '</a>
                    </div>
                    <div class="item">
                        <h6 class="item-title fn">' . bp_get_group_link() . '</h6>
                        <div class="item-meta">' . bp_get_group_type() . '</div>
                    </div>
                </div>
				</li>';
            endwhile;
        else :
            $data .= '<li class="no-result">' . esc_html__('No Group Found', 'socialv') . '</li>';
        endif;
        wp_send_json_success($data);
    }

    public function socialv_ajax_search_post()
    {
        $value = isset($_POST['keyword']) ? sanitize_text_field($_POST['keyword']) : '';
        $data = $image_url = '';
        $args = array(
            'posts_per_page' => $this->socialv_option['header_search_limit'] ? $this->socialv_option['header_search_limit'] : 5,
            's' => $value,
            'post_type' => 'post'
        );
        query_posts($args);
        if (have_posts()) :
            while (have_posts()) : the_post();
                if (has_post_thumbnail()) :
                    $image_url  = '<div class="item-avatar"><a href="' . get_the_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), array('thumbnail', '50', ' rounded avatar-50')) . '</a></div>';
                endif;
                $data .= '<li>
				<div class="socialv-author-heading">' . $image_url . '
                    <div class="item">
                        <h6 class="item-title fn">
                        	<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>
                        </h6>
                        <div class="item-meta">' . get_the_date() . '</div>
                    </div>
                </div>
				</li>';
            endwhile;
            wp_reset_postdata();
        else :
            $data .= '<li class="no-result">' . esc_html__('No Post Found', 'socialv') . '</li>';
        endif;
        wp_send_json_success($data);
    }

    public function socialv_ajax_search_product()
    {
        $value = isset($_POST['keyword']) ? sanitize_text_field($_POST['keyword']) : '';
        $data = $image_url = '';
        $args = array(
            'posts_per_page' => $this->socialv_option['header_search_limit'] ? $this->socialv_option['header_search_limit'] : 5,
            's' => $value,
            'post_type' => 'product'
        );
        query_posts($args);
        if (have_posts()) :
            while (have_posts()) : the_post();
                global $product;
                if ($product->get_image_id()) :
                    $product->get_image('shop_catalog');
                    $image = wp_get_attachment_image_src($product->get_image_id(), "thumbnail");
                    $image_url  = '<div class="item-avatar"><a href="' . get_the_permalink($product->get_id()) . '"><img src="' . esc_url($image[0]) . '" alt="' . esc_attr('Image', 'socialv') . '" class="avatar rounded avatar-50 photo" loading="lazy"/></a></div>';
                else :
                    $image_url  = '<div class="item-avatar"><a href="' . get_the_permalink($product->get_id()) . '"><img src="' . esc_url(wc_placeholder_img_src()) . '" alt="' . esc_attr__('Awaiting product image', 'socialv') . '" class="avatar rounded avatar-50 photo" loading="lazy"/></a></div>';
                endif;
                $data .= '<li>
				<div class="socialv-author-heading">' . $image_url . '
                    <div class="item">
                        <h6 class="item-title fn">
                        	<a href="' . get_the_permalink($product->get_id()) . '">' . esc_html($product->get_name()) . '</a>
                        </h6>
                        <div class="item-meta">' . wp_kses($product->get_price_html(), 'socialv') . '</div>
                    </div>
                </div>
				</li>';
            endwhile;
            wp_reset_postdata();
        else :
            $data .= '<li class="no-result">' . esc_html__('No Product Found', 'socialv') . '</li>';
        endif;
        wp_send_json_success($data);
    }


    public function socialv_ajax_search_course()
    {
        $value = isset($_POST['keyword']) ? sanitize_text_field($_POST['keyword']) : '';
        $data = $image_url = '';
        $args = array(
            'posts_per_page' => $this->socialv_option['header_search_limit'] ? $this->socialv_option['header_search_limit'] : 5,
            's' => $value,
            'post_type' => 'lp_course',
            'fields'         => 'ids'
        );
        query_posts($args);
        if (have_posts()) :
            while (have_posts()) : the_post();
                $course = learn_press_get_course(get_the_ID());
                $image_url =    wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail');
                if (!empty($image_url[0])) {
                    $image_url = $image_url[0];
                } else {
                    $image_url = LP()->image('no-image.png');
                }
                $data .= '<li>
				<div class="socialv-author-heading">
                <div class="item-avatar"><a href="' . esc_url(get_permalink(get_the_ID())) . '"><img src="' . esc_url($image_url) . '" alt="' . esc_attr('Image', 'socialv') . '" class="avatar rounded avatar-50 photo" loading="lazy" /></a></div>
                    <div class="item">
                        <h6 class="item-title fn">
                        	<a href="' . get_the_permalink(get_the_ID()) . '">' . esc_html(get_the_title(get_the_ID())) . '</a>
                        </h6>
                        <div class="item-meta">' . wp_kses_post($course->get_course_price_html()) . '</div>
                    </div>
                </div>
				</li>';
            endwhile;
            wp_reset_postdata();
        else :
            $data .= '<li class="no-result">' . esc_html__('No Course Found', 'socialv') . '</li>';
        endif;
        wp_send_json_success($data);
    }

    public function socialv_hide_activity_post()
    {
        $user = wp_get_current_user();
        $user_id = $user->ID;
        $meta_key = "_socialv_activity_hiden_by_user";
        $data = '';
        if (!isset($_POST["activity_id"])) {
            esc_html_e("Id not present", "socialv");
            wp_die();
        }
        $activity_id = $_POST["activity_id"];
        $hidden_activities = get_user_meta($user_id, $meta_key, true);
        if ($_POST['data_type'] == 'hide') {
            if ($hidden_activities) {
                if (in_array($activity_id, $hidden_activities)) {
                    $unset_id = array_search($activity_id, $hidden_activities);
                    unset($hidden_activities[$unset_id]);
                    if (update_user_meta($user_id, $meta_key, array_values($hidden_activities))) {
                        $data .=  esc_html__("Post is now visible", "socialv");
                    }
                } else {
                    $hidden_activities[] = $activity_id;
                    if (update_user_meta($user_id, $meta_key, $hidden_activities)) {
                        $data .=  esc_html__("Post is now hidden", "socialv");
                    }
                }
            } else {
                $hidden_activities = [];
                $hidden_activities[] = $activity_id;
                if (update_user_meta($user_id, $meta_key, $hidden_activities)) {
                    $data .= esc_html__("Post is now hidden", "socialv");
                }
            }
        } else if ($_POST['data_type'] == 'undo') {
            if ($hidden_activities && in_array($activity_id, $hidden_activities)) {
                $unset_id = array_search($activity_id, $hidden_activities);
                unset($hidden_activities[$unset_id]);
                if (update_user_meta($user_id, $meta_key, array_values($hidden_activities))) {
                    $data .= esc_html__("Post is now visible", "socialv");
                }
            } else {
                $data .= esc_html__("Post was not hidden", "socialv");
            }
        }
        wp_send_json_success($data);
        wp_die();
    }
}
