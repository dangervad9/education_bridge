<?php
// Header Section
Redux::set_section( 'docly_opt', array(
    'title'            => esc_html__( 'Header', 'docly' ),
    'id'               => 'header_sec',
    'customizer_width' => '400px',
    'icon'             => 'dashicons dashicons-arrow-up-alt2',
));


// Logo
Redux::set_section( 'docly_opt', array(
    'title'            => esc_html__( 'Logo', 'docly' ),
    'id'               => 'logo_opt',
    'subsection'       => true,
    'icon'             => '',
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Main Logo', 'docly' ),
            'subtitle'  => esc_html__( 'Upload here a image file for your logo', 'docly' ),
            'id'        => 'main_logo',
            'type'      => 'media',
            'compiler'  => true,
            'default'   => array(
                'url'   => DOCLY_DIR_IMG.'/logo-w.png'
            )
        ),

        array(
            'title'     => esc_html__( 'Sticky Logo', 'docly' ),
            'id'        => 'sticky_logo',
            'type'      => 'media',
            'compiler'  => true,
            'default'   => array(
                'url'   => DOCLY_DIR_IMG.'/logo.png'
            )
        ),

        array(
            'title'     => esc_html__( 'Retina Main Logo', 'docly' ),
            'subtitle'  => esc_html__( 'The retina logo should be double (2x) of your original logo', 'docly' ),
            'id'        => 'retina_logo',
            'type'      => 'media',
            'compiler'  => true,
            'default'   => array(
                'url'   => DOCLY_DIR_IMG.'/logo-w2x.png'
            )
        ),

        array(
            'title'     => esc_html__( 'Retina Sticky Logo', 'docly' ),
            'subtitle'  => esc_html__( 'The retina logo should be double (2x) of your original logo', 'docly' ),
            'id'        => 'retina_sticky_logo',
            'type'      => 'media',
            'compiler'  => true,
            'default'   => array(
                'url'   => DOCLY_DIR_IMG.'/logo-2x.png'
            )
        ),

        array(
            'title'     => esc_html__( 'Logo dimensions', 'docly' ),
            'subtitle'  => esc_html__( 'Set a custom height width for your upload logo.', 'docly' ),
            'id'        => 'logo_dimensions',
            'type'      => 'dimensions',
            'units'     => array( 'em','px','%' ),
            'output'    => '.navbar-brand>img'
        ),

        array(
            'title'     => esc_html__( 'Padding', 'docly' ),
            'subtitle'  => esc_html__( 'Padding around the logo. Input the padding as clockwise (Top Right Bottom Left)', 'docly' ),
            'id'        => 'logo_padding',
            'type'      => 'spacing',
            'output'    => array( '.header_area .navbar-brand' ),
            'mode'      => 'padding',
            'units'     => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true',
        ),
    )
) );

/**
 * Action button
 */
