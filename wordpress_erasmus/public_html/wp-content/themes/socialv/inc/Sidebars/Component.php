<?php

/**
 * SocialV\Utility\Sidebars\Component class
 *
 * @package socialv
 */

namespace SocialV\Utility\Sidebars;

use SocialV\Utility\Component_Interface;
use SocialV\Utility\Templating_Component_Interface;
use function add_action;
use function add_filter;
use function register_sidebar;
use function is_active_sidebar;
use function dynamic_sidebar;

/**
 * Class for managing sidebars.
 *
 * Exposes template tags:
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/
 */
class Component implements Component_Interface, Templating_Component_Interface
{

	const PRIMARY_SIDEBAR_SLUG = 'sidebar-1';
	public $get_option = '';

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'sidebars';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		add_action('widgets_init', array($this, 'action_register_sidebars'));
		add_filter('body_class', array($this, 'filter_body_classes'));
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
			'is_primary_sidebar_active' => array($this, 'is_primary_sidebar_active'),
			'display_primary_sidebar' => array($this, 'display_primary_sidebar'),
			'post_style' => array($this, 'post_style'),
		);
	}

	/**
	 * Registers the sidebars.
	 */
	public function action_register_sidebars()
	{
		register_sidebar(
			array(
				'name' => esc_html__('Blog Sidebar', 'socialv'),
				'id' => static::PRIMARY_SIDEBAR_SLUG,
				'description' => esc_html__('Add widgets here.', 'socialv'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title' => '<h5 class="widget-title"> <span>  ',
				'after_title' => ' </span></h5>',
			)
		);

		if (function_exists('buddypress')) {
			register_sidebar(array(
				'name'          => esc_html__('Sidebar Area', 'socialv'),
				'class'         => 'nav-list',
				'id'            => 'sidebar_area',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title' => '<div class="menu-label">',
				'after_title' => '</div>',
			));
			register_sidebar(array(
				'name'          => esc_html__('Main Sidebar', 'socialv'),
				'class'         => 'nav-list',
				'id'            => 'buddypress_sidebar',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title' => '<h5 class="widget-title"> <span>  ',
				'after_title' => ' </span></h5>',
			));
			register_sidebar(array(
				'name'          => esc_html__('Group Sidebar', 'socialv'),
				'class'         => 'nav-list',
				'id'            => 'buddypress_group_sidebar',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title' => '<h5 class="widget-title"> <span>  ',
				'after_title' => ' </span></h5>',
			));
		}


		if (class_exists('WooCommerce')) {
			register_sidebar(array(
				'name'          => esc_html__('Product Sidebar', 'socialv'),
				'class'         => 'nav-list',
				'id'            => 'product_sidebar',
				'before_widget' => '<div class="sidebar_widget widget-woof %2$s">',
				'after_widget'  => '</div>',
				'before_title' => '<h5 class="widget-title"> <span>  ',
				'after_title' => ' </span></h5>',
			));
		}
	}

	/**
	 * Adds custom classes to indicate whether a sidebar is present to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 */
	public function filter_body_classes(array $classes): array
	{
		if ($this->is_primary_sidebar_active()) {
			global $template;

			if (!in_array(basename($template), array('front-page.php', 'FourZeroFour.php', 'offline.php'))) {
				$classes[] = 'has-sidebar';
			}
		}

		return $classes;
	}

	/**
	 * Checks whether the primary sidebar is active.
	 *
	 * @return bool True if the primary sidebar is active, false otherwise.
	 */
	public function is_primary_sidebar_active(): bool
	{
		$this->get_option =  get_option('socialv-options');

		if (class_exists('ReduxFramework') && $this->get_option != '') {
			if (is_search()) {
				$option = $this->get_option['search_page'];
			} else if (class_exists('BuddyPress') && is_buddypress() || class_exists('bbPress') &&  is_bbpress()) {
				$option = $this->get_option['bp_page'];
			} else if (class_exists('LearnPress') &&  is_archive('lp_course') || is_post_type_archive('lp_course') || is_tax('course_category')) {
				$option = $this->get_option['lp_page'];
			} else if (class_exists('WooCommerce') && (is_shop() || is_product_category() || is_product_tag())) {
				$option = $this->get_option['woocommerce_shop_grid'];
			}  else {
				$option = is_single() ? $this->get_option['blog_single_page_setting'] : $this->get_option['blog_setting'];
			}
			if (in_array($option, [4, 5])) {
				if (class_exists('BuddyPress') && is_buddypress() && !bp_is_group() || class_exists('bbPress') && is_bbpress()) {
					return (bool)is_active_sidebar('buddypress_sidebar');
				} else if (class_exists('BuddyPress') && class_exists('bbPress') && is_buddypress() && bp_is_group()) {
					return (bool)is_active_sidebar('buddypress_group_sidebar');
				} else if (class_exists('LearnPress') && is_archive('lp_course') || is_post_type_archive('lp_course') || is_tax('course_category')) {
					return (bool)is_active_sidebar('archive-courses-sidebar');
				} else if (class_exists('WooCommerce') && (is_shop() || is_product_category() || is_product_tag())) {
					return (bool)is_active_sidebar('product_sidebar');
				} else {
					return (bool)is_active_sidebar(static::PRIMARY_SIDEBAR_SLUG);
				}
			} else {
				return false;
			}
		}
		if (!class_exists('ReduxFramework') && class_exists('BuddyPress') && is_buddypress() || class_exists('bbPress') && is_bbpress() || class_exists('WooCommerce') && is_shop()) {
			return false;
		} else if (is_search()) {
			return false;
		} else {
			return (bool)is_active_sidebar(static::PRIMARY_SIDEBAR_SLUG);
		}
	}

	/**
	 * Displays the primary sidebar.
	 */
	public function display_primary_sidebar()
	{
		if (class_exists('BuddyPress') && is_buddypress() && !bp_is_group() || class_exists('bbPress') &&  is_bbpress()) {
			dynamic_sidebar('buddypress_sidebar');
		} else if (class_exists('BuddyPress') && is_buddypress() && bp_is_group()) {
			dynamic_sidebar('buddypress_group_sidebar');
		} else if (class_exists('LearnPress') && is_archive('lp_course') && is_post_type_archive('lp_course') || is_tax('course_category')) {
			dynamic_sidebar('archive-courses-sidebar');
		} else if (class_exists('WooCommerce') && (is_shop() || is_product_category() || is_product_tag())) {
			dynamic_sidebar('product_sidebar');
		} else {
			dynamic_sidebar(static::PRIMARY_SIDEBAR_SLUG);
		}
	}

	public function post_style(): array
	{
		$section['row_reverse'] = $option = '';
		$section['post'] = 'col-lg-12 col-sm-12 p-0';
		$socialv_options = get_option('socialv-options');

		if (class_exists('WooCommerce') && (is_shop() || is_product_category() || is_tax('product_cat'))) {
			if (isset($this->get_option['woocommerce_shop']) && $this->get_option['woocommerce_shop'] == '1') {
				$option = 'woocommerce_shop_list';
			} else {
				$option = 'woocommerce_shop_grid';
			}
		}

		if (is_search()) {
			$options = !empty($this->get_option['search_page']) ? $this->get_option['search_page'] : '';
		} else if (is_single()) {
			$options = !empty($this->get_option['blog_single_page_setting']) ? $this->get_option['blog_single_page_setting'] : '';
		} else if (class_exists('BuddyPress') && is_buddypress() || class_exists('bbPress') && is_bbpress()) {
			$options = !empty($this->get_option['bp_page']) ? $this->get_option['bp_page'] : '';
		} else if (class_exists('LearnPress') && (is_post_type_archive('lp_course') || is_tax('course_category'))) {
			$options = !empty($this->get_option['lp_page']) ? $this->get_option['lp_page'] : '';
		} else if (class_exists('WooCommerce') && (is_shop() || is_product_category() || is_tax('product_cat'))) {
			$options = !empty($socialv_options[$option]) ? $socialv_options[$option] : '';
		} else {
			$options = !empty($this->get_option['blog_setting']) ? $this->get_option['blog_setting'] : '';
		}
		switch ($options) {
			case 2:
				$section['post'] = 'col-lg-6 col-sm-12';
				break;
			case 3:
				if (class_exists('LearnPress') && is_post_type_archive('lp_course') || is_tax('course_category')) {
					$section['post'] = 'col-lg-3 col-sm-12';
				} else {
					$section['post'] = 'col-lg-4 col-sm-12';
				}
				break;
			case 5:
				$section['row_reverse'] = ' flex-row-reverse';
				break;
		}


		return $section;
	}

}
