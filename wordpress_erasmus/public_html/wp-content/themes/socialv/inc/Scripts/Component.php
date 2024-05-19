<?php

/**
 * SocialV\Utility\Scripts\Component class
 *
 * @package socialv
 */

namespace SocialV\Utility\Scripts;

use SocialV\Utility\Component_Interface;
use SocialV\Utility\Templating_Component_Interface;
use function SocialV\Utility\socialv;
use function add_action;
use function wp_enqueue_script;
use function get_theme_file_uri;
use function get_theme_file_path;

class Component implements Component_Interface
{

	/**
	 * Associative array of CSS files, as $handle => $data pairs.
	 * $data must be an array with keys 'file' (file path relative to 'assets/css' directory), and optionally 'global'
	 * (whether the file should immediately be enqueued instead of just being registered) and 'preload_callback'
	 * (callback function determining whether the file should be preloaded for the current request).
	 *
	 * Do not access this property directly, instead use the `get_css_files()` method.
	 *
	 * @var array
	 */
	protected $js_files;

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'scripts';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		add_action('wp_enqueue_scripts', array($this, 'action_enqueue_scripts'));
	}

	/**
	 * Registers or enqueues stylesheets.
	 *
	 * Stylesheets that are global are enqueued. All other stylesheets are only registered, to be enqueued later.
	 */
	public function action_enqueue_scripts()
	{
		$js_uri = get_template_directory_uri() . '/assets/js/';
		$js_dir = get_template_directory() . '/assets/js/';
		$js_files = $this->get_js_files();
		if (class_exists('WooCommerce')) {
			$woo_prod_js = array(
				'socialv-woocomerce-product-dependency' => array(
					'file'   => 'woocommerce.min.js',
					'dependency' => array('jquery'),
					'in_footer' => true,
				),
			);
			$js_files =  array_merge($js_files, $woo_prod_js);
			// Execute Ajax End
		}
		if (class_exists( 'PMPro_Membership_Level' )) {
			$pmp_files = array(
				'socialv-pmpro'     => array(
					'file'   => 'socialv-pmpro.min.js',
					'dependency' => array('jquery'),
					'in_footer' => true,
				),
			);
			$js_files =  array_merge($js_files, $pmp_files);
		}
		wp_enqueue_script('underscore');
		foreach ($js_files as $handle => $data) {
			$src     = $js_uri . $data['file'];
			$version = socialv()->get_asset_version($js_dir . $data['file']);

			wp_enqueue_script($handle, $src, $data['dependency'], $version, $data['in_footer']);
		}

		// Js Varibale
		$global_localize_values = array(
			'alert_media' 	=> esc_html__('Are you sure you want to delete?', 'socialv'),
			'reset_setting' => esc_html__('Are you sure you want to reset your settings?', 'socialv'),
		);
		$global_localize_vars = apply_filters("socialv_global_script_vars",$global_localize_values);
		wp_register_script('socialv_custom_global_script', false);
		wp_localize_script(
			'socialv_custom_global_script',
			'socialv_global_script',
			$global_localize_vars
		);
		wp_enqueue_script('socialv_custom_global_script');
	}

	/**
	 * Gets all JS files.
	 *
	 * @return array Associative array of $handle => $data pairs.
	 */
	protected function get_js_files(): array
	{
		if (is_array($this->js_files)) {
			return $this->js_files;
		}

		$js_files = array(
			'popper2'     => array(
				'file'   => 'vendor/popper.min.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
			'bootstrap-js'     => array(
				'file'   => 'vendor/bootstrap.min.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
			'superfish'     => array(
				'file'   => 'vendor/superfish.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
			'select2'     => array(
				'file'   => 'vendor/select2.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
			'smooth-scrollbar'     => array(
				'file'   => 'vendor/smooth-scrollbar.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
			'swiper-slider'     => array(
				'file'   => 'vendor/swiper.min.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
			'socialv-custom'     => array(
				'file'   => 'custom.min.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
			'socialv-custom-activity'     => array(
				'file'   => 'custom-activity.min.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
			'socialv-ajax-custom'     => array(
				'file'   => 'ajax-custom.min.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
		);
		$this->js_files = array();
		foreach ($js_files as $handle => $data) {
			if (is_string($data)) {
				$data = array('file' => $data);
			}

			if (empty($data['file'])) {
				continue;
			}

			$this->js_files[$handle] = array_merge(
				array(
					'global'           => false,
					'preload_callback' => null,
					'media'            => 'all',
				),
				$data
			);
		}

		return $this->js_files;
	}
}
