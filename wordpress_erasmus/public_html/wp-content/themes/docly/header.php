<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package docly
 */

// Theme settings options
$opt = get_option('docly_opt' );
global $post;

/**
* Header Nav-bar Layout
 */
$header_type = function_exists('get_field') ? get_field('header_type' ) : '';
if ( is_404() || is_singular('post') || is_search() || $header_type == '' && !is_singular('docs') || is_archive() ) {
    $header_type = 'black';
}


if ( in_array('bbpress', get_body_class()) ) {
    $header_type = 'white';
    if ( in_array('bbp-user-page', get_body_class() ) ) {
        $header_type = 'black';
    }
}

if( class_exists('wooCommerce') ) {
    if ( is_shop() || is_singular('product') ) {
        $header_type = 'white';
    }
}

if ( !isset($header_type) && in_array('doc', get_body_class()) || is_home() ) {
    $header_type = 'white';
}


$page_header_layout = function_exists('get_field' ) ? get_field('header_layout' ) : '';
$is_sticky_header_doc = function_exists('get_field') ? get_Field('is_sticky_header') : '';
$is_sticky_body_wrapper = $is_sticky_header_doc == '1' ? 'sticky_menu' : '';

$sticky_header_id = $is_sticky_header_doc == '1' ? 'stickyTwo' : 'sticky' ;

$nav_container = Docly_helper()->doc_width() == 'full-width' ? 'container-fluid pl-60 pr-60' : 'container';

if ( is_singular('onepage-docs') ) {
    $nav_container = 'container-fluid pl-60 pr-60';
}

if ( in_array('doc', get_body_class()) ) {
    $nav_container = 'container custom_container';
}

$menu_display_none = is_singular('docs') ? 'display_none ' : '';
$nav_color = $header_type == 'black' ? ' dk_menu' : '';
$my_theme = wp_get_theme( 'docly' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset' ); ?>">
        <!-- For IE -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Theme Version -->
        <meta name="docly-version" content="<?php echo esc_attr($my_theme->Version) ?>">
        <!-- For Resposive Device -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <?php
        if ( function_exists('wp_body_open') ) {
            wp_body_open();
        }

        /**
         * Preloader
         */
        $is_preloader = $opt['is_preloader'] ?? '';
        $preloader_pages = !empty($opt['preloader_pages']) ? $opt['preloader_pages'] : 'all';
        if ( $is_preloader == '1' && $preloader_pages == 'all' ) {
            get_template_part('template-parts/header-elements/preloader');
        }

        $preloader_page_ids = !empty($opt['preloader_page_ids']) ? explode(',', $opt['preloader_page_ids']) : '';
        if ( $is_preloader == '1' && $preloader_pages == 'specific_pages' && !empty($preloader_page_ids) ) {
            if ( is_object( $post ) && in_array($post->ID, $preloader_page_ids) )
            get_template_part('template-parts/header-elements/preloader');
        }
        ?>

        <div class="click_capture"></div>

        <div class="body_wrapper <?php echo esc_attr($is_sticky_body_wrapper) ?>">

            <nav class="navbar navbar-expand-lg menu_one <?php echo esc_attr($menu_display_none.$nav_color) ?>" id="<?php echo esc_attr($sticky_header_id) ?>">
                <div class="<?php echo esc_attr($nav_container) ?>">
                    <?php Docly_helper()->logo(); ?>
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'docly'); ?>">
                        <span class="menu_toggle">
                            <span class="hamburger">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                            <span class="hamburger-cross">
                                <span></span>
                                <span></span>
                            </span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <?php
                        if ( has_nav_menu('main_menu') ) {
                            wp_nav_menu( array (
                                'menu' => 'main_menu',
                                'theme_location' => 'main_menu',
                                'container' => null,
                                'menu_class' => "navbar-nav menu ml-auto",
                                'walker' => new Docly_Nav_Walker(),
                                'depth' => 4
                            ));
                        }
                        get_template_part('template-parts/header-elements/action-button' );
                        ?>
                    </div>
                </div>
            </nav>

            <?php
            /**
             * Page Title-bar
             */
            get_template_part('template-parts/header-elements/titlebar');

            /**
             * Single post Titlebar
             */
            if ( is_singular('post') && !is_singular('docs') && !is_singular('forum') && !is_singular('topic') && !is_singular('product') ) {
                $is_search_banner = '';
                get_template_part('template-parts/header-elements/banner-single');
            }

            /**
             * Search banner area
             */
            $is_search_banner = function_exists('get_field') ? get_field('is_search_banner') : '';
            if ( is_home() || is_post_type_archive( array('forum', 'topic') ) || is_singular('docs') || is_singular('forum') || is_singular('topic') ) {
                $is_search_banner = '1';
            }

            if ( is_search() ) {
	            $is_search_banner = '';
            }

            if ( class_exists('bbPress') ) {
                if ( bbp_is_search_results() ) {
	                $is_search_banner = '1';
                }
            }

            if ( class_exists('wooCommerce') ) {
                if ( is_shop() || is_singular('product') ) {
	                $is_search_banner = '1';
                }
            }

            if ( $is_search_banner == '1' ) {
                get_template_part('template-parts/header-elements/search_banner');
            }

    echo is_singular('docs') ? '</div>' : '';