Redux::set_section( 'docly_opt', array(
    'title'            => esc_html__( 'Action Button', 'docly' ),
    'id'               => 'menu_action_btn_opt',
    'subsection'       => true,
    'icon'             => '',
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Button Visibility', 'docly' ),
            'id'        => 'is_menu_btn',
            'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
        ),

        array(
            'title'     => esc_html__( 'Button label', 'docly' ),
            'subtitle'  => esc_html__( 'Leave the button label field empty to hide the menu action button.', 'docly' ),
            'id'        => 'menu_btn_label',
            'type'      => 'text',
            'default'   => esc_html__( 'Get Started', 'docly' ),
            'required'  => array( 'is_menu_btn', '=', '1' )
        ),

        array(
            'title'     => esc_html__( 'Button URL', 'docly' ),
            'id'        => 'menu_btn_url',
            'type'      => 'text',
            'default'   => '#',
            'required'  => array( 'is_menu_btn', '=', '1' )
        ),

        array(
            'title'     => esc_html__( 'Button URL Target', 'docly' ),
            'id'        => 'menu_btn_target',
            'type'      => 'select',
            'options'   => array(
            	'_blank' => esc_html__( 'Blank (Open in new tab)', 'docly' ),
            	'_self' => esc_html__( 'Self (Open in the same tab)', 'docly' ),
            ),
            'default'   => '_self',
            'required'  => array( 'is_menu_btn', '=', '1' )
        ),

	    array(
		    'title'     => esc_html__( 'Button padding', 'docly' ),
		    'subtitle'  => esc_html__( 'Padding around the menu action button.', 'docly' ),
		    'id'        => 'menu_btn_padding',
		    'type'      => 'spacing',
		    'output'    => array( '.nav_btn' ),
		    'mode'      => 'padding',
		    'units'     => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
		    'units_extended' => 'true',
		    'required'  => array( 'is_menu_btn', '=', '1' )
	    ),

        array(
            'id'        => 'action_btn_typo',
            'type'      => 'typography',
            'title'     => esc_html__( 'Button Typography', 'docly' ),
            'output'    => '.navbar .nav_btn',
            'required'  => array( 'is_menu_btn', '=', '1' )
        ),

        /**
         * Button colors
         * Style will apply on the Non sticky mode and sticky mode of the header
         */
        array(
            'title'     => esc_html__( 'Button Colors', 'docly' ),
            'subtitle'  => esc_html__( 'Button style attributes on normal (non sticky) mode.', 'docly' ),
            'id'        => 'button_colors',
            'type'      => 'section',
            'indent'    => true,
            'required'  => array( 'is_menu_btn', '=', '1' ),
        ),

        array(
            'title'     => esc_html__( 'Font color', 'docly' ),
            'id'        => 'menu_btn_font_color',
            'type'      => 'color',
            'output'    => array( '.navbar .nav_btn' ),
        ),
        
        array(
            'title'     => esc_html__( 'Border Color', 'docly' ),
            'id'        => 'menu_btn_border_color',
            'type'      => 'color',
            'mode'      => 'border-color',
            'output'    => array( '.navbar .nav_btn' ),
        ),
        
        array(
            'title'     => esc_html__( 'Background Color', 'docly' ),
            'id'        => 'menu_btn_bg_color',
            'type'      => 'color',
            'mode'      => 'background',
            'output'    => array( '.navbar .nav_btn' ),
        ),

        // Button color on hover stats
        array(
            'title'     => esc_html__( 'Hover Font Color', 'docly' ),
            'subtitle'  => esc_html__( 'Font color on hover stats.', 'docly' ),
            'id'        => 'menu_btn_hover_font_color',
            'type'      => 'color',
            'output'    => array( '.navbar .nav_btn:hover' ),
        ),
        array(
            'title'     => esc_html__( 'Hover Border Color', 'docly' ),
            'id'        => 'menu_btn_hover_border_color',
            'type'      => 'color',
            'mode'      => 'border-color',
            'output'    => array( '.navbar .nav_btn:hover' ),
        ),
        array(
            'title'     => esc_html__( 'Hover background color', 'docly' ),
            'subtitle'  => esc_html__( 'Background color on hover stats.', 'docly' ),
            'id'        => 'menu_btn_hover_bg_color',
            'type'      => 'color',
            'output'    => array(
                'background' => '.navbar .nav_btn:hover',
                'border-color' => '.navbar_fixed .navbar .nav_btn:hover'
            ),
        ),

        array(
            'id'     => 'button_colors-end',
            'type'   => 'section',
            'indent' => false,
        ),

        /*
         * Button colors on sticky mode
         */
        array(
            'title'     => esc_html__( 'Sticky Button Style', 'docly' ),
            'subtitle'  => esc_html__( 'Button colors on sticky mode.', 'docly' ),
            'id'        => 'button_colors_sticky',
            'type'      => 'section',
            'indent'    => true,
            'required'  => array( 'is_menu_btn', '=', '1' ),
        ),
        array(
            'title'     => esc_html__( 'Border color', 'docly' ),
            'id'        => 'menu_btn_border_color_sticky',
            'type'      => 'color',
            'mode'      => 'border-color',
            'output'    => array( '.navbar.navbar_fixed .nav_btn' ),
        ),
        array(
            'title'     => esc_html__( 'Font color', 'docly' ),
            'id'        => 'menu_btn_font_color_sticky',
            'type'      => 'color',
            'output'    => array( '.navbar_fixed.navbar .nav_btn' ),
        ),
        array(
            'title'     => esc_html__( 'Background color', 'docly' ),
            'id'        => 'menu_btn_bg_color_sticky',
            'type'      => 'color',
            'mode'      => 'background',
            'output'    => array( '.navbar_fixed.navbar .nav_btn' ),
        ),

        // Button color on hover stats
        array(
            'title'     => esc_html__( 'Hover font color', 'docly' ),
            'subtitle'  => esc_html__( 'Font color on hover stats.', 'docly' ),
            'id'        => 'menu_btn_hover_font_color_sticky',
            'type'      => 'color',
            'output'    => array( '.navbar.navbar_fixed .nav_btn:hover' ),
        ),
        array(
            'title'     => esc_html__( 'Hover background color', 'docly' ),
            'subtitle'  => esc_html__( 'Background color on hover stats.', 'docly' ),
            'id'        => 'menu_btn_hover_bg_color_sticky',
            'type'      => 'color',
            'output'    => array(
                'background' => '.navbar.navbar_fixed .nav_btn:hover',
            ),
        ),
        array(
            'title'     => esc_html__( 'Hover border color', 'docly' ),
            'subtitle'  => esc_html__( 'Background color on hover stats.', 'docly' ),
            'id'        => 'menu_btn_hover_border_color_sticky',
            'type'      => 'color',
            'output'    => array(
                'border-color' => '.navbar.navbar_fixed .nav_btn:hover',
            ),
        ),

        array(
            'id'     => 'button_colors-sticky-end',
            'type'   => 'section',
            'indent' => false,
        ),
    )
));

