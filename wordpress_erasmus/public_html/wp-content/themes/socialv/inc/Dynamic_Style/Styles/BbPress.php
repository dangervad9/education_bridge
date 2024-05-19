<?php

/**
 * SocialV\Utility\Dynamic_Style\Styles\BbPress class
 *
 * @package socialv
 */

namespace SocialV\Utility\Dynamic_Style\Styles;

use SocialV\Utility\Dynamic_Style\Component;
use function add_action;

class BbPress extends Component
{
    public $socialv_option;

    public function __construct()
    {
        $this->socialv_option = get_option('socialv-options');
        if ($this->socialv_option['socialv_enable_profile_forum_tab'] == '1') {
            add_action('wp_enqueue_scripts', array($this, 'socialv_bbpress_profile_tab'), 20);
        }
    }

    public function socialv_bbpress_profile_tab()
    {
        $dynamic_css = '#forums-personal-li {display:none !important;}';
        if (!empty($dynamic_css)) {
            wp_add_inline_style('socialv-global', $dynamic_css);
        }
    }
}
