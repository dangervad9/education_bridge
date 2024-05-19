<?php

/**
 * SocialV\Utility\Redux_Framework\Options\breadcrumb class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class Breadcrumb extends Component
{

    public function __construct()
    {
        $this->set_widget_option();
    }

    protected function set_widget_option()
    {
        Redux::set_section($this->opt_name, array(
            'title' => esc_html__('Breadcrumb Settings', 'socialv'),
            'id'    => 'breadcrumb',
            'icon'  => 'custom-Breadcrumb',
            'desc'  => esc_html__('This section contains options for Page Breadcrumb.', 'socialv'),
            'fields' => array(

                array(
                    'id' => 'display_banner',
                    'type' => 'button_set',
                    'title' => esc_html__('Display Banner Breadcrumb', 'socialv'),
                    'options' => array(
                        'yes' => esc_html__('Yes', 'socialv'),
                        'no' => esc_html__('No', 'socialv')
                    ),
                    'default' => esc_html__('yes', 'socialv')
                ),

                array(
                    'id'        => 'breadcrumb_style',
                    'type'      => 'image_select',
                    'title'     => esc_html__('Select breadcrumb Style', 'socialv'),
                    'subtitle'  => esc_html__('Select the style that best fits your needs.', 'socialv'),
                    'options'   => array(
						'1' => array(
							'title' => esc_html__('Center alignment', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/title-dark-1.png',
							'class' => 'title-1'
						),
						'2' => array(
							'title' => esc_html__('Left alignment', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/title-dark-2.png',
							'class' => 'title-2'
						),
						'3' => array(
							'title' => esc_html__('Right alignment', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/title-dark-3.png',
							'class' => 'title-3'
						),
                        '4' => array(
							'title' => esc_html__('Single left alignment', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/title-dark-4.png',
							'class' => 'title-4'
						),
                        '5' => array(
							'title' => esc_html__('Single right alignment', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/title-dark-5.png',
							'class' => 'title-5'
						),
					),
                    'default'   => '1',
                    'required'  => array('display_banner', '=', 'yes'),
                ),

                array(
                    'id'        => 'page_default_breadcrumb_image',
                    'type'      => 'media',
                    'url'       => true,
                    'title'     => esc_html__('Default breadcrumb Image', 'socialv'),
                    'read-only' => false,
                    'subtitle'  => esc_html__('Upload default breadcrumb image for your Website.', 'socialv'),
                    'required'  => array(
                        array(
                            'display_banner', '=', 'yes'
                        ),
                        array(
                            'breadcrumb_style', '=', array('2','3')
                        )
                    ),
                ),

                array(
                    'id' => 'display_breadcrumb_title',
                    'type' => 'button_set',
                    'title' => esc_html__('Display title on breadcrumb', 'socialv'),
                    'options' => array(
                        'yes' => esc_html__('Yes', 'socialv'),
                        'no' => esc_html__('No', 'socialv')
                    ),
                    'required' => array('display_banner', '=', 'yes'),
                    'default' => esc_html__('yes', 'socialv')
                ),


                array(
                    'id' => 'breadcrumb_title_tag',
                    'type' => 'select',
                    'title' => esc_html__('Title tag', 'socialv'),
                    'subtitle' => esc_html__('Choose title tag', 'socialv'),
                    'options' => array(
                        'h1' => 'h1',
                        'h2' => 'h2',
                        'h3' => 'h3',
                        'h5' => 'h4',
                        'h5' => 'h5',
                        'h6' => 'h6'
                    ),
                    'required' => array('display_breadcrumb_title', '=', 'yes'),
                    "class"	=> "socialv-sub-fields",
                    'default' => 'h2'
                ),

                array(
                    'id' => 'breadcrumb_title_color',
                    'type' => 'color',
                    'title' => esc_html__('Title color', 'socialv'),
                    'subtitle' => esc_html__('Choose title color', 'socialv'),
                    'default'       => '',
                    'mode' => 'background',
                    'required' => array('display_breadcrumb_title', '=', 'yes'),
                    "class"	=> "socialv-sub-fields",
                    'transparent' => false
                ),

                array(
                    'id' => 'display_breadcrumb_nav',
                    'type' => 'button_set',
                    'title' => esc_html__('Display navigation on breadcrumb', 'socialv'),
                    'options' => array(
                        'yes' => esc_html__('Yes', 'socialv'),
                        'no' => esc_html__('No', 'socialv')
                    ),
                    'required' => array('display_banner', '=', 'yes'),
                    'default' => esc_html__('yes', 'socialv')
                ),

                array(
                    'id'       => 'breadcrumb_back_type',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Breadcrumb Background', 'socialv'),
                    'options'  => array(
                        '1' => 'Color',
                        '2' => 'Image'
                    ),
                    'required' => array('display_banner', '=', 'yes'),
                    'default'  => '2'
                ),

                array(
                    'id'            => 'breadcrumb_back_color',
                    'type'          => 'color',
                    'title'         => esc_html__('Background color', 'socialv'),
                    'subtitle'         => esc_html__('Choose breadcrumb background color', 'socialv'),
                    'required'  => array('breadcrumb_back_type', '=', '1'),
                    'mode'          => 'background',
                    "class"	=> "socialv-sub-fields",
                    'transparent'   => false
                ),

                array(
                    'id'       => 'breadcrumb_back_image',
                    'type'     => 'media',
                    'url'      => false,
                    'desc' => '<i class="custom-info"></i><span class="media-label">'.esc_html__(' Upload your breadcrumb background image','socialv').'</span>',
                    'title'    => esc_html__('Background image', 'socialv'),
                    'subtitle'    => esc_html__('Choose breadcrumb background image', 'socialv'),
                    'read-only' => false,
                    "class"	=> "socialv-sub-fields",
                    'required'  => array('breadcrumb_back_type', '=', '2'),
                    'default'  => array('url' => get_template_directory_uri() . '/assets/images/redux/banner.jpg'),
                ),
            )
        ));
    }
}