/**
 * Title-bar banner
 */
Redux::set_section( 'docly_opt', array(
    'title'            => esc_html__( 'Title-bar', 'docly' ),
    'id'               => 'title_bar_opt',
    'subsection'       => true,
    'icon'             => '',
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Ornaments', 'docly' ),
            'id'        => 'is_banner_ornaments',
            'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
        ),

        array(
            'title'     => esc_html__( 'Left Ornament', 'docly' ),
            'subtitle'  => esc_html__( 'Upload here the default left ornament image', 'docly' ),
            'id'        => 'banner_left_ornament',
            'type'      => 'media',
            'compiler'  => true,
            'required'  => array( 'is_banner_ornaments', '=', '1' ),
            'default'   => array(
                'url' => DOCLY_DIR_IMG.'/leaf_left.png'
            )
        ),

        array(
            'title'     => esc_html__( 'Right Ornament', 'docly' ),
            'subtitle'  => esc_html__( 'Upload here the default right ornament image', 'docly' ),
            'id'        => 'banner_right_ornament',
            'type'      => 'media',
            'compiler'  => true,
            'required'  => array( 'is_banner_ornaments', '=', '1' ),
            'default'   => array(
                'url' => DOCLY_DIR_IMG.'/leaf_right.png'
            )
        ),

        array(
            'id'        => 'banner_title_typo',
            'type'      => 'typography',
            'title'     => esc_html__( 'Title Typography', 'docly' ),
            'output'    => '.breadcrumb_content h1, .breadcrumb_content_two h1'
        ),

        array(
            'id'        => 'titlebar_subtitle_typo',
            'type'      => 'typography',
            'title'     => esc_html__( 'Subtitle Typography', 'docly' ),
            'output'    => '.breadcrumb_content p',
            'required'  => array( 'banner_style', '=', '1' )
        ),

        array(
            'title'     => esc_html__( 'Title-bar padding', 'docly' ),
            'subtitle'  => esc_html__( 'Padding around the Title-bar.', 'docly' ),
            'id'        => 'title_bar_padding',
            'type'      => 'spacing',
            'output'    => array( '.breadcrumb_area_three' ),
            'mode'      => 'padding',
            'units'     => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true',
        ),

        array(
            'id'       => 'titlebar_align',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Alignment', 'docly' ),
            'options' => array(
                'left' => esc_html__( 'Left', 'docly' ),
                'center' => esc_html__( 'Center', 'docly' ),
                'right' => esc_html__( 'Right', 'docly' )
            ),
            'default' => 'center'
        ),
    )
));

/**
 * Search Banner
 */
