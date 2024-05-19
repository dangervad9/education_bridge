<?php

/**
 * SocialV\Utility\Redux_Framework\Options\Logo class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class Logo extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Branding', 'socialv'),
			'desc' => esc_html__('This section contains options for logo', 'socialv'),
			'has_group_title' => __("Design System", "socialv"),
			'id'    => 'header-logo',
			'icon'  => 'custom-Branding',
			'fields' => array(

				array(
					'id'       => 'verticle_header_text',
					'type'     => 'text',
					'title' =>  esc_html__('Logo Text', 'socialv'),
					'msg'      => esc_html__('Please enter correct value', 'socialv'),
					'default'  => esc_html__('SocialV', 'socialv'),
				),

				array(
					'id'            => 'verticle_header_color',
					'type'          => 'color',
					'desc'      => esc_html__('Choose text color', 'socialv'),
					'default'       => '',
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'       => 'socialv_logo_options',
					'type' 		=> 'button_set',
					'options' 	=> array(
						'light' 		=> esc_html__('Light', 'socialv'),
						'dark' 		=> esc_html__('Dark', 'socialv')
					),
					'default'	=> 'light',
					'title'    => esc_html__('Logo', 'socialv'),
					'subtitle' => esc_html__('Upload Logo image for your Website.', 'socialv'),
				),



				array(
					'id'       => 'socialv_verticle_logo',
					'type'     => 'media',
					'url'      => false,
					'required'  => array(
						array('socialv_logo_options', '=', 'light')
					),
					'read-only' => false,
					'default'  => array('url' => get_template_directory_uri() . '/assets/images/logo-mini.svg'),
				),


				array(
					'id'       => 'socialv_verticle_dark_logo',
					'type'     => 'media',
					'url'      => false,
					'required'  => array(
						array('socialv_logo_options', '=', 'dark')
					),
					'read-only' => false,
					'default'  => array('url' => get_template_directory_uri() . '/assets/images/logo-mini.svg'),
				),

				array(
					'id' => 'logo_position',
					'type'     => 'button_set',
					'title' => esc_html__('Logo Left Side ?', 'socialv'),
					'options' => array(
						'yes' => 'Yes',
						'no' => 'No',
					),
					'default' => 'yes',
				),

				array(
                    'id'        => 'display_full_logo',
                    'type'      => 'checkbox',
                    'title'     => esc_html__('Enable Full Logo?', 'socialv'),
					'default'   => '0',
                ),

				array(
					'id'             => 'logo-dimensions',
					'type'           => 'dimensions',
					'units'          => array('em', 'px', '%'),    // You can specify a unit value. Possible: px, em, %
					'units_extended' => 'true',  // Allow users to select any type of unit
					'title'          => esc_html__('Logo (Width/Height) Option', 'socialv'),
					'subtitle'           => esc_html__('You can enable or disable any piece of this field. Width, Height, or Units.', 'socialv'),
					'height_label'  =>  'Height',
					'width_label'   =>  'Width',
					'units_label'   => 'Choose option',
				),


			)
		));
	}
}
