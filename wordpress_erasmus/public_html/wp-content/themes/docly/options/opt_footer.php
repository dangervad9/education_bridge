<?php

// Footer settings
Redux::set_section('docly_opt', array(
	'title'     => esc_html__( 'Footer', 'docly' ),
	'id'        => 'docly_footer',
	'icon'      => 'dashicons dashicons-arrow-down-alt2',
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Footer Style', 'docly' ),
            'id'        => 'footer_style',
            'type'      => 'image_select',
            'options'   => array(
                'simple' => array(
                    'alt' => esc_html__( 'Footer Simple', 'docly' ),
                    'img' => DOCLY_DIR_IMG.'/footer/footer-simple.png'
                ),
                'normal' => array(
                    'alt' => esc_html__( 'Footer Normal', 'docly' ),
                    'img' => DOCLY_DIR_IMG.'/footer/footer-normal.png'
                ),
            ),
            'default' => 'normal'
        ),

        array(
            'id'            => 'is_footer_columns_preset',
            'type'          => 'switch',
            'title'         => esc_html__( 'Preset Columns', 'docly' ),
            'subtitle'      => esc_html__( 'If you enable this switcher, the Footer Widget columns will set as preset (33.33% + 22.22 + 22.22 + 22.22) on the demo of Docly.', 'docly' ),
            'on'            => esc_html__( 'Yes', 'docly' ),
            'off'           => esc_html__( 'No', 'docly' ),
            'default'       => true,
            'required'      => array( 'footer_style', '=', 'normal' )
        ),

        array(
            'title'     => esc_html__('Footer Column', 'docly'),
            'id'        => 'footer_column',
            'type'      => 'select',
            'default'   => '3',
            'options'   => array(
                '6' => esc_html__('Two Column', 'docly'),
                '4' => esc_html__('Three Column', 'docly'),
                '3' => esc_html__('Four Column', 'docly'),
            ),
            'required' => array(
                array(
                    'footer_style', '=', 'normal'
                ),
                array(
                    'is_footer_columns_preset', '=', ''
                ),
            )
        ),

        array(
            'title'     => esc_html__( 'Padding', 'docly' ),
            'subtitle'  => esc_html__( 'Padding around the footer columns (Top Right Bottom Left)', 'docly' ),
            'id'        => 'footer_column_padding',
            'type'      => 'spacing',
            'output'    => array( '.footer_area .f_widget' ),
            'mode'      => 'padding',
            'units'     => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true',
            'required' => array( 'footer_style', '=', 'normal' )
        ),

        array(
            'title'     => esc_html__( 'Ornament Illustration', 'docly' ),
            'subtitle'  => esc_html__( 'This is for beautiful design purpose. You can replace the default illustration or delete it from here.', 'docly' ),
            'id'        => 'fs_illustration',
            'type'      => 'media',
            'default'   => array(
                'url' => DOCLY_DIR_IMG.'/footer/leaf_footter.png'
            ),
            'required' => array( 'footer_style', '=', 'simple' )
        ),
    )
));

// Footer settings
Redux::set_section('docly_opt', array(
	'title'     => esc_html__( 'Font colors', 'docly' ),
	'id'        => 'docly_footer_font_colors',
	'icon'      => '',
	'subsection'=> true,
	'fields'    => array(
        array(
            'title'     => esc_html__( 'Widget Title Color', 'docly' ),
            'id'        => 'widget_title_color',
            'type'      => 'color',
            'output'    => array('.f_widget .f_title' ),
            'required'  => array( 'footer_style', '=', 'normal' )
        ),
        array(
            'title'     => esc_html__( 'Normal Font color', 'docly' ),
            'id'        => 'footer_top_normal_font_color',
            'type'      => 'color_rgba',
            'output'    => array('.footer_top .f_widget ul li a, .footer_top .widget.widget_nav_menu ul li a, .simple_footer p' )
        ),
        array(
            'title'     => esc_html__( 'Hover Font color', 'docly' ),
            'id'        => 'footer_top_hover_font_color',
            'type'      => 'color_rgba',
            'output'    => array('.footer_top .f_widget ul li a:hover, .footer_top .widget.widget_nav_menu ul li a:hover' ),
            'required'  => array( 'footer_style', '=', 'normal' )
        ),
	)
));

