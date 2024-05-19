<?php

/**
 * SocialV\Utility\Redux_Framework\Options\PMP class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class PMP extends Component
{

    public function __construct()
    {
        $this->set_widget_option();
    }

    protected function set_widget_option()
    {

        Redux::set_section($this->opt_name, array(
            'title' => esc_html__('PMP Settings', 'socialv'),
            'id'    => 'pmp_settings',
			'icon'  => 'custom-product-settings',
            'fields' => array(
                array(
                    'id' => 'is_pmp_cancel_logo',
                    'type' => 'button_set',
                    'title' => esc_html__('Showing Membership Cancel Logo ?', 'socialv'),
                    'options' => array(
                        'yes' => esc_html__('Yes', 'socialv'),
                        'no' => esc_html__('No', 'socialv')
                    ),
                    'default' => esc_html__('yes', 'socialv')
                ),
                array(
                    'id'        => 'pmp_page_default_cancel_logo',
                    'type'      => 'media',
                    'url'       => true,
                    'title'     => esc_html__('Default Logo Image', 'socialv'),
                    'read-only' => false,
                    'subtitle'  => esc_html__('Upload default image for your membership cancel page.', 'socialv'),
                    'required'  => array('is_pmp_cancel_logo', '=', 'yes'),
                    'desc' => '<i class="custom-info"></i><span class="media-label">' . esc_html__(' Upload your cancel logo image', 'socialv') . '</span>',
                ),
            )
        ));

    }
}
