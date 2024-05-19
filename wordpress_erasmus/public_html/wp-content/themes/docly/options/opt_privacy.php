<?php
Redux::set_section( 'docly_opt', array(
    'title'            => esc_html__( 'Privacy', 'docly' ),
    'id'               => 'privacy_opt',
    'icon'             => 'dashicons dashicons-businessperson',
    'fields'           => array(
        array(
            'id'            => 'is_privacy_bar',
            'type'          => 'switch',
            'title'         => esc_html__( 'Privacy Bar', 'docly' ),
            'subtitle'      => esc_html__( 'Turn on to enable a privacy bar at the bottom of the page.', 'docly' ),
            'on'            => esc_html__( 'On', 'docly' ),
            'off'           => esc_html__( 'Off', 'docly' ),
            'default'       => '',
        ),

        /**
         * Privacy Bar Styling
         */
	    array(
		    'required'      => array( 'is_privacy_bar', '=', '1' ),
		    'title'         => esc_html__( 'Privacy Bar Text', 'docly' ),
		    'id'            => 'privacy_bar_txt',
		    'type'          => 'editor',
		    'default'       => esc_html__( 'By using this website, you automatically accept that we use cookies.', 'docly' ),
		    'args'          => array (
			    'wpautop'       => true,
			    'media_buttons' => false,
			    'textarea_rows' => 10,
			    'teeny'         => false,
			    'quicktags'     => false,
		    )
	    ),
	    array(
		    'required'      => array( 'is_privacy_bar', '=', '1' ),
		    'title'         => esc_html__( 'Privacy Bar Button Text', 'docly' ),
		    'id'            => 'privacy_bar_btn_txt',
		    'type'          => 'text',
		    'default'       => esc_html__( 'Understood', 'docly' ),
	    ),
        array(
            'required'      => array( 'is_privacy_bar', '=', '1' ),
            'id'            => 'privacy_bar_padding',
            'title'         => esc_html__( 'Privacy Bar Padding', 'docly' ),
            'type'          => 'spacing',
            'output'        => array( '.cookieAcceptBar' ),
            'mode'          => 'padding',
            'units'         => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true',
        ),
        array(
            'required'      => array( 'is_privacy_bar', '=', '1' ),
            'id'            => 'privacy_bar_bg',
            'title'         => esc_html__( 'Privacy Bar Background Color', 'docly' ),
            'type'          => 'color',
            'output'        => array( '.cookieAcceptBar' ),
            'mode'          => 'background-color',
        ),
        array(
            'required'      => array( 'is_privacy_bar', '=', '1' ),
            'title'         => esc_html__( 'Privacy Bar Typography', 'docly' ),
            'id'            => 'privacy_bar_typo',
            'type'          => 'typography',
            'text-align'    => false,
            'output'        => '.cookieAcceptBar',
        ),
    )
));