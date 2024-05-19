<?php
/**
 * SocialV\Utility\Jetpack\Component class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class AdditionalCode extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section( $this->opt_name, array(
			'title' => esc_html__( 'Additional Code', 'socialv' ),
			'id'    => 'additional-Code',
			'icon'  => 'custom-Code',
			'desc'  => esc_html__('This section contains options for header.','socialv'),
			'has_group_title' => __("Extra", "socialv"),
			'fields'=> array(

				array(
					'id'       => 'css_code',
					'type'     => 'ace_editor',
					'title'    => esc_html__('CSS Code','socialv'),
					'mode'     => 'css',
					'subtitle'     => esc_html__('Paste your custom CSS code here.','socialv'),
				),

				array(
					'id'       => 'js_code',
					'type'     => 'ace_editor',
					'title'    => esc_html__('JS Code','socialv'),
					'mode'     => 'javascript',
					'theme'   => 'chrome',
					'subtitle'     => esc_html__('Paste your custom JS code here.','socialv'),
				),
			)
		));
	}
}
