<?php
Redux::set_section('docly_opt', array(
    'title'            => esc_html__( 'Typography Settings', 'docly' ),
    'id'               => 'docly_typo_opt',
    'icon'             => 'dashicons dashicons-editor-textcolor',
    'fields'           => array(
        array(
            'id'        => 'typo_note',
            'type'      => 'info',
            'style'     => 'success',
            'title'     => esc_html__( 'Important Note:', 'docly' ),
            'icon'      => 'dashicons dashicons-info',
            'desc'      => esc_html__( 'This tab contains general typography options. Additional typography options for specific areas can be found within other tabs. Example: For menu typography options go to the Menu Settings tab.', 'docly' )
        ),

        array(
            'id'        => 'body_typo',
            'type'      => 'typography',
            'title'     => esc_html__( 'Body Typography', 'docly' ),
            'subtitle'  => esc_html__( 'These settings control the typography for the body text globally.', 'docly' ),
            'description' => sprintf (
                '%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
                esc_html__( 'You can add your own custom font', 'docly' ),
                get_admin_url(null, 'edit-tags.php?taxonomy=bsf_custom_fonts' ),
                esc_html__( 'here.', 'docly' ),
                esc_html__( 'You can get the custom fonts in the Typography\'s Font Family list.', 'docly' )
            ),
            'output'    => 'body, .f_p'
        ),
    )
));


/*** Headers Typography ***/
Redux::set_section('docly_opt', array(
    'title'            => esc_html__( 'Headers Typography', 'docly' ),
    'id'               => 'headers_typo_opt',
    'icon'             => '',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'        => 'typo_note_headers',
            'type'      => 'info',
            'style'     => 'success',
            'title'     => esc_html__( 'Important Note:', 'docly' ),
            'icon'      => 'dashicons dashicons-info',
            'desc'      => esc_html__( 'This tab contains general typography options. Additional typography options for specific areas can be found within other tabs. Example: For menu typography options go to the Menu Settings tab.', 'docly' )
        ),

        array(
            'id'        => 'h1_typo',
            'type'      => 'typography',
            'title'     => esc_html__( 'H1 Headers Typography', 'docly' ),
            'subtitle'  => esc_html__( 'These settings control the typography for all H1 Headers.', 'docly' ),
            'output'    => 'h1, h1.f_p, .breadcrumb_content h1'
        ),

        array(
            'id'        => 'h2_typo',
            'type'      => 'typography',
            'title'     => esc_html__( 'H2 Headers Typography', 'docly' ),
            'subtitle'  => esc_html__( 'These settings control the typography for all H2 Headers. The h2 title tag used in the most section title.', 'docly' ),
            'output'    => 'h2, h2.f_p'
        ),
        array(
            'id'        => 'h3_typo',
            'type'      => 'typography',
            'title'     => esc_html__( 'H3 Headers Typography', 'docly' ),
            'subtitle'  => esc_html__( 'These settings control the typography for all H3 Headers.', 'docly' ),
            'output'    => 'h3, h3.f_p, .job_details_area h3'
        ),

        array(
            'id'        => 'h4_typo',
            'type'      => 'typography',
            'title'     => esc_html__( 'H4 Headers Typography', 'docly' ),
            'subtitle'  => esc_html__( 'These settings control the typography for all H4 Headers.', 'docly' ),
            'output'    => 'h4, h4.f_p'
        ),

        array(
            'id'        => 'h5_typo',
            'type'      => 'typography',
            'title'     => esc_html__( 'H5 Headers Typography', 'docly' ),
            'subtitle'  => esc_html__( 'These settings control the typography for all H5 Headers.', 'docly' ),
            'output'    => 'h5, h5.f_p'
        ),

        array(
            'id'        => 'h6_typo',
            'type'      => 'typography',
            'title'     => esc_html__( 'H6 Headers Typography', 'docly' ),
            'subtitle'  => esc_html__( 'These settings control the typography for all H6 Headers.', 'docly' ),
            'output'    => 'h6, h6.f_p, .job_info .info_item h6'
        ),
    )
));