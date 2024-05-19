<?php
// Theme settings options
$opt = get_option('docly_opt' );

// Image sizes
add_image_size('docly_270x320', 270, 320, true); // Product Thumbnail
add_image_size('docly_300x320', 300, 320, true); // Product Thumbnail
add_image_size('docly_370x360', 370, 360, true); // Posts carousel thumbnail
add_image_size('docly_770x400', 770, 400, true); // Blog post list format
add_image_size('docly_370x220', 370, 220, true); // Blog post grid format
add_image_size('docly_370x200', 370, 200, true); // Related post thumbnail
add_image_size('docly_670x450', 670, 450, true); // Blog Category Page Sticky post thumbnail
add_image_size('docly_18x18', 18, 18, true); // Forum post topic category thumbnail
add_image_size('docly_20x20', 20, 20, true); // Forum post topic category thumbnail
add_image_size('docly_450x420', 450, 420, true); //
add_image_size('docly_80x90', 80, 90, true); //

// add category nick names in body and post class
function docly_post_class( $classes ) {
    global $post;
    if ( !has_post_thumbnail() ) {
        $classes[] = 'no-post-thumbnail';
    }
    if ( is_sticky() && !in_array('sticky', $classes) ) {
        $classes[] = 'sticky';
    }
    return $classes;
}
add_filter( 'post_class', 'docly_post_class' );

/**
 * Body classes
 */
add_filter( 'body_class', function($classes) {
    $opt = get_option('docly_opt' );
    $is_doc_sticky = function_exists('get_field') ? get_field('is_sticky_header') : '';
    $has_menu = has_nav_menu('main_menu') ? '' : 'has_not_menu';

    $classes[] = $has_menu;

    if ( Docly_helper()->doc_layout() == 'left_sidebar' && is_singular('docs') ) {
        $classes[] = 'no_right_sidebar';
    }

    if ( is_singular('docs') ) {
        $classes[] = Docly_helper()->doc_width() == 'full-width' ? 'full-width-doc' : '';
        $classes[] = 'doc';
        if ( $is_doc_sticky == '1' ) {
            $classes[] = 'sticky-nav-doc';
        }
    }

    $dr_ = get_option('dr_');
    if ( !empty($dr_) ) {
    	$classes[] = 'dr_'.$dr_;
    } else {
    	$classes[] = 'dr_nn';
    }

    return $classes;
});
/**
 * Show post excerpt by default
 * @param $user_login
 * @param $user
 */
function docly_show_post_excerpt( $user_login, $user ) {
    $unchecked = get_user_meta( $user->ID, 'metaboxhidden_post', true );
    $key = is_array($unchecked) ? array_search( 'postexcerpt', $unchecked ) : FALSE;
    if ( FALSE !== $key ) {
        array_splice( $unchecked, $key, 1 );
        update_user_meta( $user->ID, 'metaboxhidden_post', $unchecked );
    }
}
add_action( 'wp_login', 'docly_show_post_excerpt', 10, 2 );

// filter to replace class on reply link
add_filter('comment_reply_link', function($class){
    $class = str_replace("class='comment-reply-link", "class='comment_reply", $class);
    return $class;
});

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function docly_pingback_header() {
    if ( is_singular() && pings_open() ) {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'docly_pingback_header' );

// Move the comment field to bottom
add_filter( 'comment_form_fields', function ( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
});

// Remove WordPress admin bar default CSS
add_action('get_header', function() {
    remove_action('wp_head', '_admin_bar_bump_cb' );
});


// Elementor post type support
function docly_add_cpt_support() {

    //if exists, assign to $cpt_support var
    $cpt_support = get_option( 'elementor_cpt_support' );

    //check if option DOESN'T exist in db
    if ( ! $cpt_support ) {
        $cpt_support = [ 'page', 'post', 'docs' ]; //create array of our default supported post types
        update_option( 'elementor_cpt_support', $cpt_support ); //write it to the database
    }

    //if it DOES exist, but header is NOT defined
    elseif( !in_array( 'docs', $cpt_support ) ) {
        $cpt_support[] = 'docs'; //append to array
        update_option( 'elementor_cpt_support', $cpt_support ); //update database
    }

    //otherwise do nothing, portfolio already exists in elementor_cpt_support option
}
add_action( 'after_switch_theme', 'docly_add_cpt_support' );

// Color Picker Issue solution
if( is_admin() ){
	add_action( 'wp_default_scripts', 'docly_default_custom_scripts' );
	function docly_default_custom_scripts( $scripts ) {
		$scripts->add( 'wp-color-picker', "/wp-admin/js/color-picker.js", array( 'iris' ), false, 1 );
		did_action( 'init' ) && $scripts->localize(
			'wp-color-picker',
			'wpColorPickerL10n',
			array(
				'clear'            => esc_html__( 'Clear', 'docly' ),
				'clearAriaLabel'   => esc_html__( 'Clear color', 'docly' ),
				'defaultString'    => esc_html__( 'Default', 'docly' ),
				'defaultAriaLabel' => esc_html__( 'Select default color', 'docly' ),
				'pick'             => esc_html__( 'Select Color', 'docly' ),
				'defaultLabel'     => esc_html__( 'Color value', 'docly' ),
			)
		);
	}
}

/**
 * Saving automatically the ACF group fields json files
 */
add_filter('acf/settings/save_json', function ( $path ) {

	// update path
	$path = get_stylesheet_directory() . '/inc/acf-json';

	// return
	return $path;
});

/**
 * Loading the saved ACF fields
 */
add_filter('acf/settings/load_json', function ( $paths ) {
	// append path
	$paths[] = get_stylesheet_directory() . '/inc/acf-json';
	// return
	return $paths;
});

/**
 * Turn on the WordPress visual editor for bbPress
 * @param array $args
 *
 * @return array|mixed
 */
function docly_bbp_enable_visual_editor( $args = array() ) {
	$args['tinymce'] = true;
	return $args;
}
add_filter( 'bbp_after_get_the_content_parse_args', 'docly_bbp_enable_visual_editor' );

/**
 * Post author field for docs
 */
add_action( 'init', function () {
    add_post_type_support( 'docs', 'author' );
});

add_filter( 'author_link', 'docly_author_link', 10, 3 );
function docly_author_link( $link, $author_id, $author_nicename ) {
    if ( is_singular( 'docs' ) || is_post_type_archive( 'docs' ) ) {
        $link = add_query_arg( 'post_type', 'docs', $link );
    }
    return $link;
}

/**
 * Show forum lead topics by default
 */
add_filter('bbp_show_lead_topic', function () {
    $show_lead[] = 'true';
    return $show_lead;
});