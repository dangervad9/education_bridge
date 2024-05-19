<?php

/**
 * Template part for displaying the header
 *
 * @package socialv
 */

namespace SocialV\Utility;

use SocialV\Utility\Dynamic_Style\Styles\Header;

$socialv_options = get_option('socialv-options');
$bgurl = $site_classes = '';
if (class_exists('ReduxFramework')) {
    //theme site class
    $site_classes .= 'socialv';
    //loader
    if (isset($socialv_options['display_loader']) && $socialv_options['display_loader'] === 'yes') {
        if (!empty($socialv_options['loader_gif']['url'])) {
            $bgurl = $socialv_options['loader_gif']['url'];
        }
    }
}
?>
<?php if (!empty($bgurl)) { ?>
    <div id="loading">
        <div id="loading-center">
            <img src="<?php echo esc_url($bgurl); ?>" alt="<?php esc_attr_e('loader', 'socialv'); ?>" loading="lazy">
        </div>
    </div>
<?php } ?>
<!-- loading End -->
<?php
$is_default_header = $is_header = true;
$header_name = '';
$display_sidebar = (class_exists('ReduxFramework') && $socialv_options['header_display_side_area'] == 'yes') ? true : false;

if (function_exists("get_field")) {
    $header = new Header();
    $is_header = $header->is_socialv_header();
}
if (function_exists('get_field') && class_exists('ReduxFramework')) {
    $is_default_header = socialv()->is_socialv_default_header();
}
?>
<div id="page" class="site <?php echo esc_attr(trim($site_classes));
                            echo esc_attr((!$is_default_header) ? ' header-verticle' :  ''); ?>">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'socialv'); ?></a>
    <?php
    if ($display_sidebar == true && $is_default_header == false) {
        get_template_part('template-parts/header/sidearea');
    }
    ?>
    <div class="main-content">
        <?php if ($is_header) {
            if (!$is_default_header) {
                get_template_part('template-parts/header/verticle-header');
            } else {
                $is_default_header = true;
            }

            if ($is_default_header) {
                get_template_part('template-parts/header/navigation');
            }

            if (socialv()->is_primary_nav_menu_active()) { ?>
                <div class="socialv-mobile-menu menu-style-one">
                    <?php get_template_part('template-parts/header/navigation', 'mobile'); ?>
                </div>
        <?php }
        } ?>