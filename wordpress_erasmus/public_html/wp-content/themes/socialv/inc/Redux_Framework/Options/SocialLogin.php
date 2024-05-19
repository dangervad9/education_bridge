<?php
/**
 * SocialV\Utility\Redux_Framework\Options\SocialLogin class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;
use Redux;
use SocialV\Utility\Redux_Framework\Component;

class SocialLogin extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section( $this->opt_name, array(
			'title'            => esc_html__( 'Social Login', 'socialv' ),
			'id'               => 'social_login_icons',
            'has_group_title' => __("Features", "socialv"),
			'icon'             => 'custom-login',
			'fields'           => array(
				array(
					'id'        => 'social_login_shortcode_text',
					'type'      => 'text',
					'title'     => esc_html__( 'Shortcode','socialv'),
					'validate' 	=> 'text',
					'default'	=> '[miniorange_social_login shape="round" theme="default" space="4" size="35"]',
					'subtitle'  => wp_kses( __( 'Put you Social Login for Shortcode here','socialv' ), array( 'br' => array() ) ),
				),
			),
		) );
	}
}
