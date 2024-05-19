<?php
/**
 * SocialV\Utility\Editor\Component class
 *
 * @package socialv
 */

namespace SocialV\Utility\Dynamic_Style;

use SocialV\Utility\Component_Interface;
use SocialV\Utility\Dynamic_Style\Styles;

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
		return 'dynamic_style';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', array( $this, 'action_add_dynamic_styles' ) );
	}

	public function action_add_dynamic_styles( ) {
		new Styles\Layout();
		new Styles\Header();
		new Styles\HeaderSideArea();
		new Styles\Footer();
		new Styles\Breadcrumb();
		new Styles\Color();
		new Styles\General();
		new Styles\Loader();
		new Styles\Typography();
		new Styles\Logo();
		new Styles\AdditionalCode();
		if (class_exists('ReduxFramework') && function_exists('buddypress')) {
			new Styles\BuddyPress();
		}
	}

}
