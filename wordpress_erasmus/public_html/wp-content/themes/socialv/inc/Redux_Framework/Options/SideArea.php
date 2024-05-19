<?php

/**
 * SocialV\Utility\Redux_Framework\Options\General class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class SideArea extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{

        Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Side Area', 'socialv'),
			'desc' => esc_html__('This section contains options for side area button in header.', 'socialv'),
			'id'    => 'header-side-area-variation',
			'icon'  => 'custom-view_sidebar',
			'fields' => array(

				array(
					'id'    => 'info_custom_header_sidearea_options',
					'type'  => 'info',
					'required' 	=> array('header_layout', '=', '1'),
					'title' => esc_html__('Note:', 'socialv'),
					'style' => 'warning',
					'desc'  => esc_html__('This options only works with Second Header Style', 'socialv')
				),

				array(
					'id'        => 'header_display_side_area',
					'type'      => 'button_set',
					'title'     => esc_html__('Side Area (Sliding Panel)', 'socialv'),
					'subtitle' => esc_html__('Set option for Sliding right side panel.', 'socialv'),
					'options'   => array(
						'yes' => esc_html__('On', 'socialv'),
						'no' => esc_html__('Off', 'socialv')
					),
					'default'   => esc_html__('yes', 'socialv'),
					'required' 	=> array('header_layout', '=', '2'),
				),

				// --------side area background options start----------//
				array(
					'id'        => 'sidearea_background_type',
					'type'      => 'button_set',
					'required'  => array('header_display_side_area', '=', 'yes'),
					'title'     => esc_html__('Background', 'socialv'),
					'subtitle'  => esc_html__('Select the variation for Sidearea background', 'socialv'),
					'options'   => array(
						'default' => esc_html__('Default', 'socialv'),
						'color' => esc_html__('Color', 'socialv'),
						'image' => esc_html__('Image', 'socialv'),
						'transparent' => esc_html__('Transparent', 'socialv')
					),
					'default'   => esc_html__('default', 'socialv')
				),

				array(
					'id'            => 'sidearea_background_color',
					'type'          => 'color',
					'desc'     => esc_html__('Set Background Color', 'socialv'),
					'required'  => array('sidearea_background_type', '=', 'color'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'       => 'sidearea_background_image',
					'type'     => 'media',
					'url'      => false,
					'desc'     => esc_html__('Upload Image', 'socialv'),
					'required'  => array('sidearea_background_type', '=', 'image'),
					'read-only' => false,
					'subtitle' => esc_html__('Upload background image for sidearea.', 'socialv'),
				),
				// --------side area Background options end----------//
				array(
					'id' => 'sidearea_width',
					'type' => 'dimensions',
					'height' => false,
					'units'    => array('em', 'px', '%'),
					'title' => esc_html__('Adjust sidearea width', 'socialv'),
					'subtitle' => esc_html__('Choose Width, and/or unit.', 'socialv'),
					'desc' => esc_html__('Sidearea Width.', 'socialv'),
					'required'  => array('header_display_side_area', '=', 'yes'),
				),


			)
		));
	}
}
