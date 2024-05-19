<?php

/**
 * SocialV\Utility\Redux_Framework\Options\General class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class Header extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Header', 'socialv'),
			'id' => 'header',
			'icon' => 'custom-header-main',
			'customizer_width' => '500px',			
			'has_group_title' => __("Page Settings", "socialv"),

		));

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Header', 'socialv'),
			'id'    => 'header_variation',
			'icon' => 'custom-header-main',		
			'subsection' => true,		
			'desc' => esc_html__('This section contains options for header .', 'socialv'),
			'fields' => array(
				array(
					'id' => 'header_layout',
					'type' => 'image_select',
					'title' => esc_html__('Header Style', 'socialv'),
					'subtitle' => esc_html__('Select the design variation that you want to use for site menu.', 'socialv'),
					'options' => array(
						'1' => array(
							'alt' => 'Style1',
							'img' => get_template_directory_uri() . '/assets/images/redux/header-1.png',
						),
						'2' => array(
							'alt' => 'Style2',
							'img' => get_template_directory_uri() . '/assets/images/redux/header-2.png',
						),
					),
					'default' => '1'
				),

				// --------main header background options start----------//

				array(
					'id'	 	=> 'socialv_header_background_type',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Background', 'socialv'),
					'subtitle' 	=> esc_html__('Select the variation for header background', 'socialv'),
					'options' 	=> array(
						'default' 		=> esc_html__('Default', 'socialv'),
						'color' 		=> esc_html__('Color', 'socialv'),
						'image' 		=> esc_html__('Image', 'socialv'),
						'transparent' 	=> esc_html__('Transparent', 'socialv')
					),
					'default' 	=> esc_html__('default', 'socialv')
				),

				array(
					'id' 		=> 'socialv_header_background_color',
					'type' 		=> 'color',
					'title' 		=> esc_html__('Background Color', 'socialv'),
					'subtitle' 		=> esc_html__('Choose background Color', 'socialv'),
					'required' 	=> array('socialv_header_background_type', '=', 'color'),
					"class"	=> "socialv-sub-fields",
					'mode' 		=> 'background',
					'transparent' => false
				),

				array(
					'id' 		=> 'socialv_header_background_image',
					'type' 		=> 'media',
					'url' 		=> false,
					'title' 		=> esc_html__('Background image', 'socialv'),
					'subtitle' 		=> esc_html__('Upload background image', 'socialv'),
					'required' 	=> array('socialv_header_background_type', '=', 'image'),
					"class"	=> "socialv-sub-fields",
					'read-only' => false,
					'subtitle' 	=> esc_html__('Upload background image for header.', 'socialv'),
				),

				// --------main header Background options end----------//

				array(
					'id' 		=> 'header_menu_limit',
					'type' 		=> 'text',
					'title' 		=> esc_html__('Show Menu Limit', 'socialv'),
					'subtitle'  => esc_html__('Enter a value for the header menu range', 'socialv'),
					'default' 	=> 6,
				),

				// -------- header Search ----------//

				array(
					'id' 		=> 'header_display_search',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Display Search', 'socialv'),
					'subtitle'  => esc_html__('Turn on to display the Search in header.', 'socialv'),
					'options' 	=> array(
						'yes' 		=> esc_html__('On', 'socialv'),
						'no' 		=> esc_html__('Off', 'socialv')
					),
					'default'	=> esc_html__('yes', 'socialv'),
				),

				array(
					'id' 		=> 'header_search_text',
					'type' 		=> 'text',
					'title' 		=> esc_html__('Enter Placeholder Text', 'socialv'),
					'required' 	=> array('header_display_search', '=', 'yes'),
					'validate' 	=> 'text',
					"class"	=> "socialv-sub-fields",
					'default' 	=> esc_html__('Search here', 'socialv'),
				),


				array(
					'id' 		=> 'header_search_limit',
					'type' 		=> 'text',
					'title' 		=> esc_html__('Show List Limit', 'socialv'),
					'subtitle'  => esc_html__('Enter a value for the text range', 'socialv'),
					'required' 	=> array('header_display_search', '=', 'yes'),
					"class"	=> "socialv-sub-fields",
					'default' 	=> 5,
				),


				// -------- header Friend Request ----------//

				array(
					'id' 		=> 'header_display_frndreq',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Display Friend Requests', 'socialv'),
					'options' 	=> array(
						'yes' 		=> esc_html__('On', 'socialv'),
						'no' 		=> esc_html__('Off', 'socialv')
					),
					'default'	=> esc_html__('yes', 'socialv'),
				),

				// -------- header Messages ----------//

				array(
					'id' 		=> 'header_display_messages',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Display Messages', 'socialv'),
					'options' 	=> array(
						'yes' 		=> esc_html__('On', 'socialv'),
						'no' 		=> esc_html__('Off', 'socialv')
					),
					'default'	=> esc_html__('yes', 'socialv'),
				),

				// -------- header Notification ----------//

				array(
					'id' 		=> 'header_display_notification',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Display Notifications', 'socialv'),
					'options' 	=> array(
						'yes' 		=> esc_html__('On', 'socialv'),
						'no' 		=> esc_html__('Off', 'socialv')
					),
					'default'	=> esc_html__('yes', 'socialv'),
				),

				array(
					'id' 		=> 'header_notification_limit',
					'type' 		=> 'text',
					'title' 		=> esc_html__('Show List Limit', 'socialv'),
					'required' 	=> array('header_display_notification', '=', 'yes'),
					'subtitle'  => esc_html__('Enter a value for the text range', 'socialv'),
					"class"	=> "socialv-sub-fields",
					'default' 	=> 10,
				),


				// -------- header Cart ----------//

				array(
					'id'        => 'display_header_cart_button',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Cart Icon', 'socialv'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'socialv'),
						'no' => esc_html__('No', 'socialv')
					),
					'default'   => esc_html__('yes', 'socialv')
				),

				// -------- header User ----------//

				array(
					'id' => 'site_login_link_section',
					'type' => 'section',
					'title' => esc_html__('Login', 'socialv'),
					'indent' => true,
					'required' 	=> array('header_layout', '=', '2'),
				),

				array(
					'id' 		=> 'header_display_login',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Display Login Button', 'socialv'),
					'options' 	=> array(
						'yes' 		=> esc_html__('On', 'socialv'),
						'no' 		=> esc_html__('Off', 'socialv')
					),
					"class"	=> "socialv-sub-fields",
					'default'	=> esc_html__('yes', 'socialv'),
					'required' 	=> array('header_layout', '=', '2'),
				),

				array(
					'id'        => 'site_login_title',
					'type'      => 'text',
					'title'     => esc_html__('Button Text', 'socialv'),
					'subtitle'     => esc_html__('Enter Button Text', 'socialv'),
					'default'     => esc_html__('Login', 'socialv'),
					"class"	=> "socialv-sub-fields",
					'required' 	=> array('header_display_login', '=', 'yes'),
				),

				array(
                    'id'        => 'is_socialv_site_login_icon_desktop',
                    'type'      => 'checkbox',
                    'desc'     => esc_html__('Showing Login Icon in desktop view.', 'socialv'),
                ),


				array(
					'id'       => 'socialv_site_login_logo',
					'type'     => 'media',
					'url'      => false,
					'read-only' => false,
					'required' 	=> array('header_display_login', '=', 'yes'),
					'default'  => array('url' => get_template_directory_uri() . '/assets/images/redux/login-icon.svg'),
				),

				array(
					'id'       	=> 'site_login',
					'type'     	=> 'switch',
					'on'		=> esc_html__('Popup', 'socialv'),
					'off'		=> esc_html__('New Page', 'socialv'),
					'default'   => '0',
					"class"	=> "socialv-sub-fields",
					'title'    	=> esc_html__('Display Login Form', 'socialv'),
					'required' 	=> array('header_display_login', '=', 'yes'),
				),
				array(
					'id'        => 'site_login_link',
					'type'     => 'select',
					'multi'    => false,
					'data'     => 'pages',
					"class"	=> "socialv-sub-fields",
					'title'     => esc_html__('Select Page For Login', 'socialv'),
					'subtitle'      =>  esc_html__('Use [iqonic-login] Shortcode on a page which you selected', 'socialv'),
					'required' 	=> array('site_login', '=', '0'),
				),


				array(
					'id'        => 'site_login_shortcode',
					'type'     => 'text',
					"class"	=> "socialv-sub-fields",
					'title'     => esc_html__('Login Form', 'socialv'),
					'subtitle'      =>  esc_html__('Use [iqonic-login] Shortcode to display form', 'socialv'),
					'required' 	=> array('site_login', '=', '1'),
					'default' => '[iqonic-login]',
				),

				array(
					'id'        => 'site_login_desc',
					'type'      => 'text',
					"class"	=> "socialv-sub-fields",
					'title'     => esc_html__('Login Description', 'socialv'),
					'subtitle'     => esc_html__('Enter Description Text for Login', 'socialv'),
					'default'     => esc_html__('Welcome to socialV, a platform to connect with the social world', 'socialv'),
					'required' 	=> array('header_display_login', '=', 'yes'),
				),

				array(
					'id'        => 'site_forgetpwd_link',
					'type'     => 'select',
					'multi'    => false,
					'data'     => 'pages',
					"class"	=> "socialv-sub-fields",
					'title'     => esc_html__('Select Page For Forget Password', 'socialv'),
					'subtitle'      =>  esc_html__('Use [iqonic-lost-pass] Shortcode on a page which you selected', 'socialv'),
					'required' 	=> array('site_login', '=', '0'),
				),


				array(
					'id'        => 'site_forgetpwd_shortcode',
					'type'     => 'text',
					"class"	=> "socialv-sub-fields",
					'title'     => esc_html__('Forget Password Form', 'socialv'),
					'subtitle'      =>  esc_html__('Use [iqonic-lost-pass] Shortcode to display form', 'socialv'),
					'required' 	=> array('site_login', '=', '1'),
					'default' => '[iqonic-lost-pass]',
				),

				array(
					'id'        => 'site_forgetpwd_desc',
					'type'      => 'text',
					"class"	=> "socialv-sub-fields",
					'title'     => esc_html__('Forget Password Text', 'socialv'),
					'subtitle'     => esc_html__('Enter Description Text for Forget Password', 'socialv'),
					'default'     => esc_html__('Welcome to socialV, a platform to connect with the social world', 'socialv'),
					'required' 	=> array('header_display_login', '=', 'yes'),
				),


				array(
					'id'        => 'site_register_link',
					'type'     => 'select',
					'multi'    => false,
					'data'     => 'pages',
					"class"	=> "socialv-sub-fields",
					'title'     => esc_html__('Select Page For Register', 'socialv'),
					'subtitle'      =>  esc_html__('Use [iqonic-register] Shortcode on a page which you selected', 'socialv'),
					'required' 	=> array('header_display_login', '=', 'yes'),
				),

				array(
					'id'        => 'site_register_desc',
					'type'      => 'text',
					"class"	=> "socialv-sub-fields",
					'title'     => esc_html__('Register Text', 'socialv'),
					'subtitle'     => esc_html__('Enter Description Text for Register', 'socialv'),
					'default'     => esc_html__('Welcome to socialV, a platform to connect with the social world', 'socialv'),
					'required' 	=> array('header_display_login', '=', 'yes'),
				),

			)
		));
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Sticky Header', 'socialv'),
			'id' => 'sticky_header',
			'icon' => 'custom-header-main',
			'subsection' => true,
			'desc' => esc_html__('This section contains options for sticky header background.', 'socialv'),
			'fields' => array(

				array(
					'id'	 	=> 'socialv_sticky_header_background_type',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Background', 'socialv'),
					'subtitle' 	=> esc_html__('Select the variation for header background', 'socialv'),
					'options' 	=> array(
						'default' 		=> esc_html__('Default', 'socialv'),
						'color' 		=> esc_html__('Color', 'socialv'),
						'image' 		=> esc_html__('Image', 'socialv'),
						'transparent' 	=> esc_html__('Transparent', 'socialv')
					),
					'default' 	=> esc_html__('default', 'socialv')
				),

				array(
					'id' 		=> 'socialv_sticky_header_background_color',
					'type' 		=> 'color',
					'title' 		=> esc_html__('Background Color', 'socialv'),
					'subtitle' 		=> esc_html__('Choose background Color', 'socialv'),
					'required' 	=> array('socialv_sticky_header_background_type', '=', 'color'),
					"class"	=> "socialv-sub-fields",
					'mode' 		=> 'background',
					'transparent' => false
				),

				array(
					'id' 		=> 'socialv_sticky_header_background_image',
					'type' 		=> 'media',
					'url' 		=> false,
					'title' 		=> esc_html__('Background image', 'socialv'),
					'subtitle' 		=> esc_html__('Upload background image', 'socialv'),
					'required' 	=> array('socialv_sticky_header_background_type', '=', 'image'),
					"class"	=> "socialv-sub-fields",
					'read-only' => false,
					'subtitle' 	=> esc_html__('Upload background image for header.', 'socialv'),
				),
			)
		));
	}
}
