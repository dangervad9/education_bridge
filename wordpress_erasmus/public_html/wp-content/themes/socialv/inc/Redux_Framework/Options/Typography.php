<?php
/**
 * SocialV\Utility\Redux_Framework\Options\Styles class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;
use Redux;
use SocialV\Utility\Redux_Framework\Component;

class Typography extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Typography', 'socialv'),
			'id' => 'default_style',
			'icon' => 'custom-Typography',
			'desc' => esc_html__('This section contains typography related options.', 'socialv'),
			'fields' => array(

				array(
					'id' => 'change_font',
					'type' => 'switch',
					'title' => esc_html__('Do you want to change fonts?', 'socialv'),
					'default' => esc_html__('0', 'socialv'),
					'0' => esc_html__('Yes', 'socialv'),
					'1' => esc_html__('No', 'socialv')
				),

				array(
					'id'        => 'body_font',
					'type'      => 'typography',
					'title'     => esc_html__( 'Body Font','socialv' ),
					'subtitle'  => esc_html__( 'Select the font.','socialv' ),
					'required'  => array( 'change_font', '=', '1' ),
					'google'    => true,
					'font-style'    => true,
					'font-backup'   => true,
					'font-weight'   => true,
					'font-size'     => true,
					'line-height'   => false,
					'color'         => false,
					'text-align'    => false,
					'default'       => array(
						'font-family' => esc_html__( 'Plus Jakarta Sans','socialv' ),
						'google'      => true
					)
			),
	
			array(
				'id'        => 'h1_font',
				'type'      => 'typography',
				'title'     => esc_html__( 'H1 Font','socialv' ),
				'subtitle'  => esc_html__( 'Select the font.','socialv' ),
				'required'  => array( 'change_font', '=', '1' ),
				'google'    => true,
				'font-style'    => true,
				'font-weight'   => true,
				'font-size'     => true,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'default'       => array(
					'font-family' => esc_html__( 'Plus Jakarta Sans','socialv' ),
					'google'      => true
				)
			),
	
			array(
				'id'        => 'h2_font',
				'type'      => 'typography',
				'title'     => esc_html__( 'H2 Font','socialv' ),
				'subtitle'  => esc_html__( 'Select the font.','socialv' ),
				'required'  => array( 'change_font', '=', '1' ),
				'google'    => true,
				'font-style'    => true,
				'font-weight'   => true,
				'font-size'     => true,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'default'       => array(
					'font-family' => esc_html__( 'Plus Jakarta Sans','socialv' ),
					'google'      => true
				)
			),
	
			array(
				'id'        => 'h3_font',
				'type'      => 'typography',
				'title'     => esc_html__( 'H3 Font','socialv' ),
				'subtitle'  => esc_html__( 'Select the font.','socialv' ),
				'required'  => array( 'change_font', '=', '1' ),
				'google'    => true,
				'font-style'    => true,
				'font-weight'   => true,
				'font-size'     => true,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'default'       => array(
					'font-family' => esc_html__( 'Plus Jakarta Sans','socialv' ),
					'google'      => true
				)
			),
			array(
				'id'        => 'h4_font',
				'type'      => 'typography',
				'title'     => esc_html__( 'H4 Font','socialv' ),
				'subtitle'  => esc_html__( 'Select the font.','socialv' ),
				'required'  => array( 'change_font', '=', '1' ),
				'google'    => true,
				'font-style'    => true,
				'font-weight'   => true,
				'font-size'     => true,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'default'       => array(
					'font-family' => esc_html__( 'Plus Jakarta Sans','socialv' ),
					'google'      => true
				)
			),
			array(
				'id'        => 'h5_font',
				'type'      => 'typography',
				'title'     => esc_html__( 'H5 Font','socialv' ),
				'subtitle'  => esc_html__( 'Select the font.','socialv' ),
				'required'  => array( 'change_font', '=', '1' ),
				'google'    => true,
				'font-style'    => true,
				'font-weight'   => true,
				'font-size'     => true,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'default'       => array(
					'font-family' => esc_html__( 'Plus Jakarta Sans','socialv' ),
					'google'      => true
				)
			),
			array(
				'id'        => 'h6_font',
				'type'      => 'typography',
				'title'     => esc_html__( 'H6 Font','socialv' ),
				'subtitle'  => esc_html__( 'Select the font.','socialv' ),
				'required'  => array( 'change_font', '=', '1' ),
				'google'    => true,
				'font-style'    => true,
				'font-weight'   => true,
				'font-size'     => true,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'default'       => array(
					'font-family' => esc_html__( 'Plus Jakarta Sans','socialv' ),
					'google'      => true
				)
			),
			)
		));
	}
}
