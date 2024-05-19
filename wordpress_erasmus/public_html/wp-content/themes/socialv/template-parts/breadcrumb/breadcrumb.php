<?php

/**
 * Template part for displaying the Breadcrumb 
 *
 * @package socialv
 */

namespace SocialV\Utility;

use SocialV\Utility\Dynamic_Style\Styles\BuddyPress;
use SocialV\Utility\Dynamic_Style\Styles\Breadcrumb;

$is_breadcrumb = true;
$bp_banner = false;
if (is_front_page()) {
    if (is_home()) {
?>
        <div class="socialv-breadcrumb text-center">
            <div class="container-fluid">
                <div class="row flex-row-reverse">
                    <div class="col-sm-12">
                        <div class="socialv-breadcrumb-box">
                            <div class="heading-title white socialv-breadcrumb-title">
                                <h1 class="title mt-0">
                                    <?php esc_html_e('Home', 'socialv'); ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
} else {
   
   
    if (class_exists("Redux")) {
        $breadcrumb = new Breadcrumb();
        $is_breadcrumb = (class_exists('WooCommerce') && is_product() || class_exists('LearnPress') && (is_post_type_archive( 'lp_course' ) || is_tax( 'course_category' ) || is_tax( 'course_tag' ) || is_singular('lp_course') || is_singular('sfwd-courses') || is_singular('sfwd-lessons') || is_singular('sfwd-topic') || is_singular('sfwd-quiz') || is_singular('courses') || is_singular('lesson'))) ? false : $breadcrumb->is_socialv_breadcrumb();
    }
    if (class_exists('BuddyPress')) {
        if ((is_buddypress() || class_exists('bbPress') &&  is_bbpress() ||  function_exists('GamiPress') && (is_post_type_archive(gamipress_get_achievement_types_slugs()) || is_post_type_archive(gamipress_get_rank_types_slugs()))))
            $is_breadcrumb = false;
    }
    if (class_exists('BuddyPress')) {
        $socialv_options = get_option('socialv-options');
        $current_page = get_queried_object_id();
        $register = (!empty($socialv_options['site_register_link'])) ? $socialv_options['site_register_link'] : '';
        $login = (!empty($socialv_options['site_login_link'])) ? $socialv_options['site_login_link'] : '';
        if (bp_is_members_directory() || bp_is_groups_directory() || class_exists('bbPress') && is_bbpress() && !bp_is_user() && !bp_is_group() && !bp_is_register_page() && !is_page($register) && !is_page($login) || function_exists('GamiPress') && (is_post_type_archive(gamipress_get_achievement_types_slugs()) || is_post_type_archive(gamipress_get_rank_types_slugs()))) {
            $bpbanner = new BuddyPress();
            $bp_banner = $bpbanner->is_socialv_banner();
        }
    }
    if ($is_breadcrumb) socialv()->socialv_breadcrumb();
    if ($bp_banner) socialv()->socialv_bp_banner($title, $subtitle = '');
}
?>