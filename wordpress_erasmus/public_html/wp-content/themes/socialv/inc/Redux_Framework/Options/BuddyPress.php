<?php

/**
 * SocialV\Utility\Redux_Framework\Options\BuddyPress class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class BuddyPress extends Component
{

    public function __construct()
    {
        $this->set_widget_option();
    }

    protected function set_widget_option()
    {

        $default = new BpPage();

        Redux::set_section($this->opt_name, array(
            'title' => esc_html__('BuddyPress', 'socialv'),
            'id'    => 'socialv_buddypress',
            'icon'  => 'custom-social-groups',
        ));
        /* Execute Groups Options Settings */
        Redux::set_section($this->opt_name, array(
            'title' => esc_html__('Default Settings', 'socialv'),
            'id' => 'defaults_options',
            'icon' => 'custom-default-settings',
            'subsection' => true,
            'fields' => $default->set_widget_option()
        ));

        Redux::set_section($this->opt_name, array(
            'title' => esc_html__('Banner Settings', 'socialv'),
            'id'    => 'bp_banner',
            'icon'  => 'custom-banner-setting',
            'subsection' => true,
            'fields' => array(
                array(
                    'id' => 'bp_display_banner',
                    'type' => 'button_set',
                    'title' => esc_html__('Display Banner', 'socialv'),
                    'options' => array(
                        'yes' => esc_html__('Yes', 'socialv'),
                        'no' => esc_html__('No', 'socialv')
                    ),
                    'default' => esc_html__('yes', 'socialv')
                ),
                array(
                    'id'        => 'bp_page_default_banner_image',
                    'type'      => 'media',
                    'url'       => true,
                    'title'     => esc_html__('Default Banner Image', 'socialv'),
                    'read-only' => false,
                    'subtitle'  => esc_html__('Upload default banner image for your Website.', 'socialv'),
                    'required'  => array('bp_display_banner', '=', 'yes'),
                    'desc' => '<i class="custom-info"></i><span class="media-label">' . esc_html__(' Upload your banner image', 'socialv') . '</span>',
                ),
                array(
                    'id' => 'bp_display_banner_title',
                    'type' => 'button_set',
                    'title' => esc_html__('Display title on breadcrumb', 'socialv'),
                    'options' => array(
                        'yes' => esc_html__('Yes', 'socialv'),
                        'no' => esc_html__('No', 'socialv')
                    ),
                    'required' => array('bp_display_banner', '=', 'yes'),
                    'default' => esc_html__('yes', 'socialv')
                ),
                array(
                    'id' => 'bp_banner_title_tag',
                    'type' => 'select',
                    'title' => esc_html__('Title tag', 'socialv'),
                    'subtitle' => esc_html__('Choose title tag', 'socialv'),
                    "class"    => "socialv-sub-fields",
                    'options' => array(
                        'h1' => 'h1',
                        'h2' => 'h2',
                        'h3' => 'h3',
                        'h5' => 'h4',
                        'h5' => 'h5',
                        'h6' => 'h6'
                    ),
                    'required' => array('bp_display_banner_title', '=', 'yes'),
                    'default' => 'h1'
                ),
                array(
                    'id' => 'bp_banner_title_color',
                    'type' => 'color',
                    'title' => esc_html__('Title color', 'socialv'),
                    'subtitle' => esc_html__('Choose title color', 'socialv'),
                    'default'       => '',
                    'mode' => 'background',
                    "class"    => "socialv-sub-fields",
                    'required' => array('bp_display_banner_title', '=', 'yes'),
                    'transparent' => false
                ),
                array(
                    'id'         => 'bp_banner_subtitle_text',
                    'type'         => 'text',
                    'title'         => esc_html__('Subtitle', 'socialv'),
                    'subtitle'         => esc_html__('Enter Subtitle Text', 'socialv'),
                    'required'  => array('bp_display_banner', '=', 'yes'),
                    'validate'     => 'text',
                    'default'     => esc_html__('Good Communication is the key to cop-up with good ideas', 'socialv'),
                ),

            )
        ));


        // -------- Activity Settings ----------//
        Redux::set_section($this->opt_name, array(
            'title' => esc_html__('Activity Feeds', 'socialv'),
            'id'    => 'bp_activity_feeds',
            'icon'  => 'custom-activity',
            'subsection' => true,
            'fields' => array(

                array(
                    'id'        => 'display_activity_showing_story',
                    'type'      => 'button_set',
                    'title'     => esc_html__('Display all user story', 'socialv'),
                    'subtitle'  => esc_html__('This option allows you to display activities of all users in feed. Turn this option off to display only friends activities.', 'socialv'),
                    'desc'      => esc_html__('Turn on to display activity of all users.', 'socialv'),
                    'options'   => array(
                        'on' => esc_html__('On', 'socialv'),
                        'off' => esc_html__('Off', 'socialv')
                    ),
                    'default'   => 'off'
                ),

                array(
                    'id'        => 'display_activity_showing_friends',
                    'type'      => 'button_set',
                    'title'     => esc_html__('Display activities of all user', 'socialv'),
                    'subtitle'  => esc_html__('This option allows you to display activities of all users in feed. Turn this option off to display only friends activities.', 'socialv'),
                    'desc'      => esc_html__('Turn on to display activity of all users.', 'socialv'),
                    'options'   => array(
                        'yes' => esc_html__('On', 'socialv'),
                        'no' => esc_html__('Off', 'socialv')
                    ),
                    'default'   => 'yes'
                ),

                array(
					'id'        => 'display_comments_order',
                    'type'      => 'select',
                    'title'     => esc_html__('Display Comments Order', 'socialv'),
                    'subtitle'  => esc_html__('This option allows you to change activity comments order.', 'socialv'),
                    'desc'      => esc_html__('Change order of comments Ascending / Descending.', 'socialv'),
                    'options'   => array(
                        'ASC' => esc_html__('Ascending', 'socialv'),
                        'DESC' => esc_html__('Descending', 'socialv')
                    ),
                    'default'   => 'ASC'
				),

                array(
                    'id'        => 'display_activities_posts_style',
                    'type'      => 'button_set',
                    'title'     => esc_html__('Display Activities Posts Style: Customizing the Feed', 'socialv'),
                    'desc'  => esc_html__('This option allows you to display activities of all users in a selected style feed.', 'socialv'),
                    'options'   => array(
                        'list' => esc_html__('List', 'socialv'),
                        'grid' => esc_html__('Grid', 'socialv')
                    ),
                    'default'   => 'grid'
                ),

                array(
                    'id'        => 'is_post_blur_style',
                    'type'      => 'button_set',
                    'desc'  => esc_html__('This option allows you to display activities of posts in a full image style without any blur.', 'socialv'),
                    'options'   => array(
                        'yes' => esc_html__('Yes', 'socialv'),
                        'no' => esc_html__('No', 'socialv')
                    ),
                    'default'   => 'no',
                ),

                array(
                    'id'        => 'display_blog_post_type',
                    'type'      => 'checkbox',
                    'desc'     => esc_html__('Showing blog post in activity page.', 'socialv'),
                    'title' => esc_html__('Activity Blog Posts', 'socialv'),
                    'default'   => '1'
                ),

                array(
                    'id'        => 'is_socialv_enable_hide_post',
                    'type'      => 'checkbox',
                    'desc'     => esc_html__('Allow members to hide post option in activity page.', 'socialv'),
                    'title' => esc_html__('Hide Posts', 'socialv'),
                    'default'   => '1'
                ),

                array(
                    'id'        => 'is_socialv_enable_share_post',
                    'type'      => 'checkbox',
                    'desc'     => esc_html__('Allow members to share post option in activity page.', 'socialv'),
                    'title' => esc_html__('Share Posts', 'socialv'),
                    'default'   => '1'
                ),

            )
        ));

        // -------- User Profile Settings ----------//
        Redux::set_section($this->opt_name, array(
            'title' => esc_html__('Member Profiles', 'socialv'),
            'id'    => 'user_section',
            'icon'  => 'custom-member-profile',
            'subsection' => true,
            'fields' => array(
                array(
                    'id'        => 'display_user_post',
                    'type'      => 'button_set',
                    'title'     => esc_html__('Show Post', 'socialv'),
                    'subtitle'  => esc_html__('Turn on to display user profile header in show total posts.', 'socialv'),
                    'options'   => array(
                        'yes'   => esc_html__('On', 'socialv'),
                        'no'    => esc_html__('Off', 'socialv')
                    ),
                    'default'   => 'yes'
                ),
                array(
                    'id'        => 'display_user_comments',
                    'type'      => 'button_set',
                    'title'     => esc_html__('Show Comments', 'socialv'),
                    'subtitle' => esc_html__('Turn on to display user profile header in show total comments.', 'socialv'),
                    'options'   => array(
                        'yes' => esc_html__('On', 'socialv'),
                        'no' => esc_html__('Off', 'socialv')
                    ),
                    'default'   => 'yes'
                ),
                array(
                    'id'        => 'display_user_views',
                    'type'      => 'button_set',
                    'title'     => esc_html__('Show Views', 'socialv'),
                    'subtitle' => esc_html__('Turn on to display user profile header in show total views.', 'socialv'),
                    'options'   => array(
                        'yes' => esc_html__('On', 'socialv'),
                        'no' => esc_html__('Off', 'socialv')
                    ),
                    'default'   => 'yes'
                ),
                array(
                    'id'        => 'display_user_request_btn',
                    'type'      => 'button_set',
                    'title'     => esc_html__('Show Request Button', 'socialv'),
                    'subtitle' => esc_html__('Turn on to display user profile header in show request button.', 'socialv'),
                    'options'   => array(
                        'yes' => esc_html__('On', 'socialv'),
                        'no' => esc_html__('Off', 'socialv')
                    ),
                    'default'   => 'yes'
                ),
                array(
                    'id'        => 'display_user_message_btn',
                    'type'      => 'button_set',
                    'title'     => esc_html__('Show Message Button', 'socialv'),
                    'subtitle' => esc_html__('Turn on to display user profile header in show message button.', 'socialv'),
                    'options'   => array(
                        'yes' => esc_html__('On', 'socialv'),
                        'no' => esc_html__('Off', 'socialv')
                    ),
                    'default'   => 'yes'
                ),
            )
        ));


        // -------- Group Settings ----------//
        Redux::set_section($this->opt_name, array(
            'title' => esc_html__('Social Groups', 'socialv'),
            'id'    => 'group_section',
            'icon'  => 'custom-social-groups',
            'subsection' => true,
            'fields' => array(
                array(
                    'id'        => 'show_rss_group_field',
                    'type'      => 'checkbox',
                    'desc'     => esc_html__('Showing Rss Field in Group page.', 'socialv'),
                    'title' => esc_html__('Enable Rss Field', 'socialv'),
                    'default'   => '1'
                ),
            )
        ));
    }
}
