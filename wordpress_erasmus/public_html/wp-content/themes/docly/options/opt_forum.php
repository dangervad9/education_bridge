<?php
Redux::set_section('docly_opt', array(
	'title'     => esc_html__( 'Forums', 'docly' ),
	'id'        => 'forums_opt',
	'icon'      => 'dashicons dashicons-buddicons-forums',
));

/**
 * Forum archive settings
 */
Redux::set_section('docly_opt', array(
	'title'     => esc_html__( 'Forum Archive', 'docly' ),
	'id'        => 'forum_archive_opt',
	'icon'      => '',
	'subsection' => true,
	'fields'     => array(
        array(
            'title'     => esc_html__( 'Top Call to Action', 'docly' ),
            'id'        => 'is_forum_top_c2a',
            'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
        ),

        /**
         * Top Call to Action
         */
        array(
            'title'     => esc_html__( 'Top Call to Action Controls', 'docly' ),
            'id'        => 'forum_top_c2a-start',
            'type'      => 'section',
            'indent'    => true,
            'required'  => array('is_forum_top_c2a', '=', '1')
        ),

        array(
            'title'     => esc_html__( 'Left Featured Image', 'docly' ),
            'id'        => 'forum_top_c2a_logo',
            'type'      => 'media',
            'compiler'  => true,
            'default'   => array(
                'url'   => DOCLY_DIR_IMG.'/forum/answer.png'
            )
        ),

        array(
            'title'     => esc_html__( 'Title', 'docly' ),
            'id'        => 'forum_top_c2a_title',
            'type'      => 'text',
            'default'   => esc_html__( 'Can’t find an answer?', 'docly' )
        ),
        array(
            'title'         => esc_html__( 'Title font properties', 'docly' ),
            'id'            => 'forum_top_c2a_title_typo',
            'type'          => 'typography',
            'google'        => true,
            'text-align'    => true,
            'output'        => '.answer-action .action-content .ans-title',
            'preview'       => array(
                'always_display' => false
            )
        ),

        array(
            'title'     => esc_html__( 'Subtitle', 'docly' ),
            'id'        => 'forum_top_c2a_subtitle',
            'type'      => 'text',
            'default'   => esc_html__( 'Make use of a qualified tutor to get the answer', 'docly' )
        ),
        array(
            'title'         => esc_html__( 'Subtitle font properties', 'docly' ),
            'id'            => 'forum_top_c2a_subtitle_typo',
            'type'          => 'typography',
            'google'        => true,
            'text-align'    => true,
            'output'        => '.answer-action .action-content p',
            'preview'       => array(
                'always_display' => false
            )
        ),

        array(
            'title'     => esc_html__( 'Button Title', 'docly' ),
            'id'        => 'forum_top_c2a_btn_title',
            'type'      => 'text',
            'default'   => esc_html__( 'Ask a Question', 'docly' )
        ),
        array(
            'title'     => esc_html__( 'Button URL', 'docly' ),
            'id'        => 'forum_top_c2a_btn_url',
            'type'      => 'text',
            'default'   => '#'
        ),
        array(
            'title'         => esc_html__( 'Button font properties', 'docly' ),
            'id'            => 'forum_top_c2a_btn_typo',
            'type'          => 'typography',
            'google'        => true,
            'text-align'    => true,
            'output'        => '.answer-action .btn-ans',
            'preview'       => array(
                'always_display' => false
            )
        ),

        array(
            'id'     => 'forum_top_c2a-end',
            'type'   => 'section',
            'indent' => false,
        ),

        /**
         * Bottom Call to Action
         */
        array(
            'title'     => esc_html__( 'Bottom Call to Action', 'docly' ),
            'id'        => 'is_forum_btm_c2a',
            'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
        ),
        array(
            'title'     => esc_html__( 'Bottom Call to Action', 'docly' ),
            'subtitle'  => esc_html__( 'Control here the bottom Call to Action area of the Forum archive pages.', 'docly' ),
            'id'        => 'forum_btm_c2a-start',
            'type'      => 'section',
            'indent'    => true,
            'required'  => array('is_forum_btm_c2a', '=', '1')
        ),
        array(
            'title'     => esc_html__( 'Left Featured Image', 'docly' ),
            'id'        => 'forum_btm_c2a_logo',
            'type'      => 'media',
            'compiler'  => true,
            'default'   => array(
                'url'   => DOCLY_DIR_IMG.'/forum/chat-smile.png'
            )
        ),
        array(
            'title'     => esc_html__( 'Background Image', 'docly' ),
            'id'        => 'forum_btm_c2a_bg',
            'type'      => 'media',
            'compiler'  => true,
            'default'   => array(
                'url'   => DOCLY_DIR_IMG.'/forum/overlay_bg.png'
            )
        ),

        array(
            'title'     => esc_html__( 'Title', 'docly' ),
            'id'        => 'forum_btm_c2a_title',
            'type'      => 'text',
            'default'   => esc_html__( 'New to Communities?', 'docly' )
        ),
        array(
            'title'         => esc_html__( 'Title font properties', 'docly' ),
            'id'            => 'forum_btm_c2a_title_typo',
            'type'          => 'typography',
            'google'        => true,
            'text-align'    => true,
            'output'        => '.call-to-action .action-content-wrapper .action-title-wrap .action-title',
            'preview'       => array(
                'always_display' => false
            )
        ),

        array(
            'title'     => esc_html__( 'Button Title', 'docly' ),
            'id'        => 'forum_btm_c2a_btn_title',
            'type'      => 'text',
            'default'   => esc_html__( 'Join the community ', 'docly' )
        ),
        array(
            'title'         => esc_html__( 'Button font properties', 'docly' ),
            'id'            => 'forum_btm_c2a_btn_typo',
            'type'          => 'typography',
            'google'        => true,
            'text-align'    => true,
            'output'        => '.call-to-action .action-content-wrapper .action_btn',
            'preview'       => array(
                'always_display' => false
            )
        ),
        array(
            'id'     => 'forum_btm_c2a-end',
            'type'   => 'section',
            'indent' => false,
        ),
	)
));

/**
 * Forum topics archive
 */
Redux::set_section('docly_opt', array(
	'title'         => esc_html__( 'Topics Archive', 'docly' ),
	'id'            => 'topics_archive_opt',
	'icon'          => '',
	'subsection'    => true,
	'fields'        => array(
		array(
			'title'     => esc_html__( 'Forums', 'docly' ),
			'id'        => 'is_forums_in_topics',
			'type'      => 'switch',
			'on'        => esc_html__( 'Show', 'docly' ),
			'off'       => esc_html__( 'Hide', 'docly' ),
			'default'   => '1',
		),
		array(
			'title'         => esc_html__( 'Forums', 'docly' ),
			'desc'          => esc_html__( 'Forums to show above the topics list.', 'docly' ),
			'id'            => 'forums_ppp_in_topics',
			'type'          => 'slider',
			'default'       => 4,
			'min'           => 4,
			'step'          => 1,
			'max'           => 50,
			'display_value' => 'label',
		),
	)
));
