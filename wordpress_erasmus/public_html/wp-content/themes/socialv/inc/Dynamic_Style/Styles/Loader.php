<?php

/**
 * SocialV\Utility\Dynamic_Style\Styles\Loader class
 *
 * @package socialv
 */

namespace SocialV\Utility\Dynamic_Style\Styles;

use SocialV\Utility\Dynamic_Style\Component;
use function add_action;

class Loader extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'socialv_loader_options'), 20);
    }

    public function socialv_loader_options()
    {
        $socialv_options = get_option('socialv-options');
        $loader_var = "";
        if (isset($socialv_options['loader_bg_color'])) {
            $loader_var = $socialv_options['loader_bg_color'];
            if (!empty($loader_var)) {
                $loader_css = "
                    #loading {
                        background : $loader_var !important;
                    }";
            }
        }
        if (!empty($socialv_options["loader-dimensions"]["width"]) && $socialv_options["loader-dimensions"]["width"] != "px") {
            $loader_width = $socialv_options["loader-dimensions"]["width"];
            $loader_css .= '#loading img { width: ' . $loader_width . ' !important; }';
        }

        if (!empty($socialv_options["loader-dimensions"]["height"]) && $socialv_options["loader-dimensions"]["height"] != "px") {
            $loader_height = $socialv_options["loader-dimensions"]["height"];
            $loader_css .= '#loading img { height: ' . $loader_height . ' !important; }';
        }
        if (!empty($loader_css)) {
            wp_add_inline_style('socialv-global', $loader_css);
        }
    }
}
