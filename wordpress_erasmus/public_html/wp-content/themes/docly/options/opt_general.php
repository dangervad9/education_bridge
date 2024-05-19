<?php
Redux::set_section('docly_opt', array(
	'title'     => esc_html__( 'General', 'docly' ),
	'id'        => 'general_settings',
	'icon'      => 'dashicons dashicons-admin-generic',
));


Redux::set_section('docly_opt', array(
	'title'         => esc_html__( 'Search', 'docly' ),
	'id'            => 'search_settings',
	'icon'          => '',
    'subsection'    => true,
	'fields'        => array(
        array(
            'id'        => 'is_ajax_search',
            'type'      => 'switch',
            'title'     => esc_html__( 'Ajax Search', 'docly' ),
            'on'        => esc_html__( 'Enabled', 'docly' ),
            'off'       => esc_html__( 'Disabled', 'docly' ),
            'default'   => true,
        ),
		array(
			'title'         => esc_html__( 'Focus Search by /', 'docly' ),
			'subtitle'      => esc_html__( 'If you enable this setting, your website visitors can focus (enter the mouse cursor) on the search form by pressing the "/" key of the keyboard.', 'docly' ),
			'id'            => 'is_focus_search',
			'type'          => 'switch',
			'on'            => esc_html__( 'Yes', 'docly' ),
			'off'           => esc_html__( 'No', 'docly' ),
			'default'       => 1
		),
	)
));

Redux::set_section('docly_opt', array(
	'title'         => esc_html__( 'Custom Posts', 'docly' ),
	'id'            => 'cpt_opt',
	'icon'          => '',
    'subsection'    => true,
	'fields'        => array(
        array(
            'id'       => 'is_faq_cpt',
            'type'     => 'switch',
            'title'    => esc_html__('FAQs', 'docly' ),
            'on'       => esc_html__( 'Enabled', 'docly' ),
            'off'      => esc_html__( 'Disabled', 'docly' ),
            'default'  => true,
        ),

        array(
            'id'       => 'is_mega_menu_cpt',
            'type'     => 'switch',
            'title'    => esc_html__( 'Mega Menu', 'docly' ),
            'on'       => esc_html__( 'Enabled', 'docly' ),
            'off'      => esc_html__( 'Disabled', 'docly' ),
            'default'  => true,
        ),
	)
));

Redux::set_section( 'docly_opt', array(
	'title'            => esc_html__( 'Preloader', 'docly' ),
	'id'               => 'preloader_opt',
	'icon'             => '',
	'subsection'       => true,
	'fields'           => array(
		array(
			'id'        => 'is_preloader',
			'type'      => 'switch',
			'title'     => esc_html__( 'Pre-loader', 'docly' ),
			'on'        => esc_html__( 'Enabled', 'docly' ),
			'off'       => esc_html__( 'Disabled', 'docly' ),
			'default'   => true,
		),

		array(
			'title'     => esc_html__( 'Enable Pre-loader on', 'docly' ),
			'id'        => 'preloader_pages',
			'type'      => 'select',
			'options'   => [
				'all' => esc_html__( 'All Pages', 'docly' ),
				'specific_pages' => esc_html__( 'Specific Pages', 'docly' ),
			],
			'default'   => 'all',
			'required' => array (
				array ( 'is_preloader', '=', '1' ),
			)
		),

		array(
			'title'     => esc_html__( 'Page IDs', 'docly' ),
			'subtitle'  => esc_html__( "Input the multiple page IDs in comma separated format.", 'docly' ),
			'desc'      => sprintf(esc_html__('%s How to find page ID %s', 'docly'), '<a href="https://is.gd/xM75oQ" target="_blank">', '</a>' ),
			'id'        => 'preloader_page_ids',
			'type'      => 'text',
			'required' => array (
				array ( 'is_preloader', '=', '1' ),
				array ( 'preloader_pages', '=', 'specific_pages' ),
			)
		),

		/**
		 * Preloader Logo
		 */
		array(
			'required'      => array( 'is_preloader', '=', '1' ),
			'id'            => 'preloader_logo',
			'type'          => 'media',
			'title'         => esc_html__( 'Pre-loader Logo', 'docly' ),
			'compiler'      => true,
			'default'       => array(
				'url' => DOCLY_DIR_IMG . '/spinner_logo.png'
			)
		),
		array(
			'required'      => array( 'is_preloader', '=', '1' ),
			'id'            => 'logo_title',
			'type'          => 'text',
			'title'         => esc_html__( 'Logo Title', 'docly' ),
			'default'       => get_bloginfo( 'name' )
		),
		array(
			'required'      => array( 'is_preloader', '=', '1' ),
			'title'         => esc_html__( 'Logo Title Color', 'docly' ),
			'id'            => 'preloader_logo_title_color',
			'type'          => 'color',
			'output'        => array( '#preloader .round_spinner h4' ),
		),
		array(
			'required'      => array( 'is_preloader', '=', '1' ),
			'title'         => esc_html__( 'Logo Title Typography', 'docly' ),
			'id'            => 'logo_title_typo',
			'type'          => 'typography',
			'text-align'    => false,
			'output'        => '#preloader .round_spinner h4',
		),

		/**
		 * Preloader Title
		 */
		array(
			'required'      => array( 'is_preloader', '=', '1' ),
			'id'            => 'preloader_title',
			'type'          => 'text',
			'title'         => esc_html__( 'Preloader Title', 'docly' ),
			'default'       => 'Did You Know?'
		),
		array(
			'required'      => array( 'is_preloader', '=', '1' ),
			'title'         => esc_html__( 'Preloader Title Color', 'docly' ),
			'id'            => 'preloader_title_color',
			'type'          => 'color',
			'output'        => array( '#preloader .head' ),
		),
		array(
			'required'      => array( 'is_preloader', '=', '1' ),
			'title'         => esc_html__( 'Preloader Title Typography', 'docly' ),
			'id'            => 'preloader_title_typo',
			'type'          => 'typography',
			'text-align'    => false,
			'output'        => '#preloader .head',
		),

		/**
		 * Preloader Quotes
		 */
		array(
			'required'      => array( 'is_preloader', '=', '1' ),
			'id'            => 'preloader_quotes',
			'type'          => 'multi_text',
			'title'         => esc_html__( 'Quotes', 'docly' ),
			'subtitle'      => esc_html__( 'The quotes will display randomly under the title.', 'docly' ),
			'default'       => 'Did You Know?'
		),
		array(
			'required'      => array( 'is_preloader', '=', '1' ),
			'title'         => esc_html__( 'Preloader Quotes Color', 'docly' ),
			'id'            => 'preloader_quotes_color',
			'type'          => 'color',
			'output'        => array( '#preloader p' ),
		),
		array(
			'required'      => array( 'is_preloader', '=', '1' ),
			'title'         => esc_html__( 'Preloader Quotes Typography', 'docly' ),
			'id'            => 'preloader_quotes_typo',
			'type'          => 'typography',
			'text-align'    => false,
			'output'        => '#preloader p',
		),
	)
));

