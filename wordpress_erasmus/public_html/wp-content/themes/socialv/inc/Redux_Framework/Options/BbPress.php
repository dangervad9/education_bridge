<?php

/**
 * SocialV\Utility\Redux_Framework\Options\General class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class BbPress extends Component
{

    public function __construct()
    {
        $this->set_widget_option();
    }

    protected function set_widget_option()
    {
        Redux::set_section($this->opt_name, array(
            'title' => esc_html__('Forums', 'socialv'),
            'id'    => 'socialv_bbp',
            'icon'  => 'custom-banner-setting',
            'fields' => array(
                array(
                    'id'        => 'socialv_enable_profile_forum_tab',
                    'type'      => 'checkbox',
                    'desc'     => esc_html__('Check this option to show the user forums on a profile tab.', 'socialv'),
                    'title' => __('Enable Profile Forum Tab', 'socialv'),
                    'default'   => '1'
                ),
            )
        ));
        
    }
}
