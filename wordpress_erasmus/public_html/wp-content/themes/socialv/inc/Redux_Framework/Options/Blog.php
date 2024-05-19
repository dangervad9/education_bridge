<?php

/**
 * SocialV\Utility\Redux_Framework\Options\Blog class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class Blog extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Blog', 'socialv'),
			'id'    => 'blog',
			'icon'  => 'custom-Blog',
			'customizer_width' => '500px',
		));

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('General Blogs', 'socialv'),
			'id'    => 'blog-section',
			'subsection' => true,
			'icon' => 'custom-General-Blog',
			'desc'  => esc_html__('This section contains options for blog.', 'socialv'),
			'fields' => array(

				array(
					'id'        => 'blog_setting',
					'type'      => 'image_select',
					'title'     => esc_html__('Blog page Setting', 'socialv'),
					'subtitle'  => wp_kses(__('Choose among these structures (Right Sidebar, Left Sidebar, 1column, 2column and 3column) for your blog section.<br />To filling these column sections you should go to appearance > widget.<br />And put every widget that you want in these sections.', 'socialv'), array('br' => array())),
					'options'   => array(
						'1' => array(
							'title' => esc_html__('One column', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/one-column-dark.png',
							'class' => 'one-column'
						),
						'2' => array(
							'title' => esc_html__('Two column', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/two-column-dark.png',
							'class' => 'two-column'
						),
						'3' => array(
							'title' => esc_html__('Three column', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/three-column-dark.png',
							'class' => 'three-column'
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
					'id'       => 'blog_default_banner_image',
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__('Blog Page Default Banner Image', 'socialv'),
					'read-only' => false,
					'default'  => array('url' => get_template_directory_uri() . '/assets/images/redux/banner.jpg'),
					'subtitle' => esc_html__('Upload banner image for your Website. Otherwise blank field will be displayed in place of this section.', 'socialv') . '<b>' . esc_html__("(Note:Only Display Banner Style Second & Third in Page Banner Setting)", "socialv") . '</b>',
					'desc' => '<i class="custom-info"></i><span class="media-label">'.esc_html__(' Upload your blog banner image','socialv').'</span>',
				),

				array(
					'id'        => 'display_pagination',
					'type'      => 'button_set',
					'title'     => esc_html__('Pagination', 'socialv'),
					'subtitle' => esc_html__('Turn on to display pagination for the blog page.', 'socialv'),
					'options'   => array(
						'yes' => esc_html__('On', 'socialv'),
						'no' => esc_html__('Off', 'socialv')
					),
					'default'   => esc_html__('yes', 'socialv')
				)
			)
		));

		Redux::set_section($this->opt_name, array(
			'title'      => esc_html__('Blog Single Post', 'socialv'),
			'id'         => 'basic',
			'subsection' => true,
			'icon' => 'custom-Single-Blog',
			'fields'     => array(

				array(
					'id'        => 'blog_single_page_setting',
					'type'      => 'image_select',
					'title'     => esc_html__('Blog single page layout', 'socialv'),
					'subtitle'  => wp_kses(__('Choose among these structures (Right Sidebar, Left Sidebar and 1column) for your blog section.<br />To filling these column sections you should go to appearance > widget.<br />And put every widget that you want in these sections.', 'socialv'), array('br' => array())),
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
					'id'        => 'display_comment',
					'type'      => 'button_set',
					'title'     => esc_html__('Comments', 'socialv'),
					'subtitle' => esc_html__('Turn on to display comments', 'socialv'),
					'options'   => array(
						'yes' => esc_html__('On', 'socialv'),
						'no' => esc_html__('Off', 'socialv')
					),
					'default'   => esc_html__('yes', 'socialv')
				),

				array(
					'id'       => 'posts_select',
					'type'     => 'select',
					'multi'    => true,
					'title'    => esc_html__('Select Posts for hide Featured Images', 'socialv'),
					'options' => (function_exists('socialv_get_post_format_dynamic')) ? socialv_get_post_format_dynamic() : '',
				),

			)
		));
	}
}
