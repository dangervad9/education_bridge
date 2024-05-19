<?php

/**
 * SocialV\Utility\Redux_Framework\Options\General class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class General extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Body Layout', 'socialv'),
			'desc' => esc_html__('This section contains body container related options.', 'socialv'),
			'id'    => 'body_layout',
			'icon' => 'custom-General',
			'fields' => array(

				array(
					'id'        =>  'grid_container',
					'type'      =>  'dimensions',
					'units'     =>  array('em', 'px', '%'),
					'height'    =>  false,
					'width'     =>  true,
					'title'     =>  esc_html__('Container Width', 'socialv'),
					'subtitle'      =>  esc_html__('Adjust Your Site Container Width With Help Of Above Option.', 'socialv'),
					'height_label'  =>  'Height',
					'width_label'   =>  'Width',
					'units_label'   => 'Choose option',
					'default'   =>  array(
						'width'   => '84.433',
						'units' => 'em'
					),
				),

				array(
					'id' => 'body_back_option',
					'type' => 'button_set',
					'title' => esc_html__('Body Background', 'socialv'),
					'subtitle' => esc_html__('Select this option for body background.', 'socialv'),
					'options' => array(
						'2' => 'Default',
						'1' => 'Color',
						'3' => 'Image'
					),
					'default' => '2'
				),

				array(
					'id' => 'body_color',
					'type' => 'color',
					'title' => esc_html__('background color', 'socialv'),
					'subtitle' => esc_html__('Choose body background color', 'socialv'),
					'required' => array('body_back_option', '=', '1'),
					'default' => '',
					'mode' => 'background',
					"class"	=> "socialv-sub-fields",
					'transparent' => false
				),

				array(
					'id' => 'body_image',
					'type' => 'media',
					'url' => false,
					'read-only' => false,
					'required' => array('body_back_option', '=', '3'),
					'title' => esc_html__('background image.', 'socialv'),
					'subtitle' => esc_html__('Choose body background image.', 'socialv'),
					"class"	=> "socialv-sub-fields",
				),

				array(
					'id' => 'is_page_spacing',
					'type' => 'button_set',
					'title' => esc_html__('Page Spacing', 'socialv'),
					'subtitle'  =>  esc_html__('Adjust top / bottom spacing of your site pages.', 'socialv'),
					'options' => array(
						'default' => 'Default',
						'custom' => 'Custom',
					),
					'default' => 'default'
				),

				// page top spacing
				array(
					'id' => 'page_spacing',
					'type' => 'spacing',
					'mode' => 'absolute',
					'units' => array('em', 'px', '%'),
					'all' => false,
					'top' => true,
					'right' => false,
					'bottom' => true,
					'left' => false,
					'default' => array(
						'top' => '5',
						'bottom' => '5',
						'units' => 'em'
					),
					'top_label'  =>  'Top',
					'bottom_label'   =>  'Button',
					'right_label'  =>  'Right',
					'left_label'   =>  'Left',
					'units_label'   => 'Choose option',
					'title'     =>  esc_html__('Top / Bottom Spacing', 'socialv'),
					'subtitle'     =>  esc_html__('Choose Top / Bottom spacing', 'socialv'),
					"class"	=> "socialv-sub-fields",
					'required' 	=> array('is_page_spacing', '=', 'custom'),
				),
				array(
					'id' => 'tablet_page_spacing',
					'type' => 'spacing',
					'mode' => 'absolute',
					'units' => array('em', 'px', '%'),
					'all' => false,
					'top' => true,
					'right' => false,
					'bottom' => true,
					'left' => false,
					'default' => array(
						'top' => '2',
						'bottom' => '2',
						'units' => 'em'
					),
					'top_label'  =>  'Top',
					'bottom_label'   =>  'Button',
					'right_label'  =>  'Right',
					'left_label'   =>  'Left',
					'units_label'   => 'Choose option',
					'title'     =>  esc_html__('Top / Bottom Spacing for Tablet', 'socialv'),
					'subtitle'     =>  esc_html__('Choose Top / Bottom spacing', 'socialv'),
					"class"	=> "socialv-sub-fields",
					'required' 	=> array('is_page_spacing', '=', 'custom'),
				),
				array(
					'id' => 'mobile_page_spacing',
					'type' => 'spacing',
					'mode' => 'absolute',
					'units' => array('em', 'px', '%'),
					'all' => false,
					'top' => true,
					'right' => false,
					'bottom' => true,
					'left' => false,
					'default' => array(
						'top' => '1',
						'bottom' => '1',
						'units' => 'em'
					),
					'top_label'  =>  'Top',
					'bottom_label'   =>  'Button',
					'right_label'  =>  'Right',
					'left_label'   =>  'Left',
					'units_label'   => 'Choose option',
					'title'     =>  esc_html__('Top / Bottom Spacing for Mobile', 'socialv'),
					'subtitle'     =>  esc_html__('Choose Top / Bottom spacing', 'socialv'),
					"class"	=> "socialv-sub-fields",
					'required' 	=> array('is_page_spacing', '=', 'custom'),
				),
				
				array(
					'id' => 'back_to_top_btn',
					'type' => 'button_set',
					'title' => esc_html__('Display back to top button', 'socialv'),
					'options' => array(
						'yes' => esc_html__('Yes', 'socialv'),
						'no' => esc_html__('No', 'socialv')
					),
					'default' => esc_html__('yes', 'socialv')
				),
			)
		));
	}
}
