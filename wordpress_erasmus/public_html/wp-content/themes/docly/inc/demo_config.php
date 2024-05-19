<?php
$purchase_code_status = trim( get_option( 'docly_purchase_code_status' ) );
if ( $purchase_code_status == 'valid' ) :
	// Disable regenerating images while importing media
	add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );
	add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

	// Change some options for the jQuery modal window
	function docly_ocdi_confirmation_dialog_options ( $options ) {
	    return array_merge( $options, array(
	        'width'       => 400,
	        'dialogClass' => 'wp-dialog',
	        'resizable'   => false,
	        'height'      => 'auto',
	        'modal'       => true,
	    ) );
	}
	add_filter( 'pt-ocdi/confirmation_dialog_options', 'docly_ocdi_confirmation_dialog_options', 10, 1 );

	function docly_ocdi_intro_text( $default_text ) {
	    $default_text .= '<div class="ocdi_custom-intro-text notice notice-info inline">';
	    $default_text .= sprintf (
	        '%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
	        esc_html__( 'Install and activate all ', 'docly' ),
	        get_admin_url(null, 'themes.php?page=tgmpa-install-plugins' ),
	        esc_html__( 'required plugins', 'docly' ),
	        esc_html__( 'before you click on the "Import" button.', 'docly' )
	    );
	    $default_text .= sprintf (
	        ' %1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
	        esc_html__( 'You will find all the pages in ', 'docly' ),
	        get_admin_url(null, 'edit.php?post_type=page' ),
	        esc_html__( 'Pages.', 'docly' ),
	        esc_html__( 'Other pages will be imported along with the main Homepage.', 'docly' )
	    );
	    $default_text .= '<br>';
	    $default_text .= sprintf (
	        '%1$s <a href="%2$s" target="_blank">%3$s</a>',
	        esc_html__( 'If you fail to import the demo data, follow the alternative way', 'docly' ),
	        'https://is.gd/R6jpHq',
	        esc_html__( 'here.', 'docly' )
	    );
	    $default_text .= '</div>';

	    return $default_text;
	}
	add_filter( 'pt-ocdi/plugin_intro_text', 'docly_ocdi_intro_text' );

	// OneClick Demo Importer
	add_filter( 'pt-ocdi/import_files', 'docly_import_files' );
	function docly_import_files() {
	    return array (
	        array(
	            'import_file_name'             => esc_html__( 'Cool Knowledge-base', 'docly' ),
	            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo/contents.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo/widgets.wie',
	            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ).'inc/demo/cool.jpg',
	            'preview_url'                  => 'https://wordpress.creativegigs.net/docly/',
	            'local_import_redux'           => array(
	                array(
	                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demo/settings.json',
	                    'option_name' => 'docly_opt',
	                ),
	            ),
	        ),
	        array(
	            'import_file_name'             => esc_html__( 'Light Knowledge-base', 'docly' ),
	            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo/contents.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo/widgets.wie',
	            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ).'inc/demo/light.jpg',
	            'preview_url'                  => 'https://wordpress.creativegigs.net/docly/home-light/',
	            'local_import_redux'           => array(
	                array(
	                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demo/settings.json',
	                    'option_name' => 'docly_opt',
	                ),
	            ),
	        ),
	        array(
	            'import_file_name'             => esc_html__( 'Helpdesk', 'docly' ),
	            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo/contents.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo/widgets.wie',
	            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ).'inc/demo/helpdesk.jpg',
	            'preview_url'                  => 'https://wordpress.creativegigs.net/docly/home-help-desk/',
	            'local_import_redux'           => array(
	                array(
	                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demo/settings.json',
	                    'option_name' => 'docly_opt',
	                ),
	            ),
	        ),
	    );
	}


	function docly_after_import_setup($selected_import) {

	    // Assign menus to their locations.
	    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

	    set_theme_mod( 'nav_menu_locations', array (
	            'main_menu' => $main_menu->term_id,
	        )
	    );

	    // Disable Elementor's Default Colors and Default Fonts
	    update_option( 'elementor_disable_color_schemes', 'yes' );
	    update_option( 'elementor_disable_typography_schemes', 'yes' );
	    update_option( 'elementor_global_image_lightbox', '' );

		// Assign front page and posts page (blog page).
		if ( 'Cool Knowledge-base' == $selected_import['import_file_name'] ) {
			$front_page_id = get_page_by_title( 'Home Cool' );
		}

		if ( 'Light Knowledge-base' == $selected_import['import_file_name'] ) {
			$front_page_id = get_page_by_title( 'Home Light' );
		}

		if ( 'Helpdesk' == $selected_import['import_file_name'] ) {
			$front_page_id = get_page_by_title( 'Home Help Desk' );
		}

	    $front_page_id = get_page_by_title('Home Cool' );
	    $blog_page_id  = get_page_by_title( 'Blog' );

	    // Set the home page and blog page
	    update_option( 'show_on_front', 'page' );
	    update_option( 'page_on_front', $front_page_id->ID );
	    update_option( 'page_for_posts', $blog_page_id->ID );
	}
	add_action( 'pt-ocdi/after_import', 'docly_after_import_setup' );
endif;