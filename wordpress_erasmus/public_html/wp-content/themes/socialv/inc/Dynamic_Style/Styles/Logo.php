<?php

/**
 * SocialV\Utility\Dynamic_Style\Styles\Logo class
 *
 * @package socialv
 */

namespace SocialV\Utility\Dynamic_Style\Styles;

use SocialV\Utility\Dynamic_Style\Component;
use function add_action;

class Logo extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'socialv_logo_options'), 20);
        add_action('wp_enqueue_scripts', array($this, 'socialv_logo_url'), 20);
    }

    public function socialv_logo_options()
    {
        $socialv_options = get_option('socialv-options');
        $logo_var = $logo = "";
        if (function_exists('get_field') && class_exists('ReduxFramework')) {
            $is_yes = function_exists('get_field') ? get_field('acf_key_logo_switch') : '';
            $acf_logo_text = function_exists('get_field') ? get_field('verticle_header_color') : '';
            if ($is_yes === 'yes' && !empty($acf_logo_text)) {
                $logo = $acf_logo_text;
            } else if (isset($socialv_options['verticle_header_color'])) {
                if (!empty($socialv_options['verticle_header_color'])) {
                    $logo = $socialv_options['verticle_header_color'];
                }
            }
            if (!empty($logo)) {
                $logo_var = ".navbar-brand.socialv-logo .logo-title{
                color : $logo !important;
            }";
            }

            if ($is_yes === 'no') {
                $logo_var .= ".navbar-brand.socialv-logo{
                    display : none !important;
                }";
            }
        }

        if (!empty($socialv_options["logo-dimensions"]["width"]) && $socialv_options["logo-dimensions"]["width"] != "px") {
            $logo_width = $socialv_options["logo-dimensions"]["width"];
            $logo_var .= '.navbar-brand.socialv-logo img { width: ' . $logo_width . ' !important; }.sidebar-mini .navbar-brand.socialv-logo img { width: auto !important; }';
        }

        if (!empty($socialv_options["logo-dimensions"]["height"]) && $socialv_options["logo-dimensions"]["height"] != "px") {
            $logo_height = $socialv_options["logo-dimensions"]["height"];
            $logo_var .= '.navbar-brand.socialv-logo img { height: ' . $logo_height . ' !important; }.sidebar-mini .navbar-brand.socialv-logo img { height: auto !important; }';
        }

        if (!empty($logo_var)) {
            wp_add_inline_style('socialv-global', $logo_var);
        }
    }


    public function socialv_logo_url()
    {
        $socialv_options = get_option('socialv-options');
        $dark_logo = "";
        if (function_exists('get_field') && class_exists('ReduxFramework')) {
            $acf_logo = function_exists('get_field') ? get_field('header_dark_logo') : '';

            if (!empty($acf_logo['url'])) {
                $dark_logo = $acf_logo['url'];
            } else if (isset($socialv_options['socialv_verticle_dark_logo'])) {
                if (!empty($socialv_options['socialv_verticle_dark_logo']['url'])) {
                    $dark_logo = $socialv_options['socialv_verticle_dark_logo']['url'];
                }
            }
        }

        if (!empty($dark_logo)) {
            $logo = '[data-mode=dark] .navbar-brand.socialv-logo img { content: url(' . $dark_logo . ') }';
            wp_add_inline_style('socialv-global', $logo);
        }
    }
}
