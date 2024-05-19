<?php

/**
 * SocialV\Utility\Dynamic_Style\Styles\Banner class
 *
 * @package socialv
 */

namespace SocialV\Utility\Dynamic_Style\Styles;

use SocialV\Utility\Dynamic_Style\Component;
use function add_action;

class Breadcrumb extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'socialv_breadcrumb_dynamic_style'), 20);
        add_action('wp_enqueue_scripts', array($this, 'socialv_featured_hide'), 20);
        
    }

    public function is_socialv_breadcrumb()
    {
        $is_bredcrumb = true;
        $page_id = (function_exists('is_shop') && is_shop()) ? wc_get_page_id('shop') : get_queried_object_id();
        $global_option = get_option('socialv-options');
        $breadcrumb_page_option = get_post_meta($page_id, 'display_banner', true);
        $breadcrumb_page_option = (!empty($breadcrumb_page_option)) ? $breadcrumb_page_option : "default";

        if ($breadcrumb_page_option != "default") {
            $is_bredcrumb = ($breadcrumb_page_option == 'no') ? false : true;
        } elseif ($global_option['display_banner'] == "no") {
            $is_bredcrumb = false;
        }

        return $is_bredcrumb;
    }
    
    public function socialv_breadcrumb_dynamic_style()
    {
        if (!$this->is_socialv_breadcrumb()) {
            return;
        }
        $dynamic_css = '';
        $socialv_options = get_option('socialv-options');

        if (isset($socialv_options['display_breadcrumb_title'])) {
            if ($socialv_options['display_breadcrumb_title'] == 'yes') {
                $dynamic = $socialv_options['breadcrumb_title_color'];
                $dynamic_css .= !empty($dynamic) ? '.socialv-breadcrumb .title { color: ' . $dynamic . ' !important; }' : '';
            }
        }
        if (isset($socialv_options['breadcrumb_back_type'])) {
            if ($socialv_options['breadcrumb_back_type'] == '1') {
                if (isset($socialv_options['breadcrumb_back_color']) && !empty($socialv_options['breadcrumb_back_color'])) {
                    $dynamic = $socialv_options['breadcrumb_back_color'];
                    $dynamic_css .= !empty($dynamic) ? '.socialv-breadcrumb { background: ' . $dynamic . ' !important; }' : '';
                }
            }
            if ($socialv_options['breadcrumb_back_type'] == '2') {
                if (isset($socialv_options['breadcrumb_back_image']['url'])) {
                    $dynamic = $socialv_options['breadcrumb_back_image']['url'];
                    $dynamic_css .= !empty($dynamic) ? '.socialv-breadcrumb { background-image: url(' . $dynamic . ') !important; }' : '';
                }
            }
        }
        if (!empty($dynamic_css)) {
            wp_add_inline_style('socialv-global', $dynamic_css);
        }
    }

    # hide featured image for post format
    public function socialv_featured_hide()
    {
        $socialv_options = get_option('socialv-options');
        $featured_hide = '';
        $post_format = "";

        if (isset($socialv_options['posts_select'])) {
            $posts_format = $socialv_options['posts_select'];
            $post_format = get_post_format();

            if (isset($posts_format)){
                if (in_array(get_post_format(), $posts_format)) {
                    $featured_hide .= '.socialv-blog-main-list .format-' . $post_format . ' .socialv-blog-box .socialv-blog-image img { display: none !important; }';
                }
            }
            wp_add_inline_style('socialv-global', $featured_hide);
        }
    }

}