Redux::set_section('docly_opt', array(
	'title' => esc_html__( 'Search Banner', 'docly' ),
	'id' => 'search_banner_header_opt',
	'subsection' => true,
	'icon' => '',
	'fields' => array(
		array(
			'id'        => 'search_banner_note',
			'type'      => 'info',
			'style'     => 'success',
			'title'     => esc_html__( 'Important Note:', 'docly' ),
			'icon'      => 'dashicons dashicons-info',
			'desc'      => esc_html__( 'Search Banner located on the Doc details page and Blog page.', 'docly' )
		),

		array(
			'title'     => esc_html__( 'Breadcrumb', 'docly' ),
			'id'        => 'is_breadcrumb',
			'type'      => 'switch',
			'on'        => esc_html__( 'Show', 'docly' ),
			'off'       => esc_html__( 'Hide', 'docly' ),
			'default'   => '1',
		),

		array(
			'title'     => esc_html__('Date', 'docly'),
			'subtitle'  => esc_html__('Show date in the breadcrumb right side.', 'docly'),
			'id'        => 'breadcrumb_date',
			'type'      => 'select',
			'default'   => 'modified',
			'options'   => array(
				'published' => esc_html__('Date Published', 'docly'),
				'modified' => esc_html__('Date Modified', 'docly'),
			),
			'required' => array('is_breadcrumb', '=', '1')
		),

		array(
			'id'        => 'search_banner_bg_color',
			'type'      => 'color_gradient',
			'title'     => esc_html__( 'Background Color', 'docly' ),
			'preview'   => true,
			'default'   => array(
				'from'  => '#10b3d6',
				'to'    => '#1d2746',
			),
		),

		array(
			'id'            => 'banner_search_placeholder',
			'type'          => 'text',
			'title'         => esc_html__( 'Search Placeholder', 'docly' ),
			'default'       => esc_html__('Search ("/" to focus)', 'docly')
		),

		array(
			'title'     => esc_html__( 'Padding', 'docly' ),
			'subtitle'  => esc_html__( 'Padding around the Search Banner. Input the padding as clockwise (Top Right Bottom Left)', 'docly' ),
			'id'        => 'sbanner_padding',
			'type'      => 'spacing',
			'output'    => array( '.breadcrumb_area' ),
			'mode'      => 'padding',
			'units'     => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
			'units_extended' => 'true',
		),

		array(
			'title'     => esc_html__( 'Left Leaf Image', 'docly' ),
			'id'        => 'sbanner_left_image',
			'type'      => 'media',
			'default'   => array(
				'url' => DOCLY_DIR_IMG.'/v.svg'
			)
		),

		array(
			'title'     => esc_html__( 'Right Leaf Image', 'docly' ),
			'id'        => 'sbanner_right_image',
			'type'      => 'media',
			'default'   => array(
				'url' => DOCLY_DIR_IMG.'/home_one/b_leaf.svg'
			)
		),

		array(
			'title'     => esc_html__( 'Man Image', 'docly' ),
			'id'        => 'sbanner_man_image',
			'type'      => 'media',
			'default'   => array(
				'url' => DOCLY_DIR_IMG.'/home_one/b_man_two.png'
			)
		),

		array(
			'title'     => esc_html__( 'Flower Image', 'docly' ),
			'id'        => 'sbanner_flower_image',
			'type'      => 'media',
			'default'   => array(
				'url' => DOCLY_DIR_IMG.'/home_one/flower.png'
			)
		),

		array(
			'title'     => esc_html__( 'Background Shape Image', 'docly' ),
			'subtitle'  => esc_html__( 'We used here a transparent image that are containing stars. So you can use here similar transparent image or any other image.', 'docly' ),
			'id'        => 'sbanner_bg_image',
			'type'      => 'media',
			'default'   => array(
				'url' => DOCLY_DIR_IMG.'/home_one/banner_bg.png'
			)
		),

		array(
			'title'     => esc_html__( 'Wave Shape 01', 'docly' ),
			'subtitle'  => esc_html__( 'We used here a transparent wave shape image. You can use here similar transparent shape image or any other image.', 'docly' ),
			'id'        => 'sbanner_shape1',
			'type'      => 'media',
			'default'   => array(
				'url' => DOCLY_DIR_IMG.'/shap_01.png'
			)
		),

		array(
			'title'     => esc_html__( 'Wave Shape 02', 'docly' ),
			'subtitle'  => esc_html__( 'We used here a transparent wave shape image. You can use here similar transparent shape image or any other image.', 'docly' ),
			'id'        => 'sbanner_shape2',
			'type'      => 'media',
			'default'   => array(
				'url' => DOCLY_DIR_IMG.'/shap_02.png'
			)
		),
	)
));