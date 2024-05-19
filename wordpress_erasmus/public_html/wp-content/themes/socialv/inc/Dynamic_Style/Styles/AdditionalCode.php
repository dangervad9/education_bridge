<?php

/**
 * SocialV\Utility\Dynamic_Style\Styles\AdditionalCode class
 *
 * @package socialv
 */

namespace SocialV\Utility\Dynamic_Style\Styles;

use SocialV\Utility\Dynamic_Style\Component;
use function add_action;

class AdditionalCode extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'socialv_inline_scripts'), 20);
    }

    public function socialv_inline_scripts()
    {
        $socialv_options = get_option('socialv-options');

        if (!empty($socialv_options['css_code'])) {
            $socialv_css_code = $socialv_options['css_code'];
            wp_add_inline_style('socialv-global', $socialv_css_code);
        }

        if (!empty($socialv_options['js_code'])) {
            $socialv_js_code = $socialv_options['js_code'];
            wp_register_script('socialv-custom-js', '', [], '', true);
            wp_enqueue_script('socialv-custom-js');
            wp_add_inline_script('socialv-custom-js', wp_specialchars_decode($socialv_js_code));
        }
    }
}
