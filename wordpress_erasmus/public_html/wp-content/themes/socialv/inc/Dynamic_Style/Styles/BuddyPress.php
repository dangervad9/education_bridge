<?php

/**
 * SocialV\Utility\Dynamic_Style\Styles\BuddyPress class
 *
 * @package socialv
 */

namespace SocialV\Utility\Dynamic_Style\Styles;

use SocialV\Utility\Dynamic_Style\Component;
use function add_action;

class BuddyPress extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'socialv_banner_dynamic_style'), 20);
    }

    public function is_socialv_banner()
    {
        $is_bredcrumb = true;
        $global_option = get_option('socialv-options');
        if (isset($global_option['bp_display_banner']) && $global_option['bp_display_banner'] == "no") {
            $is_bredcrumb = false;
        }
        return $is_bredcrumb;
    }
    
    public function socialv_banner_dynamic_style()
    {
        if (!$this->is_socialv_banner()) {
            return;
        }
        $dynamic_css = '';
        $socialv_options = get_option('socialv-options');

        if (isset($socialv_options['bp_display_banner_title'])) {
            if ($socialv_options['bp_display_banner_title'] == 'yes') {
                $dynamic = $socialv_options['bp_banner_title_color'];
                $dynamic_css .= !empty($dynamic) ? '.socialv-bp-banner .socialv-bp-banner-title .title { color: ' . $dynamic . ' !important; }' : '';
            }
        }
        
        if (!empty($socialv_options['bp_page_default_banner_image']['url'])) {
            $bnurl = $socialv_options['bp_page_default_banner_image']['url'];                
            $dynamic_css .= '.socialv-bp-banner { background: url(' . $bnurl . ') !important; }';

        }
        if (!empty($dynamic_css)) {
            wp_add_inline_style('socialv-global', $dynamic_css);
        }
    }


}
