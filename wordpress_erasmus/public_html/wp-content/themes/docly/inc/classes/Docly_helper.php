<?php
/**
 * Docly theme helper functions and resources
 */

class Docly_Helper_Class {
    /**
	 * Hold an instance of Docly_Helper_Class class.
	 * @var Docly_Helper_Class
	 */
	protected static $instance = null;

	/**
	 * Main Docly_Helper_Class instance.
	 * @return Docly_Helper_Class - Main instance.
	 */
	public static function instance() {

		if (null == self::$instance) {
			self::$instance = new Docly_Helper_Class();
		}

		return self::$instance;
	}

    /**
     * Website Logo
     */
    public function logo() {
        $opt = get_option( 'docly_opt' );
        $use_sticky_logo = function_exists('get_field') ? get_Field('use_sticky_logo') : '';
        if ( is_post_type_archive( array('forum', 'topic') ) ) {
            $use_sticky_logo = '';
        }

        // Main Logo
        $main_logo = $opt['main_logo'] ['url'] ?? '';
        $retina_logo = !empty($opt['retina_logo']['url']) ? "srcset='{$opt['retina_logo']['url']} 2x'" : '';

        // Sticky Logo
        $sticky_logo = $opt['sticky_logo']['url'] ?? '';
        $retina_sticky_logo = !empty($opt['retina_sticky_logo']['url']) ? "srcset='{$opt['retina_sticky_logo']['url']} 2x'" : '';

        $is_bbp_profile = false;
        if ( class_exists('bbPress') ) {
            $is_bbp_profile =  bbp_is_single_user() ? true : false;
        }

        if ( is_singular('post') || is_singular('faq') || $is_bbp_profile || is_singular('onepage-docs') ) {
            $main_logo = $sticky_logo;
            $retina_logo = $retina_sticky_logo;
            // Sticky Logo
            $sticky_logo = $main_logo;
            $retina_sticky_logo = $retina_logo;
        }
        if ( $use_sticky_logo == '1' || docly_is_titlebar() ) {
            $main_logo = $sticky_logo;
            $retina_logo = $retina_sticky_logo;
        }

        ?>
        <a class="navbar-brand logo sticky_logo" href="<?php echo esc_url(home_url('/')); ?>">
            <?php
            if ( !empty($main_logo) ) : ?>
                <img src="<?php echo esc_url($main_logo) ?>" alt="<?php bloginfo('name'); ?>" <?php echo wp_kses_post($retina_logo) ?>>
                <?php if ( !empty($sticky_logo) ) : ?>
                    <img src="<?php echo esc_url($sticky_logo) ?>" alt="<?php bloginfo('name'); ?>" <?php echo wp_kses_post($retina_sticky_logo) ?>>
                <?php endif; ?>
                <?php
            else: ?>
                <h3> <?php echo get_bloginfo( 'name' ) ?> </h3>
                <?php
            endif;
        echo '</a>';
    }

    /**
    * @param $color
    * @param false $opacity
    * Convert hexdec color string to rgb(a) string
    * @return string
    */
    function hex2rgba($color, $opacity = false) {

	    $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if(empty($color))
              return $default;

        //Sanitize $color if "#" is provided
            if ($color[0] == '#' ) {
                $color = substr( $color, 1 );
            }

            //Check if color has 6 or 3 characters and get values
            if (strlen($color) == 6) {
                    $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                    $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                    return $default;
            }

            //Convert hexadec to rgb
            $rgb =  array_map('hexdec', $hex);

            //Check if opacity is set(rgba or rgb)
            if($opacity){
                if(abs($opacity) > 1)
                    $opacity = 1.0;
                $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
            } else {
                $output = 'rgb('.implode(",",$rgb).')';
            }

            //Return rgb(a) color string
            return $output;
    }

    // Banner Title
    function banner_title() {
        $opt = get_option('docly_opt');
        if ( is_home() ) {
            $title = !empty($opt['blog_title']) ? $opt['blog_title'] : esc_html__( 'Blog', 'docly' );
        } elseif ( is_page() || is_single() ) {
            $title = get_the_title();
        } elseif( is_category() ) {
            $title = single_cat_title();
        } elseif( is_archive() ) {
            $title = get_the_archive_title();
            if ( class_exists( 'WooCommerce') ) {
                if ( is_shop() ) {
                    $title = !empty($opt['shop_title']) ? esc_html($opt['shop_title']) : esc_html__( 'Shop', 'docly' );
                }
            }
        } elseif( is_search() ) {
            $title = esc_html__( 'Search result for: “', 'docly' ) . get_search_query().'”';
        } else {
            $title = get_the_title();
        }
        echo wp_kses_post($title);
    }

    // Banner Subtitle
    function banner_subtitle() {
        $opt = get_option('docly_opt');
        if ( class_exists( 'WooCommerce') ) {
            if ( is_shop() ) {
                $subtitle = !empty($opt['shop_subtitle']) ? esc_html($opt['shop_subtitle']) : '';
            } else {
                $subtitle = has_excerpt() ? wpautop(get_the_excerpt()) : '';
            }
        } else {
            $subtitle = has_excerpt() ? wpautop(get_the_excerpt()) : '';
        }
        if ( is_author() ) {
            $subtitle = get_the_author_meta('description');
        }
        echo wp_kses_post($subtitle);
    }

