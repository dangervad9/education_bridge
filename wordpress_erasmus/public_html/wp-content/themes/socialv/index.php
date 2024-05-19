<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package socialv
 */

namespace SocialV\Utility;

get_header();

$socialv_options = get_option('socialv-options');
$post_section = socialv()->post_style();

$container_class = apply_filters('content_container_class', 'container');
$row_reverse_class = esc_attr($post_section['row_reverse']);

echo '<div class="site-content-contain">';
echo '<div id="content" class="site-content">';
echo '<div id="primary" class="content-area">';
echo '<main id="main" class="site-main">';
echo '<div class="' . $container_class . '">';
echo '<div class="row ' . $row_reverse_class . '">';

socialv()->socialv_the_layout_class();

if ((function_exists('GamiPress') && function_exists('gamipress_get_achievement_types_slugs') && !empty(gamipress_get_achievement_types_slugs()) && is_post_type_archive(gamipress_get_achievement_types_slugs())) || (function_exists('gamipress_get_rank_types_slugs') && !empty(gamipress_get_rank_types_slugs()) && is_post_type_archive(gamipress_get_rank_types_slugs()))) {
    echo '<div class="card-main"><div class="card-inner">';
    $type = is_post_type_archive(gamipress_get_achievement_types_slugs()) ? 'entry_badge' : 'entry_levels';
    if (have_posts()) {
        echo '<div class="row">';
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/content/' . $type,  $post_section['post']);
        }
        echo '</div>';
    } else {
        get_template_part('template-parts/content/error');
    }
    echo '</div></div>';
} else {
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/content/entry', get_post_type(), $post_section['post']);
        }

        if (!is_singular() && (!isset($socialv_options['display_pagination']) || $socialv_options['display_pagination'] == "yes")) {
            get_template_part('template-parts/content/pagination');
        }
    } else {
        get_template_part('template-parts/content/error');
    }
}

wp_reset_postdata();
socialv()->socialv_sidebar();

echo '</div>';
echo '</div>';
echo '</main><!-- #primary -->';
echo '</div>';
echo '</div>';
echo '</div>';

get_footer();