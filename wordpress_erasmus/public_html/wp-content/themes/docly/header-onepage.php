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

/**
* Header Nav-bar Layout
 */
$header_type = function_exists('get_field') ? get_field('header_type' ) : '';
if ( is_404() || is_singular('post') || is_search() || $header_type == '' && !is_singular('docs') ) {
    $header_type = 'black';
}
if ( !isset($header_type) && is_singular('docs') || is_home() ) {
    $header_type = 'white';
}
if( class_exists('bbPress') ) {
    if ( is_post_type_archive( array('forum', 'topic') ) || is_singular('forum') || is_singular('topic') ) {
        $header_type = 'white';
    }
}

$page_header_layout = function_exists('get_field' ) ? get_field('header_layout' ) : '';
$is_sticky_header_doc = function_exists('get_field') ? get_Field('is_sticky_header') : '';
$is_sticky_body_wrapper = $is_sticky_header_doc == '1' ? 'sticky_menu' : '';

$sticky_header_id = $is_sticky_header_doc == '1' ? 'stickyTwo' : 'sticky' ;

$menu_display_none = is_singular('docs') ? 'display_none ' : '';

$nav_color = $header_type == 'black' ? ' dk_menu' : '';

/**
 * Nav container
 */
$nav_container = 'container-fluid pl-60 pr-60';

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset' ); ?>">
        <!-- For IE -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- For Resposive Device -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class('doc full-width-doc sticky-nav-doc onepage-doc'); ?> data-spy="scroll" data-target=".doc-nav" data-offset="120">
        <?php
        if ( function_exists('wp_body_open') ) {
            wp_body_open();
        }

        /**
         * Preloader
         */
        $is_preloader = $opt['is_preloader'] ?? '';
        if ( $is_preloader == '1' ) {
            get_template_part('template-parts/header-elements/preloader');
        }
        ?>

        <div class="body_wrapper">

            <nav class="navbar navbar-expand-lg menu_one <?php echo esc_attr($menu_display_none.$nav_color) ?>" id="sticky">
                <div class="<?php echo esc_attr($nav_container) ?>">
                    <?php Docly_helper()->logo(); ?>
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
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
                        get_template_part('template-parts/header-elements/search-form' );
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