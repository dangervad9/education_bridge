<?php

/**
 * SocialV\Utility\Dynamic_Style\Styles\Banner class
 *
 * @package socialv
 */

namespace SocialV\Utility\Dynamic_Style\Styles;

use SocialV\Utility\Dynamic_Style\Component;
use function add_action;
use function SocialV\Utility\socialv;

class Layout extends Component
{

    public function __construct()
    {
        $this->socialv_layout_mode();
    }

    public function socialv_layout_mode()
    {
        $socialv_options = get_option('socialv-options');
        add_action('wp_footer', array($this, 'socialv_layout_switcher_js'), 15);
        add_action('wp_enqueue_scripts', array($this, 'socialv_layout_js_css'));
        if (isset($socialv_options['socialv_frontside_switcher'])) {
            $options = $socialv_options['socialv_frontside_switcher'];
            if ($options == "yes") {
                add_action('wp_footer', [$this, 'socialv_frontend_customizer']);
            }
        }
        add_action('wp_head', [$this, 'socialv_layout_option_settings']);
    }

    public function socialv_layout_switcher_js()
    {
        wp_enqueue_script('layout-switcher', get_template_directory_uri() . '/assets/js/layout.min.js', array('jquery'), socialv()->get_version(), true);
    }
    
    public function socialv_layout_js_css()
    {
        wp_enqueue_style('layout-switcher', get_template_directory_uri() . '/assets/css/layout.min.css', array(), socialv()->get_version(), 'all');
        wp_enqueue_script('utility', get_template_directory_uri() . '/assets/js/vendor/utility.js', array('jquery'), socialv()->get_version(), true);
        wp_enqueue_script('setting', get_template_directory_uri() . '/assets/js/vendor/setting.js', array('jquery'), socialv()->get_version(), true);
        $color_var = '';
        $setting_options =  json_decode((get_option('setting_options')), true);
        if (isset($_COOKIE['socialv-setting']) && !empty($_COOKIE['socialv-setting'])) {
            $color = json_decode(stripslashes($_COOKIE['socialv-setting']), true);
            $color = $color['setting']['theme_color']['colors']['--{{prefix}}primary'];
        } else {
            if (!empty($setting_options['setting']['theme_color']['colors']['--{{prefix}}primary'])) {
                $color = $setting_options['setting']['theme_color']['colors']['--{{prefix}}primary'];
            }
        }
        if (!empty($color)) {
            $color_var .= '--color-theme-primary: ' . $color . ';';
            $color_var .= '--color-theme-primary-dark: ' . $color . '0c;';
            $color_var .= '--color-theme-primary-light: ' . $color . 'ff;';
            if (!empty($color_var)) {
                $color_var = ":root{" . $color_var . "}";
                wp_add_inline_style('layout-switcher', $color_var);
            }
        }
    }

    public function socialv_frontend_customizer()
    {
        $socialv_options = get_option('socialv-options');
        $page_id = get_queried_object_id();
        $nonrestricted = (!empty($socialv_options['customizer_non_selected_page'])) ? $socialv_options['customizer_non_selected_page'] : '';
        if (!empty($nonrestricted) && in_array($page_id, $nonrestricted)) {
        } else {
            get_template_part('template-parts/footer/frontend-customizer');
        }
    }

    function socialv_layout_option_settings()
    {
        $version = socialv()->get_version();
        $path = get_template_directory_uri() . '/assets/css/';
        $setting_options = '{
    "saveLocal": "cookieStorage",
    "storeKey": "socialv-setting",
    "setting": {
        "theme_scheme_direction": {
            "value": "ltr"
        },
        "theme_color": {
            "colors": {
                "--{{prefix}}primary": "#2f65b9"
            },
            "value": "theme-color-default"
        },
        "header_navbar": {
            "value": "default"
        },
        "sidebar_color": {
            "value": "sidebar-white"
        },
        "sidebar_type": {
            "value": []
        },
        "sidebar_menu_style": {
            "value": "navs-rounded-all"
        },
        "theme_scheme": {
            "value": "light"
        }
    },
    "theme_scheme_direction": "ltr",
    "theme_color": "theme-color-default",
    "header_navbar": "default",
    "sidebar_color": "sidebar-white",
    "sidebar_type": {},
    "sidebar_menu_style": "navs-rounded-all",
    "theme_scheme": "light"
}';

        if (isset($_POST['setting_options'])) {
            $setting_options = stripslashes($_POST['setting_options']);
            update_option('setting_options', $setting_options);
        } elseif (get_option('setting_options') === false) {
            add_option('setting_options', stripslashes($setting_options));
        } else {
            $setting_options = (get_option('setting_options') == null) ? stripslashes($setting_options) : get_option('setting_options');
        }
        echo "<meta name='setting_options' content='$setting_options' data-version='$version' data-path='$path'></meta>";
    }
}
