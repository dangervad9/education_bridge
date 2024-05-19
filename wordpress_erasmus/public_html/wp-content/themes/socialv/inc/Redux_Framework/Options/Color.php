<?php

/**
 * SocialV\Utility\Redux_Framework\Options\Color class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class Color extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Global colors', 'socialv'),
			'id'    => 'color',
			'icon'  => 'custom-Colors',
			'desc'  => esc_html__('Change default colors of the site.', 'socialv'),
			'fields' => array(
				array(
					'id'      => 'custom_color_switch',
					'type'    => 'button_set',
					'title'   => esc_html__('Set custom colors', 'socialv'),
					'options' => array(
						'yes' 	=> 'Yes',
						'no' 	=> 'No',
					),
					'default' => 'no'
				),

				// Button Color Start
				array(
					'id'            => 'primary_color',
					'type'          => 'info',
					'style' => 'warning',
					'title'         => esc_html__('Primary color', 'socialv'),
					'desc'      	=> __('To change the primary color, use the Live Style Customizer on the front end. Follow this step: <a href="https://youtu.be/1EF_Y6UOWsQ" target="_blank">https://youtu.be/1EF_Y6UOWsQ</a>', 'socialv'),
					'required' 	=> array('custom_color_switch', '=', 'yes'),
				),
				
				array(
					'id'            => 'success_color',
					'type'          => 'color',
					'title'         => esc_html__('Success color', 'socialv'),
					'subtitle'      	=> esc_html__('Select success color.', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					"class"	=> "socialv-sub-fields",
					'required' 	=> array('custom_color_switch', '=', 'yes'),
				),
				array(
					'id'            => 'danger_color',
					'type'          => 'color',
					'title'         => esc_html__('Danger color', 'socialv'),
					'subtitle'      	=> esc_html__('Select danger color.', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					"class"	=> "socialv-sub-fields",
					'required' 	=> array('custom_color_switch', '=', 'yes'),
				),
				array(
					'id'            => 'warning_color',
					'type'          => 'color',
					'title'         => esc_html__('Warning color', 'socialv'),
					'subtitle'      	=> esc_html__('Select warning color.', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					"class"	=> "socialv-sub-fields",
					'required' 	=> array('custom_color_switch', '=', 'yes'),
				),
				array(
					'id'            => 'info_color',
					'type'          => 'color',
					'title'         => esc_html__('Info color', 'socialv'),
					'subtitle'      	=> esc_html__('Select info color.', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					"class"	=> "socialv-sub-fields",
					'required' 	=> array('custom_color_switch', '=', 'yes'),
				),
				array(
					'id'            => 'orange_color',
					'type'          => 'color',
					'title'         => esc_html__('Orange color', 'socialv'),
					'subtitle'      	=> esc_html__('Select orange color.', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					"class"	=> "socialv-sub-fields",
					'required' 	=> array('custom_color_switch', '=', 'yes'),
				),
				// Button color End

				array(
					'id'       	=> 'custom_switch_mode',
					'type'     	=> 'switch',
					'on'		=> esc_html__('Light Mode', 'socialv'),
					'off'		=> esc_html__('Dark Mode', 'socialv'),
					'default'   => '1',
					'required' 	=> array('custom_color_switch', '=', 'yes'),
				),
				
				//Light mode
				array(
					'id'            => 'title_color',
					'type'          => 'color',
					'title'         => esc_html__('Title Color', 'socialv'),
					'subtitle'      => esc_html__('Select default Title(Headings) color', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array(
						array('custom_color_switch', '=', 'yes'),
						array('custom_switch_mode', '=', '1'),
					),
					"class"	=> "socialv-sub-fields"
				),

				array(
					'id'            => 'text_color',
					'type'          => 'color',
					'title'         => esc_html__('Body text color', 'socialv'),
					'subtitle'      	=> esc_html__('Select default body text color', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array(
						array('custom_color_switch', '=', 'yes'),
						array('custom_switch_mode', '=', '1'),
					),
					"class"	=> "socialv-sub-fields"
				),

				array(
					'id'            => 'parent_bg_color',
					'type'          => 'color',
					'title'         => esc_html__('Body Parent Box color', 'socialv'),
					'subtitle'      	=> esc_html__('Select default body body parent box color', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array(
						array('custom_color_switch', '=', 'yes'),
						array('custom_switch_mode', '=', '1'),
					),
					"class"	=> "socialv-sub-fields"
				),

				array(
					'id'            => 'child_bg_color',
					'type'          => 'color',
					'title'         => esc_html__('Body Child Box color', 'socialv'),
					'subtitle'      	=> esc_html__('Select default body body child box color', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array(
						array('custom_color_switch', '=', 'yes'),
						array('custom_switch_mode', '=', '1'),
					),
					"class"	=> "socialv-sub-fields"
				),

				// Dark Mode
				array(
					'id'            => 'dark_title_color',
					'type'          => 'color',
					'title'         => esc_html__('Title Color', 'socialv'),
					'subtitle'      => esc_html__('Select default Title(Headings) color', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array(
						array('custom_color_switch', '=', 'yes'),
						array('custom_switch_mode', '=', '0'),
					),
					"class"	=> "socialv-sub-fields"
				),

				array(
					'id'            => 'dark_text_color',
					'type'          => 'color',
					'title'         => esc_html__('Body text color', 'socialv'),
					'subtitle'      	=> esc_html__('Select default body text color', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array(
						array('custom_color_switch', '=', 'yes'),
						array('custom_switch_mode', '=', '0'),
					),
					"class"	=> "socialv-sub-fields"
				),

				array(
					'id'            => 'dark_parent_bg_color',
					'type'          => 'color',
					'title'         => esc_html__('Body Parent Box color', 'socialv'),
					'subtitle'      	=> esc_html__('Select default body body parent box color', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array(
						array('custom_color_switch', '=', 'yes'),
						array('custom_switch_mode', '=', '0'),
					),
					"class"	=> "socialv-sub-fields"
				),

				array(
					'id'            => 'dark_child_bg_color',
					'type'          => 'color',
					'title'         => esc_html__('Body Child Box color', 'socialv'),
					'subtitle'      	=> esc_html__('Select default body body child box color', 'socialv'),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array(
						array('custom_color_switch', '=', 'yes'),
						array('custom_switch_mode', '=', '0'),
					),
					"class"	=> "socialv-sub-fields"
				),
				// color end
			)
		));
	}
}
