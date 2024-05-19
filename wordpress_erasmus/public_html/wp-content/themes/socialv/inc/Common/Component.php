<?php

/**
 * SocialV\Utility\Comments\Component class
 *
 * @package socialv
 */

namespace SocialV\Utility\Common;

use phpDocumentor\Reflection\Types\Object_;
use SocialV\Utility\Component_Interface;
use SocialV\Utility\Dynamic_Style\Styles\Footer;
use SocialV\Utility\Dynamic_Style\Styles\Header;
use SocialV\Utility\Templating_Component_Interface;
use function add_action;
use function SocialV\Utility\socialv;

/**
 * Class for managing comments UI.
 *
 * Exposes template tags:
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface, Templating_Component_Interface
{

    /**
     * Gets the unique identifier for the theme component.
     *
     * @return string Component slug.
     */
    public function get_slug(): string
    {
        return 'common';
    }

    /**
     * Adds the action and filter hooks to integrate with WordPress.
     */
    public function initialize()
    {
        add_filter('widget_tag_cloud_args', array($this, 'socialv_widget_tag_cloud_args'), 100);
        add_filter('wp_list_categories', array($this, 'socialv_categories_postcount_filter'), 100);
        add_filter('get_archives_link', array($this, 'socialv_style_the_archive_count'), 100);
        add_filter('upload_mimes', array($this, 'socialv_mime_types'), 100);
        add_action('wp_enqueue_scripts', array($this, 'socialv_remove_wp_block_library_css'), 100);
        add_filter('pre_get_posts', array($this, 'socialv_searchfilter'), 100);
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'audio',
        ));
        /* Disable WordPress Admin Bar for all users */
        if (!is_super_admin()) {
            add_filter('show_admin_bar', '__return_false');
        }
        if (!is_admin()) {
            add_filter('language_attributes', [$this, 'socialv_html_lang_attribute']);
        }
    }

    public function __construct()
    {
        add_filter('the_content', array($this, 'socialv_remove_empty_p'));
        add_filter('get_the_content', array($this, 'socialv_remove_empty_p'));
        add_filter('get_the_excerpt', array($this, 'socialv_remove_empty_p'));
        add_filter('the_excerpt', array($this, 'socialv_remove_empty_p'));
        add_filter('body_class', array($this, 'socialv_add_body_classes'));
    }

    /**
     * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `socialv()`.
     *
     * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
     *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
     *               adding support for further arguments in the future.
     */
    public function template_tags(): array
    {
        return array(
            'socialv_ajax_load_scripts' => [$this, 'socialv_ajax_load_scripts'],
            'socialv_pagination' => array($this, 'socialv_pagination'),
            'socialv_get_embed_video' => array($this, 'socialv_get_embed_video'),
            'socialv_the_layout_class' => array($this, 'socialv_the_layout_class'),
            'socialv_sidebar' => array($this, 'socialv_sidebar'),
            'socialv_logo' => array($this, 'socialv_logo'),
            'socialv_layout_mode_add_attr' => array($this, 'socialv_layout_mode_add_attr'),
            'socialv_switch' => array($this, 'socialv_switch'),
            'socialv_skeleton_animation' => array($this, 'socialv_skeleton_animation'),
            'is_socialv_default_header' => array($this, 'is_socialv_default_header'),
        );
    }

    public function socialv_ajax_load_scripts()
    {
        global $wp_query;
        wp_register_script('socialv_ajax_posts_load', false);
        wp_localize_script('socialv_ajax_posts_load', 'socialv_loadmore_params', array(
            'ajaxurl' => admin_url('admin-ajax.php'), // WordPress AJAX
            'posts' => json_encode($wp_query->query_vars), // everything about your loop is here
            'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
            'max_page' => $wp_query->max_num_pages,
            'alert_media' => esc_html__('Are you sure you want to delete?', 'socialv'),
        ));
        wp_enqueue_script('socialv_ajax_posts_load');
    }

    function socialv_add_body_classes($classes)
    {
        $is_header = $is_footer = $is_default_header = true;
        $socialv_options = get_option('socialv-options');

        if (isset($socialv_options['display_full_logo']) && $socialv_options['display_full_logo'] == 1) {
            $classes = array_merge($classes, array('socialv-full-logo'));
        }

        if (function_exists("get_field")) {
            $header = new Header();
            $is_header = $header->is_socialv_header();
        }
        if (function_exists("get_field")) {
            $footer = new Footer();
            $is_footer = $footer->is_socialv_footer();
        }
        if ($is_header) {
            if (class_exists('LearnPress')) {
                $classes = array_merge($classes, array('socialv-learnpress'));
            }
            $classes = array_merge($classes, array('socialv-default-header'));
        }
        if ($is_footer == false) {
            $classes = array_merge($classes, array('socialv-footer-hide'));
        }
        return $classes;
    }

    function is_socialv_default_header()
    {
        $socialv_options = get_option('socialv-options');
        $is_default_header = true;
        $id = (function_exists('is_shop') && is_shop()) ? wc_get_page_id('shop') : get_queried_object_id();
        $header_name = !empty($id) ? get_post_meta($id, 'header_layout_name', true) : '';
        $header_page_option = get_post_meta($id, "display_header", true);
        if ($header_page_option === 'default') {
            $is_default_header = false;
        } else if ($header_name === '2') {
            $is_default_header = false;
        } else if ($header_name === '1') {
            $is_default_header = true;
        } else if (isset($socialv_options['header_layout']) && $socialv_options['header_layout'] == '2') {
            $is_default_header = false;
        }
        return $is_default_header;
    }

    function socialv_get_embed_video($post_id)
    {
        $post = get_post($post_id);
        $content = do_shortcode(apply_filters('the_content', $post->post_content));
        $embeds = get_media_embedded_in_content($content);
        if (!empty($embeds)) {
            foreach ($embeds as $embed) {
                if (strpos($embed, 'video') || strpos($embed, 'youtube') || strpos($embed, 'vimeo') || strpos($embed, 'dailymotion') || strpos($embed, 'vine') || strpos($embed, 'wordPress.tv') || strpos($embed, 'embed') || strpos($embed, 'audio') || strpos($embed, 'iframe') || strpos($embed, 'object')) {
                    return $embed;
                }
            }
        } else {
            return;
        }
    }

    function socialv_remove_empty_p($string)
    {
        return preg_replace('/<p>(?:\s|&nbsp;)*?<\/p>/i', '', $string);
    }

    function socialv_remove_wp_block_library_css()
    {
        wp_dequeue_style('wp-block-library-theme');
    }

    public function socialv_widget_tag_cloud_args($args)
    {
        $args['largest'] = 1;
        $args['smallest'] = 1;
        $args['unit'] = 'em';
        $args['format'] = 'list';

        return $args;
    }

    function socialv_mime_types($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    function socialv_categories_postcount_filter($variable)
    {
        $variable = str_replace('(', '<span class="archiveCount"> (', $variable);
        $variable = str_replace(')', ') </span>', $variable);
        return $variable;
    }

    function socialv_style_the_archive_count($links)
    {
        $links = str_replace('</a>&nbsp;(', '</a> <span class="archiveCount"> (', $links);
        $links = str_replace('&nbsp;)</li>', ' </li></span>', $links);
        return $links;
    }

    public function socialv_pagination($numpages = '', $pagerange = '', $paged = '')
    {
        global $paged;
        if (empty($pagerange)) {
            $pagerange = 2;
        }
        if (empty($paged)) {
            $paged = 1;
        }
        if ($numpages == '') {
            global $wp_query;
            $numpages = $wp_query->max_num_pages;
            if (!$numpages) {
                $numpages = 1;
            }
        }
        /**
         * We construct the pagination arguments to enter into our paginate_links
         * function.
         */
        $pagination_args = array(
            'format' => '?paged=%#%',
            'total' => $numpages,
            'current' => $paged,
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => $pagerange,
            'prev_next' => true,
            'prev_text' => '<i class="iconly-Arrow-Left-2 icli"></i>',
            'next_text' => '<i class="iconly-Arrow-Right-2 icli"></i>',
            'type' => 'list',
            'add_args' => false,
            'add_fragment' => ''
        );

        $paginate_links = paginate_links($pagination_args);
        if ($paginate_links) {
            echo '<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="pagination justify-content-center">
								<nav aria-label="Page navigation">';
            printf(esc_html__('%s', 'socialv'), $paginate_links);
            echo '</nav>
					</div>
				</div>';
        }
    }

    function socialv_searchfilter($query)
    {
        if (!is_admin()) {
            if ($query->is_search) {
                if (class_exists('BuddyPress') && is_buddypress() || class_exists('bbPress') && is_bbpress() || class_exists('LearnPress')) {
                } else {
                    $query->set('post_type', 'post');
                }
            }
            return $query;
        }
    }

    function socialv_logo()
    {
        $socialv_options = get_option('socialv-options');
        if (function_exists('get_field') || class_exists('ReduxFramework')) {
            $socialv_options = get_option('socialv-options');
            $is_yes = function_exists('get_field') ? get_field('acf_key_logo_switch') : '';
            $acf_logo = function_exists('get_field') ? get_field('header_logo') : '';
            $acf_logo_text = function_exists('get_field') ? get_field('verticle_header_text') : '';

            if ($is_yes === 'yes' && !empty($acf_logo['url'])) {
                $options = $acf_logo['url'];
                $alt_text = isset($acf_logo['alt']) ? $acf_logo['alt'] : 'socialv';
            } else if (isset($socialv_options['socialv_verticle_logo'])) {
                if (!empty($socialv_options['socialv_verticle_logo']['url'])) {
                    $options = $socialv_options['socialv_verticle_logo']['url'];
                    $id = (!empty($socialv_options['socialv_verticle_logo']['id']) ? $socialv_options['socialv_verticle_logo']['id'] : 'socialv');
                    $alt_text = get_post_meta($id, '_wp_attachment_image_alt', true);
                }
            }
            $alt = (!empty($alt_text)) ? $alt_text : '';
            if ($is_yes === 'yes' && !empty($acf_logo_text)) {
                $logo_text = $acf_logo_text;
            } else if (isset($socialv_options['verticle_header_text'])) {
                if (!empty($socialv_options['verticle_header_text'])) {
                    $logo_text = $socialv_options['verticle_header_text'];
                }
            }
        }
?>
        <a class="navbar-brand socialv-logo <?php echo esc_attr(isset($socialv_options['logo_position']) && $socialv_options['logo_position'] == 'yes') ? 'logo-align-left' : ''; ?> " href="<?php echo esc_url(home_url('/')); ?>">
            <?php
            if (!empty($logo_text)) {
                echo '<h4 class="logo-title">' . esc_html($logo_text) . '</h4>';
            }
            ?>
            <div class="logo-main">
                <?php
                if (isset($options) && !empty($options)) {
                    echo '<div class="logo-normal"><img class="img-fluid logo" loading="lazy" src="' . esc_url($options) . '" alt="' . esc_attr__($alt, 'socialv') . '"></div>';
                } else {
                    $logo_url = get_template_directory_uri() . '/assets/images/logo-mini.svg';
                    echo '<div class="logo-normal"><img class="img-fluid logo" loading="lazy" src="' . esc_url($logo_url) . '" alt="' . esc_attr__('socialv', 'socialv') . '"></div>';
                }
                ?>
            </div>
        </a>
    <?php
    }

    function socialv_sidebar_option()
    {
        $socialv_options = get_option('socialv-options');
        $socialv_layout = '';
        if (class_exists('ReduxFramework')) {
            if (is_search()) {
                $socialv_layout = $socialv_options['search_page'];
            } else if (class_exists('BuddyPress') && is_buddypress() || class_exists('bbPress') && is_bbpress()) {
                $socialv_layout = $socialv_options['bp_page'];
            } else if (class_exists('LearnPress') && is_post_type_archive('lp_course') || is_tax('course_category')) {
                $socialv_layout = $socialv_options['lp_page'];
            } else {
                $socialv_layout = is_single() ? $socialv_options['blog_single_page_setting'] : $socialv_options['blog_setting'];
            }
        }
        return $socialv_layout;
    }

    //Sidebar 
    function socialv_the_layout_class()
    {
        $is_sidebar = socialv()->is_primary_sidebar_active();
        $socialv_layout = $this->socialv_sidebar_option();
        if ($is_sidebar) {
            if (class_exists('LearnPress') && is_post_type_archive('lp_course') || is_tax('course_category')) {
                echo '<div class="col-xl-9 col-sm-12 socialv-blog-main-list">';
            } else {
                echo '<div class="col-xl-8 col-sm-12 socialv-blog-main-list">';
            }
        } else if ($socialv_layout != '2' && $socialv_layout != '3') {
            echo '<div class="col-lg-12 col-sm-12 socialv-blog-main-list">';
        }
    }

    function socialv_sidebar()
    {
        $is_sidebar = socialv()->is_primary_sidebar_active();
        $socialv_layout = $this->socialv_sidebar_option();
        if ($is_sidebar || $socialv_layout != '2' && $socialv_layout != '3') {
            echo '</div>';
        }
        get_sidebar();
    }

    function socialv_layout_mode_add_attr()
    {
        $layout_attr = '';
        if (isset($_COOKIE['socialv-setting'])) {
            $socialv_user_setting = json_decode(stripslashes($_COOKIE['socialv-setting']));
            $socialv_user_setting->setting->theme_scheme_direction->value;
            $layout_attr .= 'dir=';
            $layout_attr .= isset($socialv_user_setting->setting->theme_scheme_direction->value) ? $socialv_user_setting->setting->theme_scheme_direction->value . ' ' : 'rtl ';
        }

        $socialv_options = get_option('socialv-options');
        if (isset($_COOKIE['data-mode']) && !empty($_COOKIE['data-mode'])) {
            $layout_attr .= 'data-mode=' . $_COOKIE["data-mode"] . ' ';
        } else {
            $layout_attr .= ((class_exists('ReduxFramework') && (!empty($socialv_options['socialv_layout_mode_options']))) ? ('data-mode=' . $socialv_options['socialv_layout_mode_options']) : ' ');
        }
        return esc_attr($layout_attr);
    }

    function socialv_switch()
    {
    ?> <li class="inline-item header-notification-icon switch-mode-icon p-0">
            <div class="switch-mode">
                <button class="socialv-switch-mode" <?php echo esc_attr($this->socialv_layout_mode_add_attr()); ?>><i class="color-mode icon-moon-icon"></i></button>
            </div>
        </li>
<?php
    }

    function socialv_html_lang_attribute($output)
    {
        $output = '';
        $language = get_locale();
        return $output . ' lang="' . esc_attr($language) . '"';
    }

    function socialv_skeleton_animation()
    {
        echo '<div class="socialv-sub-product product type-product skeleton-main skeleton-grid column-3">
		<div class="socialv-inner-box">
			<a href="#"></a>
			<div class="skeleton skt-img">
			</div>
			<div class="skeleton-box">
				<span class="skeleton skt-title mb-4"></span>
				<span class="skeleton skt-price mb-4"></span>
				<span class="skeleton skt-rating"></span>
			</div>
		</div>
	</div>
	<div class="socialv-sub-product product type-product skeleton-main skeleton-grid column-3">
		<div class="socialv-inner-box">
			<a href="#"></a>
			<div class="skeleton skt-img">
			</div>
			<div class="skeleton-box">
				<span class="skeleton skt-title mb-4"></span>
				<span class="skeleton skt-price mb-4"></span>
				<span class="skeleton skt-rating"></span>
			</div>
		</div>
	</div>
	<div class="socialv-sub-product product type-product skeleton-main skeleton-grid column-3">
		<div class="socialv-inner-box">
			<a href="#"></a>
			<div class="skeleton skt-img">
			</div>
			<div class="skeleton-box">
				<span class="skeleton skt-title mb-4"></span>
				<span class="skeleton skt-price mb-4"></span>
				<span class="skeleton skt-rating"></span>
			</div>
		</div>
	</div>';
    }
}
