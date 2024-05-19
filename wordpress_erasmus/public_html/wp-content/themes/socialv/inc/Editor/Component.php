<?php
/**
 * SocialV\Utility\Editor\Component class
 *
 * @package socialv
 */

namespace SocialV\Utility\Editor;

use SocialV\Utility\Component_Interface;
use function add_action;
use function add_theme_support;

/**
 * Class for integrating with the block editor.
 *
 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'editor';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', array( $this, 'action_add_editor_support' ) );
	}

	/**
	 * Adds support for various editor features.
	 */
	public function action_add_editor_support() {
		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add support for default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for wide-aligned images.
		add_theme_support( 'align-wide' );

		/**
		 * Add support for color palettes.
		 *
		 * To preserve color behavior across themes, use these naming conventions:
		 * - Use primary and secondary color for main variations.
		 * - Use `theme-[color-name]` naming standard for standard colors (red, blue, etc).
		 * - Use `custom-[color-name]` for non-standard colors.
		 *
		 * Add the line below to disable the custom color picker in the editor.
		 * add_theme_support( 'disable-custom-colors' );
		 */
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Primary', 'socialv' ),
					'slug'  => 'theme-primary',
					'color' => '#e36d60',
				),
				array(
					'name'  => esc_html__( 'Secondary', 'socialv' ),
					'slug'  => 'theme-secondary',
					'color' => '#41848f',
				),
				array(
					'name'  => esc_html__( 'Red', 'socialv' ),
					'slug'  => 'theme-red',
					'color' => '#C0392B',
				),
				array(
					'name'  => esc_html__( 'Green', 'socialv' ),
					'slug'  => 'theme-green',
					'color' => '#27AE60',
				),
				array(
					'name'  => esc_html__( 'Blue', 'socialv' ),
					'slug'  => 'theme-blue',
					'color' => '#2980B9',
				),
				array(
					'name'  => esc_html__( 'Yellow', 'socialv' ),
					'slug'  => 'theme-yellow',
					'color' => '#F1C40F',
				),
				array(
					'name'  => esc_html__( 'Black', 'socialv' ),
					'slug'  => 'theme-black',
					'color' => '#1C2833',
				),
				array(
					'name'  => esc_html__( 'Grey', 'socialv' ),
					'slug'  => 'theme-grey',
					'color' => '#95A5A6',
				),
				array(
					'name'  => esc_html__( 'White', 'socialv' ),
					'slug'  => 'theme-white',
					'color' => '#ECF0F1',
				),
				array(
					'name'  => esc_html__( 'Dusty daylight', 'socialv' ),
					'slug'  => 'custom-daylight',
					'color' => '#97c0b7',
				),
				array(
					'name'  => esc_html__( 'Dusty sun', 'socialv' ),
					'slug'  => 'custom-sun',
					'color' => '#eee9d1',
				),
			)
		);

		/*
		 * Add support custom font sizes.
		 *
		 * Add the line below to disable the custom color picker in the editor.
		 * add_theme_support( 'disable-custom-font-sizes' );
		 */
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => esc_html__( 'Small', 'socialv' ),
					'shortName' => esc_html__( 'S', 'socialv' ),
					'size'      => 16,
					'slug'      => 'small',
				),
				array(
					'name'      => esc_html__( 'Medium', 'socialv' ),
					'shortName' => esc_html__( 'M', 'socialv' ),
					'size'      => 25,
					'slug'      => 'medium',
				),
				array(
					'name'      => esc_html__( 'Large', 'socialv' ),
					'shortName' => esc_html__( 'L', 'socialv' ),
					'size'      => 31,
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html__( 'Larger', 'socialv' ),
					'shortName' => esc_html__( 'XL', 'socialv' ),
					'size'      => 39,
					'slug'      => 'larger',
				),
			)
		);
	}
}