    /**
     * Social Links
     **/
    function social_links() {
        $opt = get_option( 'docly_opt' );
        ?>
        <?php if ( !empty($opt['facebook']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['facebook']); ?>"><i class="social_facebook" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['twitter']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['twitter']); ?>"><i class="social_twitter" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['instagram']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['instagram']); ?>"><i class="social_instagram" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['linkedin']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['linkedin']); ?>"><i class="social_linkedin" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['youtube']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['youtube']); ?>"><i class="social_youtube" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['github']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['github']); ?>"><i class="fab fa-github-alt" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['dribbble']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['dribbble']); ?>"><i class="social_dribbble" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['vk']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['vk']); ?>"><i class="fab fa-vk" aria-hidden="true"></i></a> </li>
        <?php }
    }

    /** Render Meta CSS value
    * @param $handle
    * @param $css_items
    */
     function meta_css_render( $handle, $css_items ) {
         $dynamic_css = '';
         $opt = get_option( 'docly_opt' );

         if ( function_exists('get_field') ) {
             $keys = array_keys($css_items);
             for ( $i = 0; $i < count($css_items); $i++ ) {
                 $split_id = explode('__', $keys[$i]);
                 $meta_id = $split_id[0];
                 $append = !empty($split_id[1]) ? $split_id[1] : '';
                 $meta_value = get_field($meta_id).$append;
                 if ( !empty($meta_value) ) {
                     $css_i = 1;
                     foreach ( $css_items[$keys[$i]] as $property => $selector ) {
                         /*if ( strpos($property, '{{VALUE}}') == true ) {
                             $css_value = str_replace('{{VALUE}}', $meta_value, $property);
                         }*/
                         $css_output = "$selector {";
                         $css_output .= "$property: $meta_value !important;";
                         $css_output .= "}";
                         $dynamic_css .= $css_output;
                         $css_i++;
                     }
                 }
             }
         }

         if ( !empty($opt['custom_css']) ) {
    	    $dynamic_css .= $opt['custom_css'];
        }

        if ( !empty($opt['search_banner_bg_color']['from']) ) {
            $dynamic_css .= ".breadcrumb_area { background-image: linear-gradient(60deg, {$opt['search_banner_bg_color']['from']} 0%, {$opt['search_banner_bg_color']['to']} 100%); }";
        }

        if ( !empty($opt['accent_solid_color_opt']) ) {
            // Shadow blur spread color
            $hover_box_shadow = $this->hex2rgba($opt['accent_solid_color_opt'], 0.24);
            $dynamic_css .= ".blog_comment_box .get_quote_form .thm_btn:hover, .bbp-submit-wrapper #user-submit:hover, #new-post #bbp_reply_submit:hover, #new-post button#bbp_topic_submit:hover{box-shadow: 0 20px 30px 0 $hover_box_shadow !important;}";

            // Border color
            $btn_border_color = $this->hex2rgba($opt['accent_solid_color_opt'], 0.3);
            $dynamic_css .= "
                .doc_border_btn, .doc_tag .nav-item .nav-link, .navbar_fixed.menu_one .nav_btn,
                .woocommerce div.product div.images .flex-control-thumbs li img.flex-active, .woocommerce div.product div.images .flex-control-thumbs li img:hover,
                .nav_btn_two, .menu_two .nav_btn, .f_social_icon li a, .pagination .page-numbers {border-color: $btn_border_color !important;}";

            // Link bottom color
            $link_btm_color = $this->hex2rgba($opt['accent_solid_color_opt'], 0.25);
            $dynamic_css .= ".onepage-doc-sec p a::after, .doc-main-content p a::after, .card-body a::after, .blog_single_item p a::after {background-color: $link_btm_color !important;}";

            // Link bottom color on hover
            $link_btm_color_hover = Docly_helper()->hex2rgba($opt['accent_solid_color_opt'], 0.75);
            $dynamic_css .= ".onepage-doc-sec p a:hover::after, .doc-main-content p a:hover::after, .card-body a:hover::after, .blog_single_item p a:hover::after {background-color: $link_btm_color_hover !important;}";

            // Alpha Background color
            $alpha_8_bg = $this->hex2rgba($opt['accent_solid_color_opt'], 0.8);
            $alpha_5_bg = $this->hex2rgba($opt['accent_solid_color_opt'], 0.5);
            $dynamic_css .= ".action-button-container.action-btns .bbp-topic-reply-link:hover{background: $alpha_8_bg !important;}";
            $dynamic_css .= ".widget_price_filter .ui-slider .ui-slider-range, .widget_price_filter .price_slider_wrapper .ui-slider .ui-slider-range{background: $alpha_5_bg !important;}";
        }

        wp_add_inline_style( $handle, $dynamic_css );
     }

     /**
     * Pagination
     **/
    function pagination() {
        the_posts_pagination(array(
            'screen_reader_text' => ' ',
            'prev_text'          => '<i class="arrow_carrot-left"></i>',
            'next_text'          => '<i class="arrow_carrot-right"></i>'
        ));
    }

    /**
    * Day link to archive page
    **/
    function day_link() {
        $archive_year   = get_the_time( 'Y' );
        $archive_month  = get_the_time( 'm' );
        $archive_day    = get_the_time( 'd' );
        echo get_day_link( $archive_year, $archive_month, $archive_day);
    }

    /**
     * estimated reading time
     **/
    function reading_time() {
        $content = get_post_field( 'post_content', get_the_ID() );
        $word_count = str_word_count( strip_tags( $content ) );
        $readingtime = ceil($word_count / 200);
        if ($readingtime == 1) {
            $timer = esc_html__( " minute read", 'docly' );
        } else {
            $timer = esc_html__( " minutes read", 'docly' );
        }
        $totalreadingtime = $readingtime . $timer;
        echo esc_html($totalreadingtime);
    }

    /**
     * Post's excerpt text
     * @param $settings_key
     * @param bool $echo
     * @return string
     **/
    function excerpt($settings_key, $echo = true) {
        $opt = get_option( 'docly_opt' );
        $blog_layout_opt = !empty( $opt['blog_layout'] ) ? $opt['blog_layout'] : 'list';
        $blog_layout = !empty( $_GET['blog_layout'] ) ? $_GET['blog_layout'] : $blog_layout_opt;
        $excerpt_limit = !empty( $opt[$settings_key] ) ? $opt[$settings_key] : 40;
        if ( $blog_layout == 'grid' || $blog_layout == 'blog_category' ) {
            $excerpt_limit = 15;
        }
        $post_excerpt = get_the_excerpt();
        $excerpt = (strlen(trim($post_excerpt)) != 0) ? wp_trim_words(get_the_excerpt(), $excerpt_limit, '') : wp_trim_words(get_the_content(), $excerpt_limit, '');
        if(  $echo == true ) {
            echo wp_kses_post(wpautop($excerpt));
        } else {
            return wp_kses_post(wpautop($excerpt));
        }
    }

    /**
     * Post author avatar
     **/
     function post_author_avatar( $size = 50 ) {
         $post_author_id = get_post_field( 'post_author', get_the_ID() );
         echo get_avatar($post_author_id, $size);
     }

    /**
    * Get the first category name
    * @param string $term
    */
    function first_category($term = 'category') {
        $cats = get_the_terms(get_the_ID(), $term);
        $cat  = is_array($cats) ? $cats[0]->name : '';
        echo esc_html($cat);
    }

    /**
    * Get the first category link
    * @param string $term
    */
    function first_category_link($term='category') {
        $cats = get_the_terms(get_the_ID(), $term);
        $cat  = is_array($cats) ? get_category_link($cats[0]->term_id) : '';
        echo esc_url($cat);
    }

    /**
     * Limit latter
    * @param $string
    * @param $limit_length
    * @param string $suffix
     */
    function limit_latter($string, $limit_length, $suffix = '...' ) {
        if (strlen($string) > $limit_length) {
            echo strip_shortcodes(substr($string, 0, $limit_length) . $suffix);
        }
        else {
            echo strip_shortcodes(esc_html($string));
        }
    }

    /**
    * Doc Layout
    * @return mixed|string
    */
    function doc_layout() {
        $opt = get_option('docly_opt' );
        $page_doc_layout = function_exists('get_field') ? get_field('doc_layout') : 'default';
        if ( $page_doc_layout == 'default' || $page_doc_layout == '' ) {
            $doc_layout = !empty($opt['doc_layout']) ? $opt['doc_layout'] : 'both_sidebar';
        } else {
            $doc_layout = $page_doc_layout;
        }

        return $doc_layout;
    }

    /**
    * Doc width
    * @return mixed|string
    */
    function doc_width() {
        $opt = get_option('docly_opt' );
        $page_doc_width = function_exists('get_field') ? get_field('doc_width') : 'default';
        if ( $page_doc_width == 'default' || $page_doc_width == '' ) {
            $doc_width = $opt['doc_width'] ?? 'boxed';
        } else {
            $doc_width = $page_doc_width;
        }

        return $doc_width;
    }

    /**
    * Image from Theme Settings
    * @param $settins_key
    * @param string $class
    * @param string $alt
    */
    function image_from_settings( $settings_key = '', $class = '', $alt = '' ) {
        $opt                = get_option('docly_opt' );
        $page_image         = function_exists('get_field') ? get_field($settings_key) : '';
        $is_settings_key    = $opt[$settings_key] ?? '';
        $image              = empty($page_image) ? $is_settings_key : $page_image;
        if ( !empty($image['id']) ) {
            echo wp_get_attachment_image($image['id'], 'full', '', array('class' => $class));
        }
        elseif ( !empty($image['url']) && empty($image['id']) ) {
            $class = !empty($class) ? "class='$class'" : '';
            echo "<img src='{$image['url']}' $class alt='$alt'>";
        }
    }
}


/**
 * Instance of Docly_Helper_Class class
 */
function Docly_helper() {
    return Docly_Helper_Class::instance();
}