// Footer background
Redux::set_section('docly_opt', array(
	'title'     => esc_html__( 'Background', 'docly' ),
	'id'        => 'docly_footer_background',
	'icon'      => '',
	'subsection'=> true,
	'fields'    => array(

        array(
            'title'     => esc_html__( 'Object 01', 'docly' ),
            'subtitle'  => esc_html__( 'This object positioned at the left side of the footer.', 'docly' ),
            'id'        => 'f_cloud',
            'type'      => 'media',
            'default'   => array(
                'url' => DOCLY_DIR_IMG.'/footer/cloud.png'
            )
        ),

        array(
            'title'     => esc_html__( 'Object 02', 'docly' ),
            'subtitle'  => esc_html__( 'This object positioned at the left side of the footer.', 'docly' ),
            'id'        => 'f_email',
            'type'      => 'media',
            'default'   => array(
                'url' => DOCLY_DIR_IMG.'/footer/email-icon.png'
            )
        ),

        array(
            'title'     => esc_html__( 'Object 03', 'docly' ),
            'subtitle'  => esc_html__( 'This object positioned at the left side of the footer.', 'docly' ),
            'id'        => 'f_email_two',
            'type'      => 'media',
            'default'   => array(
                'url' => DOCLY_DIR_IMG.'/footer/email-icon_two.png'
            )
        ),

        array(
            'title'     => esc_html__( 'Background Color', 'docly' ),
            'id'        => 'footer_top_bg_color',
            'type'      => 'color',
            'output'    => array('.footer_area, .simple_footer' ),
            'mode'      => 'background'
        ),

        array(
            'title'     => esc_html__( 'Bottom Background Color', 'docly' ),
            'subtitle'  => esc_html__( 'Footer bottom background color', 'docly' ),
            'id'        => 'footer_btm_bg_color',
            'type'      => 'color',
            'output'    => array('.footer_bottom' ),
            'mode'      => 'background',
	        'required'  => array( 'footer_style', '=', 'normal' )
        ),
	)
));


// Footer Typography
Redux::set_section('docly_opt', array(
    'title'     => esc_html__( 'Typography', 'docly' ),
    'id'        => 'docly_footer_typography',
    'icon'      => '',
    'subsection'=> true,
    'fields'    => array(
        array(
            'title'         => esc_html__( 'Widget Title', 'docly' ),
            'id'            => 'footer_title_typo',
            'type'          => 'typography',
            'color'         => false,
            'output'        => '.footer-widget .widget_title',
        ),
        array(
            'title'         => esc_html__( 'Widget Contents', 'docly' ),
            'id'            => 'preloader_typo',
            'type'          => 'typography',
            'color'         => false,
            'output'        => '.new_footer_top p, .new_footer_top .f_widget.about-widget ul li a',
        ),
    )
));


// Footer settings
Redux::set_section('docly_opt', array(
    'title'     => esc_html__( 'Footer Bottom', 'docly' ),
    'id'        => 'docly_footer_btm',
    'icon'      => '',
    'subsection'=> true,
    'fields'    => array(
        array(
            'title'     => esc_html__( 'Leaf Image', 'docly' ),
            'subtitle'  => esc_html__( 'We applied CSS animation on this SVG leaf image. This placed at the border of the Footer right bottom area.', 'docly' ),
            'id'        => 'footer_leaf_image',
            'type'      => 'media',
            'default'   => array(
                'url' => DOCLY_DIR_IMG.'/footer/v.svg'
            )
        ),

        array(
            'title'     => esc_html__( 'Left Image', 'docly' ),
            'id'        => 'footer_left_image',
            'type'      => 'media',
            'default'   => array(
                'url' => DOCLY_DIR_IMG.'/footer/footer-left-man.png'
            )
        ),

        array(
            'title'     => esc_html__( 'Right Image', 'docly' ),
            'id'        => 'footer_right_image',
            'type'      => 'media',
            'default'   => array(
                'url' => DOCLY_DIR_IMG.'/footer/f_man.png'
            )
        ),

        array(
            'title'     => esc_html__( 'Copyright Text', 'docly' ),
            'id'        => 'copyright_txt',
            'type'      => 'editor',
            'default'   => '© 2020 All Rights Reserved by CreativeGigs',
            'args'    => array (
                'wpautop'       => true,
                'media_buttons' => false,
                'textarea_rows' => 10,
                'teeny'         => false,
                'quicktags'     => false,
            )
        ),
    )
));