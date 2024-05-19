<?php
// Register Widget areas
add_action('widgets_init', function() {

    $opt = get_option('docly_opt' );

    register_sidebar( array(
        'name'          => esc_html__( 'Primary Sidebar', 'docly' ),
        'description'   => esc_html__( 'Place widgets in sidebar widgets area.', 'docly' ),
        'id'            => 'sidebar_widgets',
        'before_widget' => '<div id="%1$s" class="widget sidebar_widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="c_head">',
        'after_title'   => '</h3>'
    ));

    if ( class_exists( 'bbPress' ) ) {
        register_sidebar(array(
            'name'          => esc_html__( 'Forum Sidebar', 'docly' ),
            'description'   => esc_html__( 'Add widgets here for the Forum Archive Sidebar area', 'docly' ),
            'id'            => 'forum_archive_sidebar',
            'before_widget' => '<div id="%1$s" class="widget sidebar_widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="c_head">',
            'after_title'   => '</h3>'
        ));
    }

	if (class_exists( 'WooCommerce')) {
		register_sidebar(array(
			'name' => esc_html__( 'Shop sidebar', 'docly' ),
			'description' => esc_html__( 'Place widgets here for WooCommerce shop page.', 'docly' ),
			'id' => 'shop_sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h5 class="sp_widget_title">',
			'after_title' => '</h5>'
		));
	}

    $footer_column = !empty($opt['footer_column']) ? $opt['footer_column'] : '3';
    register_sidebar(array(
        'name'          => esc_html__( 'Footer Widgets', 'docly' ),
        'description'   => esc_html__( 'Add widgets here for Footer widgets area', 'docly' ),
        'id'            => 'footer_widgets',
        'before_widget' => '<div id="%1$s" class="footer_widget col-lg-'.$footer_column.' col-md-6">
                            <div class="widget f_widget %2$s">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h3 class="f_title">',
        'after_title'   => '</h3>'
    ));

});
