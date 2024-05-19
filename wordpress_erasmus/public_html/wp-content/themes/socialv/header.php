<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package socialv
 */

namespace SocialV\Utility;

?>
<!doctype html>

<html class="layout-switch " <?php echo esc_attr(socialv()->socialv_layout_mode_add_attr()); ?> <?php language_attributes(); ?>>

<head>

  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="profile" href="<?php echo is_ssl() ? 'https:' : 'http:' ?>//gmpg.org/xfn/11">
  <?php if (!function_exists('has_site_icon') || !wp_site_icon()) { ?>
    <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/favicon.png'); ?>" />
  <?php } ?>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <?php get_template_part('template-parts/header/header'); ?>
  <?php socialv()->socialv_ajax_load_scripts(); ?>
  <?php get_template_part('template-parts/breadcrumb/breadcrumb');
 ?>