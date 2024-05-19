<?php
/**
 * Doc Settings
 */
Redux::set_section('docly_opt', array(
    'title' => esc_html__( 'Doc Settings', 'docly' ),
    'id' => 'docly_doc_sec',
    'customizer_width' => '400px',
    'icon' => 'dashicons dashicons-media-document',
));

/**
 * Search Banner
 */
Redux::set_section('docly_opt', array(
	'title' => esc_html__( 'Search Banner', 'docly' ),
	'id' => 'doc_search_opt',
	'subsection' => true,
	'icon' => '',
	'fields' => array(
		array(
			'title'     => esc_html__( 'Documentation List', 'docly' ),
			'subtitle'  => esc_html__( 'Show/Hide the documentation dropdown list.', 'docly' ),
			'id'        => 'is_search_doc_dropdown',
			'type'      => 'switch',
			'on'        => esc_html__( 'Show', 'docly' ),
			'off'       => esc_html__( 'Hide', 'docly' ),
			'default'   => '1',
		),
		array(
			'title'     => esc_html__( 'Search Keywords', 'docly' ),
			'id'        => 'is_keywords',
			'type'      => 'switch',
			'on'        => esc_html__( 'Yes', 'docly' ),
			'off'       => esc_html__( 'No', 'docly' ),
		),
		array(
			'title'     => esc_html__( 'Keywords Label', 'docly' ),
			'id'        => 'keywords_label',
			'type'      => 'text',
			'default'   => esc_html__( 'Popular Searches', 'docly'),
			'required'  => array('is_keywords', '=', '1'),
		),
		array(
			'title'     => esc_html__( 'Keywords', 'docly' ),
			'id'        => 'doc_keywords',
			'type'      => 'multi_text',
			'add_text'  =>  esc_html__( 'Add Keyword', 'docly'),
			'required'  => array('is_keywords', '=', '1'),
		),
		array(
			'title'     => esc_html__( 'Ajax Search Result Limit', 'docly' ),
			'subtitle'  => esc_html__( 'This will limit the doc sections and articles in Ajax live search results. Input -1 for show all results.', 'docly' ),
			'id'        => 'doc_result_limit',
			'type'      => 'text',
			'default'   => '-1',
		),
	)
));


/**
 * Left Sidebar
 */
Redux::set_section('docly_opt', array(
    'title' => esc_html__( 'Left Sidebar', 'docly' ),
    'id' => 'doc_left_sidebar_opt',
    'subsection' => true,
    'icon' => '',
    'fields' => array(
        array(
            'id'   => 'opt-info-doc-left',
            'type' => 'info',
            'style' => 'warning',
            'desc' => esc_html__( 'These options are moved to EazyDocs Settings.', 'docly' ),
        ),
    )
));


/**
 * Right Sidebar
 */
Redux::set_section('docly_opt', array(
    'title' => esc_html__( 'Right Sidebar', 'docly' ),
    'id' => 'doc_right_sidebar_opt',
    'subsection' => true,
    'icon' => '',
    'fields' => array(
        array(
            'id'   => 'opt-info-doc-right',
            'type' => 'info',
            'style' => 'warning',
            'desc' => esc_html__( 'These options are moved to EazyDocs Settings.', 'docly' ),
        ),
    )
));


/**
 * Doc Footer
 */
Redux::set_section('docly_opt', array(
    'title' => esc_html__( 'Layout', 'docly' ),
    'id' => 'doc_layout_opt',
    'subsection' => true,
    'icon' => '',
    'fields' => array(
        array(
            'title'     => esc_html__( 'Doc Footer', 'docly' ),
            'id'        => 'doc_footer',
            'type'      => 'image_select',
            'options'   => array(
                'simple' => array(
                    'alt' => esc_html__( 'Simple Footer', 'docly' ),
                    'img' => DOCLY_DIR_IMG.'/footer/footer-simple.png'
                ),
                'normal' => array(
                    'alt' => esc_html__( 'Widgets Footer', 'docly' ),
                    'img' => DOCLY_DIR_IMG.'/footer/footer-normal.png'
                ),
            ),
            'default' => 'simple'
        )
    )
));