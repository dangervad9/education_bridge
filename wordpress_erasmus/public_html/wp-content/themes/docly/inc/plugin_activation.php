<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

$purchase_code_status = trim( get_option( 'docly_purchase_code_status' ) );

/**
 * Include the TGM_Plugin_Activation class.
 */
require get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

if ( $purchase_code_status == 'valid' ) {
	add_action('tgmpa_register', 'docly_register_required_plugins');
}

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function docly_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
        array(
            'name'          => esc_html__( 'Elementor', 'docly' ),
            'slug'          => 'elementor',
            'required'      => true,
        ),

        array(
            'name'          => esc_html__( 'Docly Core', 'docly' ), // The plugin name.
            'slug'          => 'docly-core', // The plugin slug (typically the folder name).
            'source'        => 'https://wordpress-theme.spider-themes.net/resources/docly/docly-core.zip', // The plugin source.
            'required'      => true, // If false, the plugin is only 'recommended' instead of required.
            'version'       => '2.0.1'
        ),

        array(
            'name'          => esc_html__( 'Advanced Custom Fields-pro', 'docly' ), // The plugin name.
            'slug'          => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
            'source'        => 'https://wordpress-theme.spider-themes.net/3rd-plugins/advanced-custom-fields-pro.zip', // The plugin source.
            'required'      => true, // If false, the plugin is only 'recommended' instead of required.
        ),

		array(
			'name'          => esc_html__( 'Redux Framework', 'docly' ),
			'slug'          => 'redux-framework',
			'required'      => true,
		),

        array(
            'name'          => esc_html__( 'EazyDocs', 'docly' ),
            'slug'          => 'eazydocs',
            'required'      => true,
        ),

		array(
			'name'          => esc_html__( 'bbPress', 'docly' ),
			'slug'          => 'bbpress',
			'required'      => false,
		),

		array(
			'name'          => esc_html__( 'wooCommerce', 'docly' ),
			'slug'          => 'woocommerce',
			'required'      => false,
		),

        array(
            'name'          => esc_html__( 'Contact Form 7', 'docly' ),
            'slug'          => 'contact-form-7',
            'required'      => false,
        ),

        array(
            'name'          => esc_html__( 'One Click Demo Import', 'docly' ),
            'slug'          => 'one-click-demo-import',
            'required'      => false,
        ),
		
		array(
			'name'          => esc_html__( 'BBP Core', 'docy' ),
            'slug'          => 'bbp-core',
            'required'      => true,
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

	tgmpa( $plugins, $config );
}