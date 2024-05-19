<?php

/**
 * Template part for displaying the Sidearea
 *
 * @package socialv
 */

use SocialV\Utility\Dynamic_Style\Styles\Header;
use SocialV\Utility\Nav_Walker;

use function SocialV\Utility\socialv;

$socialv_options = get_option('socialv-options');
$display_bottom_sidebar = (has_nav_menu('side_menu')) ? true : false;

$is_header = true;
if (function_exists("get_field")) {
    $header = new Header();
    $is_header = $header->is_socialv_header();
}
$class  = wp_is_mobile() ? "sidebar-mini" : "";
if ($is_header) {
?>
    <!-- side area btn container start-->
    <div id="sidebar-scrollbar" class="sidebar sidebar-default navs-rounded-all <?php echo esc_attr($class); ?>" data-toggle="main-sidebar" data-sidebar="responsive">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <!--Logo start-->
            <?php socialv()->socialv_logo(); ?>
            <!--logo End-->
        </div>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <span class="menu-btn d-inline-block is-active">
                <i class="iconly-Arrow-Left-2 icli"></i>
            </span>
        </div>
        <div class="sidebar-body data-scrollbar">
            <div class="sidebar-list">
                <?php if ( is_active_sidebar( 'sidebar_area' ) ) { ?>
                    <?php dynamic_sidebar('sidebar_area'); ?>
                <?php } ?>
            </div>
        </div>
        <!--  Sidebar Botttom  -->
        <?php
        if (is_user_logged_in()) :
            if ($display_bottom_sidebar == true) :
                echo '<div class="sidebar-footer custom-nav-slider"><div class="socialv-horizontal-main-box">';
                $theme_locations = get_nav_menu_locations();
                $menu_obj = get_term($theme_locations['side_menu'], 'nav_menu');
                if ($menu_obj->count > 4) : ?>
                    <div class="left" onclick="navslide('left',event)"><i class="iconly-Arrow-Left-2 icli"></i></div>
                    <div class="right" onclick="navslide('right',event)"><i class="iconly-Arrow-Right-2 icli"></i></div>
        <?php endif;
                wp_nav_menu(
                    array(
                        'theme_location' => 'side_menu',
                        'menu_id'        => 'menu-side-setting-menu',
                        'fallback_cb'    => '',
                        'container'      => false,
                        'menu_class'     => 'navbar-nav iq-main-menu socialv-horizontal-container',
                        'walker' => new Nav_Walker\Component(),
                    )
                );
                echo '</div></div>';
            endif;
        endif;
        ?>
    </div>
    <!-- side area btn container end-->
<?php } ?>