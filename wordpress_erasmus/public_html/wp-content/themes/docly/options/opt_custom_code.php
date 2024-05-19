<?php
Redux::set_section( 'docly_opt', array(
    'title'            => esc_html__( 'Custom Code', 'docly' ),
    'id'               => 'custom_code_opt',
    'icon'             => 'dashicons dashicons-editor-code',
    'fields'           => array(
	    array(
		    'id'       => 'custom_css',
		    'type'     => 'ace_editor',
		    'title'    => esc_html__( 'CSS Code', 'docly' ),
		    'subtitle' => esc_html__( 'Paste your CSS code here.', 'docly' ),
		    'mode'     => 'css',
		    'theme'    => 'monokai',
	    ),
	    array(
		    'id'       => 'custom_js',
		    'type'     => 'ace_editor',
		    'title'    => esc_html__( 'JS Code', 'docly' ),
		    'subtitle' => esc_html__( 'Paste your JS code here.', 'docly' ),
		    'mode'     => 'javascript',
		    'theme'    => 'chrome',
		    'default'  => "jQuery(document).ready(function(){\n\n});"
	    ),
    )
));