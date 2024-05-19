<?php

/**
 * SocialV\Utility\Base_Support\Component class
 *
 * @package socialv
 */

namespace SocialV\Utility\Base_Support;

use SocialV\Utility\Component_Interface;
use SocialV\Utility\Templating_Component_Interface;
use function add_action;
use function add_filter;
use function add_theme_support;
use function is_singular;
use function pings_open;
use function get_bloginfo;
use function wp_scripts;
use function wp_get_theme;
use function get_template;

/**
 * Class for adding basic theme support, most of which is mandatory to be implemented by all themes.
 *
 * Exposes template tags:
 * * `socialv()->get_version()`
 * * `socialv()->get_asset_version( string $filepath )`
 */
class Component implements Component_Interface, Templating_Component_Interface
{

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'base_support';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		add_action('after_setup_theme', array($this, 'action_essential_theme_support'));
		add_action('wp_head', array($this, 'action_add_pingback_header'));
		add_filter('body_class', array($this, 'filter_body_classes_add_hfeed'));
		add_filter('embed_defaults', array($this, 'filter_embed_dimensions'));
		add_filter('theme_scandir_exclusions', array($this, 'filter_scandir_exclusions_for_optional_templates'));
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `socialv()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags(): array
	{
		return array(
			'get_version'       => array($this, 'get_version'),
			'get_asset_version' => array($this, 'get_asset_version'),
		);
	}

	/**
	 * Adds theme support for essential features.
	 */
	public function action_essential_theme_support()
	{
		$socialv_options = get_option('socialv-options');

		// Add default RSS feed links to head.
		add_theme_support('automatic-feed-links');

		// Ensure WordPress manages the document title.
		add_theme_support('title-tag');

		// Ensure WordPress theme features render in HTML5 markup.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Add support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		// Add support for responsive embedded content.
		add_theme_support('responsive-embeds');

		add_theme_support('admin-bar', array('callback' => '__return_false'));

		if (function_exists('buddypress')) {
			if (class_exists('ReduxFramework') && !empty($socialv_options['socialv_default_avatar']['url'])) {
				define('BP_AVATAR_DEFAULT', $socialv_options['socialv_default_avatar']['url']);
			} else {
				if (!defined('BP_AVATAR_DEFAULT')) {
					define('BP_AVATAR_DEFAULT', get_template_directory_uri() . '/assets/images/redux/default-avatar.jpg');
				}
			}

			if (class_exists('ReduxFramework') && !empty($socialv_options['socialv_default_cover_image']['url'])) {
				define('SOCIALV_DEFAULT_COVER_IMAGE', $socialv_options['socialv_default_cover_image']['url']);
			} else {
				define('SOCIALV_DEFAULT_COVER_IMAGE', get_template_directory_uri() . '/assets/images/redux/default-cover.jpg');
			}

			define('BP_AVATAR_THUMB_WIDTH', 50);
			define('BP_AVATAR_THUMB_HEIGHT', 50);
		}
	}

	/**
	 * Adds a pingback url auto-discovery header for singularly identifiable articles.
	 */
	public function action_add_pingback_header()
	{
		if (is_singular() && pings_open()) {
			echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
		}
	}

	/**
	 * Adds a 'hfeed' class to the array of body classes for non-singular pages.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 */
	public function filter_body_classes_add_hfeed(array $classes): array
	{
		if (!is_singular()) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}

	/**
	 * Sets the embed width in pixels, based on the theme's design and stylesheet.
	 *
	 * @param array $dimensions An array of embed width and height values in pixels (in that order).
	 * @return array Filtered dimensions array.
	 */
	public function filter_embed_dimensions(array $dimensions): array
	{
		$dimensions['width'] = 720;
		return $dimensions;
	}

	/**
	 * Excludes any directory named 'optional' from being scanned for theme template files.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/theme_scandir_exclusions/
	 *
	 * @param array $exclusions the default directories to exclude.
	 * @return array Filtered exclusions.
	 */
	public function filter_scandir_exclusions_for_optional_templates(array $exclusions): array
	{
		return array_merge(
			$exclusions,
			array('optional')
		);
	}

	/**
	 * Gets the theme version.
	 *
	 * @return string Theme version number.
	 */
	public function get_version(): string
	{
		static $theme_version = null;

		$get_theme = wp_get_theme();
		$get_theme_version = $get_theme->get('Version');

		if ($get_theme_version) {
			$theme_version = $get_theme_version;
		} else {
			$theme_version = '1.0.0';
		}

		return $theme_version;
	}

	/**
	 * Gets the version for a given asset.
	 *
	 * Returns filemtime when WP_DEBUG is true, otherwise the theme version.
	 *
	 * @param string $filepath Asset file path.
	 * @return string Asset version number.
	 */
	public function get_asset_version(string $filepath): string
	{

		return $this->get_version();
	}
}
