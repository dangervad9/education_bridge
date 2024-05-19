<?php

/**
 * SocialV\Utility\Redux_Framework\Options\LearnPress class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class LearnPress extends Component
{

    public function __construct()
    {
        $this->set_widget_option();
    }

    protected function set_widget_option()
    {

        Redux::set_section($this->opt_name, array(
            'title' => esc_html__('Course', 'socialv'),
            'id'    => 'socialv_learnPress',
            'icon'  => 'custom-Education',
            'fields' => array(
                array(
                    'id'        => 'lp_page',
                    'type'      => 'image_select',
                    'title'     => esc_html__('Course Page Setting', 'socialv'),
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
                    'id'        => 'socialv_enable_profile_courses_tab',
                    'type'      => 'checkbox',
                    'desc'     => esc_html__('Check this option to show the user courses on a profile tab.', 'socialv'),
                    'title' => __('Enable Profile Courses Tab', 'socialv'),
                    'default'   => '1'
                ),
            )
        ));
    }
}
