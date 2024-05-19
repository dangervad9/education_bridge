<?php

/**
 * SocialV\Utility\Dynamic_Style\Styles\Banner class
 *
 * @package socialv
 */

namespace SocialV\Utility\Dynamic_Style\Styles;

use SocialV\Utility\Dynamic_Style\Component;
use function add_action;

class Typography extends Component
{

    public function __construct()
    {
        if (class_exists("ReduxFramework")) {
            add_action('wp_enqueue_scripts', array($this, 'socialv_fontstyle_dynamic_style'), 20);
        }
    }

    public function socialv_fontstyle_dynamic_style()
    {

        $socialv_options = get_option('socialv-options');
        $font_dynamic_css = '';

        // Change font 1
        if (isset($socialv_options['change_font']) && $socialv_options['change_font'] == 1) {
            // body
            if (isset($socialv_options["body_font"]["font-family"])) {
                $body_family = $socialv_options["body_font"]["font-family"];
            }
            if (isset($socialv_options["body_font"]["font-backup"])) {
                $body_backup = $socialv_options["body_font"]["font-backup"];
            }
            $font_dynamic_css .= (!empty($body_family) && !empty($body_backup)) ? 'body { font-family: ' . $body_family .','.  $body_backup . ' !important; }' : '';

            if (!empty($socialv_options["body_font"]["font-size"])) {
                $body_size = $socialv_options["body_font"]["font-size"];
                $font_dynamic_css .= 'body { font-size: ' . $body_size . ' !important; }';
            }

            if (!empty($socialv_options["body_font"]["font-weight"])) {
                $body_weight = $socialv_options["body_font"]["font-weight"];
                $font_dynamic_css .= 'body { font-weight: ' . $body_weight . ' !important; }';
            }

            if (!empty($socialv_options["h1_font"]["font-family"])) {
                $h1_family = $socialv_options["h1_font"]["font-family"];
                $font_dynamic_css .= 'h1 { font-family: ' . $h1_family . ' !important; }';
            }
            if (!empty($socialv_options["h1_font"]["font-size"])) {
                $h1_size = $socialv_options["h1_font"]["font-size"];
                $font_dynamic_css .= 'h1 { font-size: ' . $h1_size . ' !important; }';
            }
            if (!empty($socialv_options["h1_font"]["font-weight"])) {
                $h1_weight = $socialv_options["h1_font"]["font-weight"];
                $font_dynamic_css .= 'h1 { font-weight: ' . $h1_weight . ' !important; }';
            }

            if (!empty($socialv_options["h2_font"]["font-family"])) {
                $h2_family = $socialv_options["h2_font"]["font-family"];
                $font_dynamic_css .= 'h2 { font-family: ' . $h2_family . ' !important; }';
            }
            if (!empty($socialv_options["h2_font"]["font-size"])) {
                $h2_size = $socialv_options["h2_font"]["font-size"];
                $font_dynamic_css .= 'h2 { font-size: ' . $h2_size . ' !important; }';
            }
            if (!empty($socialv_options["h2_font"]["font-weight"])) {
                $h2_weight = $socialv_options["h2_font"]["font-weight"];
                $font_dynamic_css .= 'h2 { font-weight: ' . $h2_weight . ' !important; }';
            }

            if (!empty($socialv_options["h3_font"]["font-family"])) {
                $h3_family = $socialv_options["h3_font"]["font-family"];
                $font_dynamic_css .= 'h3 { font-family: ' . $h3_family . ' !important; }';
            }
            if (!empty($socialv_options["h3_font"]["font-size"])) {
                $h3_size = $socialv_options["h3_font"]["font-size"];
                $font_dynamic_css .= 'h3 { font-size: ' . $h3_size . ' !important; }';
            }
            if (!empty($socialv_options["h3_font"]["font-weight"])) {
                $h3_weight = $socialv_options["h3_font"]["font-weight"];
                $font_dynamic_css .= 'h3 { font-weight: ' . $h3_weight . ' !important; }';
            }

            if (!empty($socialv_options["h4_font"]["font-family"])) {
                $h4_family = $socialv_options["h4_font"]["font-family"];
                $font_dynamic_css .= 'h4 { font-family: ' . $h4_family . ' !important; }';
            }
            if (!empty($socialv_options["h4_font"]["font-size"])) {
                $h4_size = $socialv_options["h4_font"]["font-size"];
                $font_dynamic_css .= 'h4 { font-size: ' . $h4_size . ' !important; }';
            }
            if (!empty($socialv_options["h4_font"]["font-weight"])) {
                $h4_weight = $socialv_options["h4_font"]["font-weight"];
                $font_dynamic_css .= 'h4 { font-weight: ' . $h4_weight . ' !important; }';
            }

            if (!empty($socialv_options["h5_font"]["font-family"])) {
                $h5_family = $socialv_options["h5_font"]["font-family"];
                $font_dynamic_css .= 'h5 { font-family: ' . $h5_family . ' !important; }';
            }
            if (!empty($socialv_options["h5_font"]["font-size"])) {
                $h5_size = $socialv_options["h5_font"]["font-size"];
                $font_dynamic_css .= 'h5 { font-size: ' . $h5_size . ' !important; }';
            }
            if (!empty($socialv_options["h5_font"]["font-weight"])) {
                $h5_weight = $socialv_options["h5_font"]["font-weight"];
                $font_dynamic_css .= 'h5 { font-weight: ' . $h5_weight . ' !important; }';
            }

            if (!empty($socialv_options["h6_font"]["font-family"])) {
                $h6_family = $socialv_options["h6_font"]["font-family"];
                $font_dynamic_css .= 'h6 { font-family: ' . $h6_family . ' !important; }';
            }
            if (!empty($socialv_options["h6_font"]["font-size"])) {
                $h6_size = $socialv_options["h6_font"]["font-size"];
                $font_dynamic_css .= 'h6 { font-size: ' . $h6_size . ' !important; }';
            }
            if (!empty($socialv_options["h6_font"]["font-weight"])) {
                $h6_weight = $socialv_options["h6_font"]["font-weight"];
                $font_dynamic_css .= 'h6 { font-weight: ' . $h6_weight . ' !important; }';
            }
        }
        if (!empty($font_dynamic_css)) {
            wp_add_inline_style('socialv-global', $font_dynamic_css);
        }
    }
}
