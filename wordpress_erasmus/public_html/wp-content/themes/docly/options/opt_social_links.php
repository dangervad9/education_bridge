<?php
Redux::set_section('docly_opt', array(
    'title'     => esc_html__( 'Social links', 'docly' ),
    'id'        => 'opt_social_links',
    'icon'      => 'dashicons dashicons-share',
    'fields'    => array(

        array(
            'id'    => 'facebook',
            'type'  => 'text',
            'title' => esc_html__( 'Facebook', 'docly' ),
            'default'	 => '#'
        ),

        array(
            'id'    => 'twitter',
            'type'  => 'text',
            'title' => esc_html__( 'Twitter', 'docly' ),
            'default'	  => '#'
        ),

        array(
            'id'    => 'instagram',
            'type'  => 'text',
            'title' => esc_html__( 'Instagram', 'docly' ),
        ),

        array(
            'id'    => 'linkedin',
            'type'  => 'text',
            'title' => esc_html__( 'LinkedIn', 'docly' ),
            'default'	  => '#'
        ),

        array(
            'id'    => 'youtube',
            'type'  => 'text',
            'title' => esc_html__( 'Youtube', 'docly' ),
        ),

        array(
            'id'    => 'dribbble',
            'type'  => 'text',
            'title' => esc_html__( 'Dribbble', 'docly' ),
        ),

        array(
            'id'    => 'github',
            'type'  => 'text',
            'title' => esc_html__( 'GitHub', 'docly' ),
        ),

        array(
            'id'    => 'vk',
            'type'  => 'text',
            'title' => esc_html__( 'VK', 'docly' ),
        ),
    ),
));