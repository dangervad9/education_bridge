<?php

/**
 * SocialV\Utility\Redux_Framework\Options\BpPage class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class BpPage extends Component
{
	public function set_widget_option()
	{
		return array(

			array(
				'id'        => 'bp_page',
				'type'      => 'image_select',
				'title'     => esc_html__('BuddyPress Page Setting', 'socialv'),
				'subtitle'  => wp_kses(__('<br />Choose among these structures (Right Sidebar, Left Sidebar and No Sidebar) for your Search page.<br />To filling these column sections you should go to appearance > widget.<br />And put every widget that you want in these sections.', 'socialv'), array('br' => array())),
				'options'   => array(
					'1' => array(
						'title' => esc_html__('Full Width', 'socialv'),
						'img' => get_template_directory_uri() . '/assets/images/redux/one-column-dark.png',
						'class' => 'one-column'
					),
					'4' => array(
						'title' => esc_html__('Right sidebar', 'socialv'),
						'img' => get_template_directory_uri() . '/assets/images/redux/right-sidebar-dark.png',
						'class' => 'right-sidebar'
					),
					'5' => array(
						'title' => esc_html__('Left sidebar', 'socialv'),
						'img' => get_template_directory_uri() . '/assets/images/redux/left-sidebar-dark.png',
						'class' => 'left-sidebar'
					),
				),
				'default'   => '1',
			),

			array(
				'id'        => 'default_post_per_page',
				'type'      => 'text',
				'title'     => esc_html__('Post Per Page', 'socialv'),
				'default'   => '20',
			),

			array(
				'id' => 'display_default_login_access',
				'type' => 'button_set',
				'title' => esc_html__('Display Default Login Access', 'socialv'),
				'options' => array(
					'yes' => esc_html__('Yes', 'socialv'),
					'no' => esc_html__('No', 'socialv')
				),
				'default' => esc_html__('no', 'socialv')
			),

			array(
				'id'       => 'socialv_default_avatar',
				'type'     => 'media',
				'url'      => false,
				'title'    => esc_html__('Upload Avatar', 'socialv'),
				'read-only' => false,
				'subtitle' => esc_html__('Upload Avatar image from here.', 'socialv'),
			),

			array(
				'id'       => 'socialv_default_cover_image',
				'type'     => 'media',
				'url'      => false,
				'title'    => esc_html__('Upload Cover Image', 'socialv'),
				'read-only' => false,
				'subtitle' => esc_html__('Upload cover image from here.', 'socialv'),
			),


		);
	}
}
