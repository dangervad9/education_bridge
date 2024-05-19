<?php

/**
 * Register Google fonts.
 *
 * @return string Google fonts URL for the theme.
 */
function docly_fonts_url() {
    $fonts_url = '';
    $fonts     = array();
    $subsets   = '';

    /* Body font */
    if (  'off' !== 'on'  ) {
        $fonts[] = "Roboto:300,400,500,600,700";
    }

    $is_ssl = is_ssl() ? 'https' : 'http';

    if ( $fonts ) {
        $fonts_url = add_query_arg( array(
            'family' => urlencode( implode( '|', $fonts  ) ),
            'subset' => urlencode( $subsets ),
        ), "$is_ssl://fonts.googleapis.com/css" );
    }

    return $fonts_url;
}

/**
 * Enqueue site scripts and styles
 */
function docly_scripts() {
    $opt = get_option( 'docly_opt' );

    /**
     * Registering site's scripts and styles
     */
    wp_register_style( 'docly-fonts', docly_fonts_url(), array(), null);
    wp_register_style( 'nice-select', DOCLY_DIR_VEND.'/niceselectpicker/nice-select.css' );
    wp_register_style( 'docly-font-size', DOCLY_DIR_VEND.'/font-size/css/rvfs.css' );
    wp_register_style( 'bootstrap-select', DOCLY_DIR_VEND.'/bootstrap/css/bootstrap-select.min.css' );

    // Scripts
    wp_register_script( 'preloader', DOCLY_DIR_JS.'/pre-loader.js', array( 'jquery' ), '1.0', true );
    wp_register_script( 'nice-select', DOCLY_DIR_VEND.'/niceselectpicker/jquery.nice-select.min.js', array( 'jquery' ), '1.0', true );
    wp_register_script( 'docly-font-size', DOCLY_DIR_VEND.'/font-size/js/rv-jquery-fontsize-2.0.3.js', array( 'jquery' ), '2.0.3', true );
    wp_register_script( 'bootstrap-select', DOCLY_DIR_VEND.'/bootstrap/js/bootstrap-select.min.js', array( 'jquery', 'bootstrap' ), '2.0.3', true );
    wp_register_script( 'anchor', DOCLY_DIR_JS.'/anchor.js', array( 'jquery' ), '1.0.0', true );

    wp_enqueue_style( 'docly-fonts' );
    wp_enqueue_style( 'bootstrap',  DOCLY_DIR_VEND.'/bootstrap/css/bootstrap.min.css' );
    wp_enqueue_style( 'elegant-icon',  DOCLY_DIR_VEND.'/elegant-icon/style.css' );
    wp_enqueue_style( 'fontawesome',  DOCLY_DIR_VEND.'/font-awesome/css/all.css' );
    wp_enqueue_style( 'animate',  DOCLY_DIR_VEND.'/animation/animate.css' );
    wp_enqueue_style( 'tooltipster',  DOCLY_DIR_VEND.'/tooltipster/css/tooltipster.bundle.min.css' );
    wp_enqueue_style( 'docly-elementor',  DOCLY_DIR_CSS.'/elementor-style.css', array('elementor-frontend') );

    if ( is_singular('docs') || is_page_template('page-onepage.php') ) {
        wp_enqueue_style( 'docly-main', DOCLY_DIR_CSS . '/style.css', array('nice-select') );
    } else {
        wp_enqueue_style( 'docly-main', DOCLY_DIR_CSS . '/style.css' );
    }

	wp_enqueue_style( 'docly-wpd',  DOCLY_DIR_CSS.'/wpd-style.css' );

    if ( in_array('bbpress', get_body_class()) ) {
	    wp_enqueue_style( 'docly-forum', DOCLY_DIR_CSS . '/bbp-forum.css' );
    }

    // wooCommerce stylesheets
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_shop() || is_singular('product') || is_cart() ) {
			wp_enqueue_style( 'docly-shop', DOCLY_DIR_CSS . '/shop.css' );
			wp_enqueue_style('nice-select');
			wp_enqueue_script('nice-select');
		}
		if ( is_checkout() ) {
			wp_enqueue_style( 'docly-checkout', DOCLY_DIR_CSS . '/checkout.css' );
		}
		if ( is_account_page() ) {
			wp_enqueue_style( 'docly-shop-my-account', DOCLY_DIR_CSS . '/shop-my_account.css' );
		}
	}

    wp_enqueue_style( 'docly-wp-custom', DOCLY_DIR_CSS.'/wp-custom.css' );

    wp_enqueue_style( 'docly-responsive', DOCLY_DIR_CSS.'/responsive.css' );

    if ( is_rtl() ) {
        wp_enqueue_style( 'docly-rtl', DOCLY_DIR_CSS . '/rtl.css' );
    }

    wp_enqueue_style( 'docly-root', get_stylesheet_uri() );

    $css_output = array(
        'header_bg_color' => array(
            'background' =>  '.body_wrapper .navbar',
        ),
        'menu_item_color' => array(
            'color' =>  '.sticky_menu .menu_one .menu > .nav-item .nav-link',
        ),
        'footer_pt__px' => array(
            'padding-top' => '.footer_area'
        ),
        'footer_pr__px' => array(
            'padding-right' => '.footer_area'
        ),
        'footer_pb__px' => array(
            'padding-bottom' => '.footer_area'
        ),
        'footer_pl__px' => array(
            'padding-left' => '.footer_area'
        ),
        'btn_background_color' => array(
            'background' => '.nav_btn'
        ),

	    /**
	     * Action Button
	     */
        'btn_text_color' => array(
            'color' => '.nav_btn'
        ),
        'btn_border_color' => array(
            'border-color' => '.nav_btn'
        ),
        'hover_btn_background_color' => array(
            'background' => '.nav_btn:hover'
        ),
        'hover_btn_text_color' => array(
            'color' => '.nav_btn:hover'
        ),
        'hover_btn_border_color' => array(
	        'border-color' => '.nav_btn:hover'
        ),

	    /**
	     * Page Settings
	     */
	    'page_padding_top__px' => array(
	    	'padding-top' => '.page_wrapper'
	    ),
	    'page_padding_right__px' => array(
	    	'padding-right' => '.page_wrapper'
	    ),
	    'page_padding_bottom__px' => array(
	    	'padding-bottom' => '.page_wrapper'
	    ),
	    'page_padding_left__px' => array(
	    	'padding-left' => '.page_wrapper'
	    )
    );

    Docly_helper()->meta_css_render( 'docly-root', $css_output );

    /**
     * Register and enqueue theme script files
     */
    if ( is_singular('docs') || is_page_template('page-onepage.php') ) {
        wp_enqueue_style( 'nice-select' );
        wp_enqueue_script( 'nice-select' );
        wp_enqueue_script( 'anchor' );
    }

    if ( is_singular('topic') ) {
        wp_enqueue_style( 'nice-select' );
        wp_enqueue_script( 'nice-select' );
    }

    /**
     * JavaScripts
     */
    wp_enqueue_script( 'bootstrap', DOCLY_DIR_VEND.'/bootstrap/js/bootstrap.bundle.min.js', array( 'jquery' ), '4.3.1', true );
    wp_enqueue_script( 'wow', DOCLY_DIR_VEND.'/wow/wow.min.js', array( 'jquery' ), '1.1.3', true );
    wp_enqueue_script( 'tooltipster', DOCLY_DIR_VEND.'/tooltipster/tooltipster.bundle.min.js', array( 'jquery' ), '1.1.3', true );
    $is_privacy_bar = $opt['is_privacy_bar'] ?? '';
    if ( $is_privacy_bar == '1' ) {
	    wp_enqueue_script( 'purecookie', DOCLY_DIR_VEND . '/PureCookie/purecookie.js', array( 'jquery' ), '1.0.0', true );
    }

    wp_enqueue_script( 'docly-main', DOCLY_DIR_JS.'/main.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'DoclyPopup', DOCLY_DIR_JS.'/popuppost.js', array( 'jquery' ), '1.0.0', true );

    if ( class_exists('bbpress') ) {
    	if ( !is_singular(array('post', 'docs')) && !is_home() && !is_page() )
	    wp_enqueue_script( 'docly-forum', DOCLY_DIR_JS . '/forum.js', array( 'jquery' ), '1.0.0', true );
    }

    if ( is_page_template('page-onepage.php') ) {
    	wp_enqueue_script( 'docly-onepage', DOCLY_DIR_JS.'/onpage-menu.js', array( 'jquery' ), '1.0.0', true );
    	wp_enqueue_script( 'mark', DOCLY_DIR_JS.'/jquery.mark.min.js', array( 'jquery' ), '8.6.0', true );
        wp_enqueue_style( 'eazydocs-frontend' );
    }


    $is_ajax_search = isset($opt['is_ajax_search']) ? $opt['is_ajax_search'] : '';
    if ( $is_ajax_search == '1' ) {
        wp_enqueue_script( 'docly-ajax-doc-search', DOCLY_DIR_JS . '/ajax-doc-search.js', array( 'jquery' ), '1.0.0', true );
    }

	// Localize the script with new data
	$privacy_bar_btn_txt = !empty($opt['privacy_bar_btn_txt']) ? $opt['privacy_bar_btn_txt'] : '';
	$privacy_bar_txt = !empty($opt['privacy_bar_txt']) ? $opt['privacy_bar_txt'] : '';
	wp_localize_script( 'jquery', 'docly_local_object',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'privacy_bar_btn_txt' => $privacy_bar_btn_txt,
			'privacy_bar_txt' => $privacy_bar_txt,
		)
	);

	$localized_settings = [
		'ajax_url'  => admin_url( 'admin-ajax.php' ),
		'docly_nonce'  => wp_create_nonce('docly-nonce'),
		'docly_parent'  => get_queried_object_id(),
	];
	wp_localize_script(
		'docly-forum',
		'DoclyForum',
		$localized_settings
	);

    $localized_popup = [
        'ajax_url'  => admin_url( 'admin-ajax.php' ),
    ];
    wp_localize_script(
        'DoclyPopup',
        'DoclyPopup',
        $localized_popup
    );

	/**
	 * Inline Scripts
	 */
    $dynamic_js = '';

    if ( !empty($opt['custom_js']) ) {
    	$dynamic_js .= $opt['custom_js'];
    }

	if ( !empty($opt['os_options'][0]['title']) ) {
		foreach ( $opt['os_options'] as $option ) {
			$dynamic_js .= '
	        if( jQuery("#mySelect").val() == "' . esc_js(sanitize_title($option['title'])) . '" ) {
				jQuery(".' . esc_js(sanitize_title($option['title'])) . '").show();
			} else {
				jQuery(".' . esc_js(sanitize_title($option['title'])) . '").hide();
			}
			jQuery("#mySelect").change(function() {
				if( jQuery("#mySelect").val() == "' . esc_js(sanitize_title($option['title'])) . '" ) {
					jQuery(".' . esc_js(sanitize_title($option['title'])) . '").show();
				} else {
					jQuery(".' . esc_js(sanitize_title($option['title'])) . '").hide();
				}
			})';
		}
	}

    wp_add_inline_script( 'docly-custom', $dynamic_js);

    if (  is_singular() && comments_open() && get_option( 'thread_comments'  )  ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'docly_scripts' );

// Admin dashboard style and scripts
add_action( 'admin_enqueue_scripts', function() {
	global $pagenow;
    wp_enqueue_style( 'docly-admin', DOCLY_DIR_CSS.'/admin.css' );

	if ( $pagenow == 'admin.php' ) {
		wp_enqueue_style( 'elegant-icon',  DOCLY_DIR_VEND.'/elegant-icon/style.css' );
		wp_enqueue_style( 'docly-admin-dashboard', DOCLY_DIR_CSS.'/admin-dashboard.min.css' );
	}
});