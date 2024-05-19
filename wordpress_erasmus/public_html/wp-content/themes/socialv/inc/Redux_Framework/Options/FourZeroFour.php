<?php

/**
 * SocialV\Utility\Redux_Framework\Options\FourZeroFour class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class FourZeroFour extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('404', 'socialv'),
			'id'    => 'fourzerofour',
			'icon'  => 'custom-404',
			'desc'  => esc_html__('This section contains options for 404.', 'socialv'),
			'fields' => array(

				array(
					'id'       	=> '404_banner_image',
					'type'     	=> 'media',
					'url'      	=> true,
					'title'    	=> esc_html__('Image', 'socialv'),
					'read-only' => false,
					'default'  	=> array('url' => get_template_directory_uri() . '/assets/images/redux/404.png'),
					'subtitle' 	=> esc_html__('Upload 404 image for your Website.', 'socialv'),
					'desc' => '<i class="custom-info"></i><span class="media-label">'.esc_html__(' Upload your 404 image','socialv').'</span>',
				),

				array(
					'id'        => '404_title',
					'type'      => 'text',
					'title'     => esc_html__('Title', 'socialv'),
					'subtitle'     => esc_html__('Enter title text for 404 page', 'socialv'),
					'default'   => esc_html__('Page Not Found.', 'socialv'),
				),

				array(
					'id'        => '404_description',
					'type'      => 'textarea',
					'title'     => esc_html__('Description', 'socialv'),
					'subtitle'     => esc_html__('Enter description text for 404 page', 'socialv'),
					'default'   => esc_html__('The requested page does not exist.', 'socialv'),
				),

				array(
					'id'        => '404_backtohome_title',
					'type'      => 'text',
					'title'     => esc_html__('Button', 'socialv'),
					'subtitle'     => esc_html__('Enter text for button label', 'socialv'),
					'default'   => esc_html__('Back to Home', 'socialv'),
				),
				array(
					'id'       	=> 'header_on_404',
					'type'     	=> 'switch',
					'on'		=> esc_html__('Enable', 'socialv'),
					'off'		=> esc_html__('Disable', 'socialv'),
					'title'    	=> esc_html__('Header', 'socialv'),
					'subtitle' 	=> esc_html__('Enable / disable header on 404 page', 'socialv'),
					'default'  	=> true,
				),

				array(
					'id'       	=> 'footer_on_404',
					'type'     	=> 'switch',
					'on'		=> esc_html__('Enable', 'socialv'),
					'off'		=> esc_html__('Disable', 'socialv'),
					'title'    	=> esc_html__('Footer', 'socialv'),
					'subtitle' 	=> esc_html__('Enable / disable footer on 404 page', 'socialv'),
					'default'  	=> true,
				)
			)
		));
	}
}
