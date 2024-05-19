<?php

/**
 * SocialV\Utility\Editor\Component class
 *
 * @package socialv
 */

namespace SocialV\Utility\TGM;

use SocialV\Utility\Component_Interface;
use function add_action;

/**
 * Class for integrating with the block editor.
 *
 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
 */
class Component implements Component_Interface
{

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'tgm';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		add_action('tgmpa_register', array($this, 'socialv_sp_register_required_plugins'));
	}

	/**
	 * Register the required plugins for this theme.
	 *
	 * The variable passed to tgmpa_register_plugins() should be an array of plugin
	 * arrays.
	 *
	 * This function is hooked into tgmpa_init, which is fired within the
	 * TGM_Plugin_Activation class constructor.
	 */
	function socialv_sp_register_required_plugins()
	{

		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
			array(
				'name'      => esc_html__('Advanced Custom Fields', 'socialv'),
				'slug'      => 'advanced-custom-fields',
				'required'  => true
			),
			array(
				'name'      => esc_html__('Elementor', 'socialv'),
				'slug'      => 'elementor',
				'required'  => true
			),
			array(
				'name'      => esc_html__('BuddyPress', 'socialv'),
				'slug'      => 'buddypress',
				'required'  => true
			),
			array(
				'name'      => esc_html__('bbPress', 'socialv'),
				'slug'      => 'bbpress',
				'required'  => true
			),
			array(
				'name'      => esc_html__('GamiPress', 'socialv'),
				'slug'      => 'gamipress',
				'required'  => true
			),
			array(
				'name'      => esc_html__('MediaPress', 'socialv'),
				'slug'      => 'mediapress',
				'required'  => true
			),
			array(
				'name'      => esc_html__('Verified Member for BuddyPress', 'socialv'),
				'slug'      => 'bp-verified-member',
				'required'  => true
			),
			array(
				'name'      => esc_html__('Contact Form 7', 'socialv'),
				'slug'      => 'contact-form-7',
				'required'  => true
			),
			array(
				'name'      => esc_html__('MC4WP: Mailchimp for WordPress', 'socialv'),
				'slug'      => 'mailchimp-for-wp',
				'required'  => true
			),
			array(
				'name'      => esc_html__('LearnPress – WordPress LMS Plugin', 'socialv'),
				'slug'      => 'learnpress',
				'required'  => true
			),
			array(
				'name'      => esc_html__('LearnPress - Course Review', 'socialv'),
				'slug'      => 'learnpress-course-review',
				'required'  => true
			),
			array(
				'name'      => esc_html__('Better Messages – Live Chat for WordPress, BuddyPress, BuddyBoss, Ultimate Member, PeepSo', 'socialv'),
				'slug'      => 'bp-better-messages',
				'required'  => true
			),
			array(
				'name'      => esc_html__('WooCommerce', 'socialv'),
				'slug'      => 'woocommerce',
				'required'  => true
			),
			array(
				'name'      => esc_html__('WPC Smart Quick View for WooCommerce', 'socialv'),
				'slug'      => 'woo-smart-quick-view',
				'required'  => true
			),
			array(
				'name'      => esc_html__('WOOF - Products Filter for WooCommerce', 'socialv'),
				'slug'      => 'woocommerce-products-filter',
				'required'  => true
			),
			array(
				'name'      => esc_html__('YITH WooCommerce Wishlist', 'socialv'),
				'slug'      => 'yith-woocommerce-wishlist',
				'required'  => true
			),
			array(
				'name'      => esc_html__('Paid Memberships Pro', 'socialv'),
				'slug'      => 'paid-memberships-pro',
				'required'  => true
			),
			array(
				'name'      => esc_html__('Social Login, Social Sharing by miniOrange', 'socialv'),
				'slug'      => 'miniorange-login-openid',
				'required'  => true
			),
			array(
				'name'      => esc_html__('WC4BP', 'socialv'),
				'slug'      => 'wc4bp',
				'required'  => true
			),
			array(
				'name'      => esc_html__('One Click Demo Import', 'socialv'),
				'slug'      => 'one-click-demo-import',
				'required'  => true
			),
			array(
				'name'       => esc_html__('Iqonic Extensions', 'socialv'),
				'slug'       => 'iqonic-extensions',
				'source'     => esc_url('http://assets.iqonic.design/wp/plugins/socialv/iqonic-extensions.zip'),
				'required'   => true,
			),
			array(
				'name'       => esc_html__('Iqonic Moderation Tool', 'socialv'),
				'slug'       => 'iqonic-moderation-tool',
				'source'     => esc_url('http://assets.iqonic.design/wp/plugins/iqonic-moderation-tool.zip'),
				'required'   => true,
			),
			array(
				'name'       => esc_html__('Iqonic Reactions', 'socialv'),
				'slug'       => 'iqonic-reactions',
				'source'     => esc_url('http://assets.iqonic.design/wp/plugins/socialv/iqonic-reactions.zip'),
				'required'   => true,
			),
			array(
				'name'       => esc_html__('WP Story Premium', 'socialv'),
				'slug'       => 'wp-story-premium',
				'source'     => esc_url('https://assets.iqonic.design/wp/plugins/wp-story-premium.zip'),
				'required'   => true,
			),
			array(
				'name'      => esc_html__('GamiPress - BuddyPress integration', 'socialv'),
				'slug'      => 'gamipress-buddypress-integration',
				'source'     => esc_url('http://assets.iqonic.design/wp/plugins/socialv/gamipress-buddypress-integration.zip'),
				'required'   => true,
			)
		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);
		if (is_plugin_active('iqonic-extensions/iqonic-extension.php') && defined('IQONIC_EXTENSION_VERSION') && IQONIC_EXTENSION_VERSION >= '1.8.2') {
			Socialv_tgmpa($plugins, $config);
		} else {
			tgmpa($plugins, $config);
		}
	}
}
