<?php
// Color option
Redux::set_section('docly_opt', array(
	'title'     => esc_html__( 'Color Scheme', 'docly' ),
	'id'        => 'color',
	'icon'      => 'dashicons dashicons-admin-appearance',
	'fields'    => array(
        array(
            'id'          => 'accent_solid_color_opt',
            'type'        => 'color',
            'title'       => esc_html__( 'Accent Color', 'docly' ),
            'output_variables' => true,
            'default'     => '#10b3d6',
        ),
        array(
            'id'          => 'secondary_color_opt',
            'type'        => 'color',
            'title'       => esc_html__( 'Secondary Color', 'docly' ),
            'subtitle'          => esc_html__( 'Normally used in Titles, Gradient Colors', 'docly' ),
            'output_variables'  => true,
            'default'           => '#1d2746',
        ),
        array(
            'id'          => 'paragraph_color_opt',
            'type'        => 'color',
            'title'       => esc_html__( 'Paragraph Color', 'docly' ),
            'subtitle'    => esc_html__( 'Normally used in meta content, paragraph, doc lists, subtitles, icon', 'docly' ),
            'output_variables' => true,
            'default'           => '#6b707f',
        ),
	)
));