/**
 * Blog archive settings
 */
Redux::set_section('docly_opt', array(
	'title'     => esc_html__( 'Back to Top', 'docly' ),
	'id'        => 'back_to_top_btn',
	'icon'      => '',
	'subsection' => true,
	'fields'    => array(
		array(
			'title'     => esc_html__( 'Back to Top Button', 'docly' ),
			'subtitle'  => esc_html__( 'Show/hide back to top button globally settings', 'docly' ),
			'id'        => 'is_back_to_top_btn_switcher',
			'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
		),

        /**
         * Button Normal Colors
         */
        array(
            'id' => 'normal_color_start',
            'type' => 'section',
            'title' => esc_html__( 'Normal Color', 'docly' ),
            'indent' => true,
            'required' => array( 'is_back_to_top_btn_switcher', '=', 1 )
        ),
        array(
            'title'     => esc_html__( 'Icon Color', 'docly' ),
            'id'        => 'back_to_top_btn_icon_color',
            'type'      => 'color',
            'output'    => array(
                'color' => '#back-to-top::after'
            ),
        ),
        array(
            'title'     => esc_html__( 'Background Color', 'docly' ),
            'id'        => 'back_to_top_btn_bg_color',
            'type'      => 'color_rgba',
            'output'    => array(
                'background-color' => '#back-to-top'
            ),
        ),
        array(
            'id' => 'normal_color_end',
            'type' => 'section',
            'indent' => true
        ),

        /**
         * Button Hover Colors
         */
        array(
            'id' => 'hover_color_start',
            'type' => 'section',
            'title'     => esc_html__( 'Hover Color', 'docly' ),
            'indent' => true,
            'required' => array( 'is_back_to_top_btn_switcher', '=', 1 )
        ),
        array(
            'title'     => esc_html__( 'Icon Color', 'docly' ),
            'id'        => 'back_to_top_btn_icon_hover_color',
            'type'      => 'color',
            'output'    => array(
                'color' => '#back-to-top:hover::after'
            ),
        ),
        array(
            'title'     => esc_html__( 'Background Color', 'docly' ),
            'id'        => 'back_to_top_btn_bg_hover_color',
            'type'      => 'color_rgba',
            'output'    => array(
                'background-color' => '#back-to-top:hover'
            ),
        ),
        array(
            'id' => 'hover_color_end',
            'type' => 'section',
            'indent' => true
        ),
	)
));