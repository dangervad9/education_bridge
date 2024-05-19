<?php

/**
 * SocialV\Utility\Redux_Framework\Options\Footer class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class Footer extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Footer', 'socialv'),
			'id' => 'footer',
			'icon' => 'custom-footer-main',
			'customizer_width' => '500px',
		));

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Footer background', 'socialv'),
			'id' => 'footer-logo',
			'icon' => 'custom-Footer-Layout',
			'subsection' => true,
			'desc' => esc_html__('This section contains options for footer background.', 'socialv'),
			'fields' => array(

				array(
					'id' => 'change_footer_background',
					'type' => 'button_set',
					'title' => esc_html__('Change footer color', 'socialv'),
					'subtitle' => esc_html__('Select option for the footer background', 'socialv'),
					'options' => array(
						'default' 	=> esc_html__('Default', 'socialv'),
						'color' 	=> esc_html__('Color', 'socialv'),
						'image' 	=> esc_html__('Image', 'socialv')
					),
					'default' => 'default'
				),

				array(
					'id' => 'footer_bg_color',
					'type' => 'color',
					'title' => esc_html__('Background color', 'socialv'),
					'subtitle' => esc_html__('Choose background color', 'socialv'),
					'required' => array('change_footer_background', '=', 'color'),
					"class"	=> "socialv-sub-fields",
					'mode' => 'background',
					'transparent' => false
				),

				array(
					'id' => 'footer_bg_image',
					'type' => 'media',
					'url' => false,
					'title' => esc_html__('Background image', 'socialv'),
					'subtitle' => esc_html__('Choose background image', 'socialv'),
					'required' => array('change_footer_background', '=', 'image'),
					"class"	=> "socialv-sub-fields",
					'read-only' => false,
					'subtitle' => esc_html__('Upload Footer image for your Website.', 'socialv'),
					'default' => array('url' => get_template_directory_uri() . '/assets/images/redux/footer-img.jpg'),
				),

			)
		));

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Footer Option', 'socialv'),
			'id' => 'footer_section',
			'subsection' => true,
			'icon' => 'custom-Footer-Options',
			'desc' => esc_html__('This section contains options for footer.', 'socialv'),
			'fields' => array(

				array(
					'id' => 'footer_top',
					'type' => 'button_set',
					'title' => esc_html__('Display footer columns', 'socialv'),
					'subtitle' => esc_html__('Display Footer Top On All page', 'socialv'),
					'options' => array(
						'yes' => esc_html__('Yes', 'socialv'),
						'no' => esc_html__('No', 'socialv')
					),
					'default' => esc_html__('yes', 'socialv')
				),

				array(
					'id' => 'socialv_footer_column_layout',
					'type' => 'image_select',
					'title' => esc_html__('Footer Layout Type', 'socialv'),
					'required' => array('footer_top', '=', 'yes'),
					'subtitle' => wp_kses(__('<br />Choose among these structures (1-column, 2-column, 3-column and 4-column) for your footer section.<br />To fill these column sections you should go to appearance > widget.<br />And add widgets as per your needs.', 'socialv'), array('br' => array())),
					'options'   => array(
						1 => array(
							'title' => esc_html__('Layout 1', 'socialv'),
							'img' => get_template_directory_uri() . '/assets/images/redux/footer-1-dark.png',
							'class' => 'footer-layout-1'
						),
						2 => array(
							'title' => esc_html__('Layout 2', 'socialv'),
							'img' => get_template_directory_uri() . '/assets/images/redux/footer-2-dark.png',
							'class' => 'footer-layout-2'
						),
						3 => array(
							'title' => esc_html__('Layout 3', 'socialv'),
							'img' => get_template_directory_uri() . '/assets/images/redux/footer-3-dark.png',
							'class' => 'footer-layout-3'
						),
						4 => array(
							'title' => esc_html__('Layout 4', 'socialv'),
							'img' => get_template_directory_uri() . '/assets/images/redux/footer-4-dark.png',
							'class' => 'footer-layout-4'
						),
						5 => array(
							'title' => esc_html__('Layout 5', 'socialv'),
							'img' => get_template_directory_uri() . '/assets/images/redux/footer-5-dark.png',
							'class' => 'footer-layout-5'
						),
					),
					'default' => '5',
				),

				array(
					'id' => 'footer_one',
					'type' => 'radio',
					'title' => esc_html__('1st Coulmn alignment', 'socialv'),
					'required' => [
						['footer_top', '=', 'yes'],
						["socialv_footer_column_layout", ">", 0]
					],
					"class"			=> "socialv-sub-fields",
					'options' => array(
						'1' => 'Left',
						'2' => 'Right',
						'3' => 'Center',
					),
					'default' => '1',
				),

				array(
					'id' => 'footer_two',
					'type' => 'radio',
					'title' => esc_html__('2nd Coulmn alignment', 'socialv'),
					'required' => array(['footer_top', '=', 'yes'], ["socialv_footer_column_layout", ">", 1]),
					"class"			=> "socialv-sub-fields",
					'options' => array(
						'1' => 'Left',
						'2' => 'Right',
						'3' => 'Center'
					),
					'default' => '1',
				),

				array(
					'id' => 'footer_three',
					'type' => 'radio',
					'title' => esc_html__('3rd Coulmn alignment', 'socialv'),
					'required' => array(['footer_top', '=', 'yes'], ["socialv_footer_column_layout", ">", 2]),
					"class"			=> "socialv-sub-fields",
					'options' => array(
						'1' => 'Left',
						'2' => 'Right',
						'3' => 'Center',
					),
					'default' => '1',
				),

				array(
					'id' => 'footer_four',
					'type' => 'radio',
					'title' => esc_html__('4th Coulmn alignment', 'socialv'),
					'required' => array(['footer_top', '=', 'yes'], ["socialv_footer_column_layout", ">", 3]),
					"class"			=> "socialv-sub-fields",
					'options' => array(
						'1' => 'Left',
						'2' => 'Right',
						'3' => 'Center',
					),
					'default' => '1',
				),
			)
		));

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Footer Copyright', 'socialv'),
			'id' => 'footer_copyright',
			'subsection' => true,
			'icon' => 'custom-CopyRight',
			'fields' => array(

				array(
					'id' => 'display_copyright',
					'type' => 'button_set',
					'title' => esc_html__('Display Copyrights', 'socialv'),
					'options' => array(
						'yes' => esc_html__('Yes', 'socialv'),
						'no' => esc_html__('No', 'socialv')
					),
					'default' => esc_html__('yes', 'socialv')
				),
				array(
					'id' => 'footer_copyright_align',
					'type' => 'select',
					'title' => esc_html__('Copyrights text alignment', 'socialv'),
					'subtitle' => esc_html__('Choose alignment of copyrights text', 'socialv'),
					'required' => array('display_copyright', '=', 'yes'),
					'options' => array(
						'start' => 'Left',
						'end' => 'Right',
						'center' => 'Center',
					),
					'default' => 'center',
				),

				array(
					'id' => 'footer_copyright',
					'type' => 'editor',
					'required' => array('display_copyright', '=', 'yes'),
					'title' => esc_html__('Copyrights Text', 'socialv'),
					'subtitle' => esc_html__('Enter copyrights text here','socialv'),
					'default' => esc_html__('© 2023 SocialV. All Rights Reserved.', 'socialv'),
				),
			)
		));
	}
}
