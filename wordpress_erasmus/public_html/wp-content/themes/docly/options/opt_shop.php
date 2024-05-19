<?php
// Shop page
Redux::set_section('docly_opt', array(
    'title'            => esc_html__( 'Shop', 'docly' ),
    'id'               => 'shop_opt',
    'icon'             => 'dashicons dashicons-cart',
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Page title', 'docly' ),
            'subtitle'  => esc_html__( 'Give here the shop page title', 'docly' ),
            'desc'      => esc_html__( 'This text will show on the shop page banner', 'docly' ),
            'id'        => 'shop_title',
            'type'      => 'text',
            'default'   => esc_html__( 'Shop', 'docly' ),
        ),

        array(
            'title'     => esc_html__( 'Shop Page Subtitle', 'docly' ),
            'id'        => 'shop_subtitle',
            'type'      => 'textarea',
        ),

        array(
            'title'     => esc_html__( 'Layout', 'docly' ),
            'subtitle'  => esc_html__( 'Select the product view layout', 'docly' ),
            'id'        => 'shop_layout',
            'type'      => 'image_select',
            'options'   => array(
                'shop_list' => array(
                    'alt' => esc_html__( 'List Layout', 'docly' ),
                    'img' => DOCLY_DIR_IMG.'/layouts/list.jpg'
                ),
                'shop_grid' => array(
                    'alt' => esc_html__( 'Grid Layout', 'docly' ),
                    'img' => DOCLY_DIR_IMG.'/layouts/grid.jpg'
                ),
            ),
            'default' => 'shop_grid'
        ),

        array(
            'title'     => esc_html__( 'Sidebar', 'docly' ),
            'subtitle'  => esc_html__( 'Select the sidebar position of Shop page', 'docly' ),
            'id'        => 'shop_sidebar',
            'type'      => 'image_select',
            'options'   => array(
                'left' => array(
                    'alt' => esc_html__( 'Left Sidebar', 'docly' ),
                    'img' => DOCLY_DIR_IMG.'/layouts/sidebar_left.jpg'
                ),
                'right' => array(
                    'alt' => esc_html__( 'Right Sidebar', 'docly' ),
                    'img' => DOCLY_DIR_IMG.'/layouts/sidebar_right.jpg',
                ),
                'full' => array(
                    'alt' => esc_html__( 'Full Width', 'docly' ),
                    'img' => DOCLY_DIR_IMG.'/layouts/fullwidth.png',
                ),
            ),
            'default' => 'left'
        ),
    ),
));


// Product Single Options
Redux::set_section('docly_opt', array(
    'title'            => esc_html__( 'Product Single', 'docly' ),
    'id'               => 'product_single_opt',
    'subsection'       => true,
    'icon'             => '',
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Related Products Title', 'docly' ),
            'id'        => 'related_products_title',
            'type'      => 'text',
            'default'   => esc_html__( 'Related products', 'docly' ),
        ),
        array(
            'title'     => esc_html__( 'Related Products Subtitle', 'docly' ),
            'id'        => 'related_products_subtitle',
            'type'      => 'textarea',
        ),
    )
));


// Gutenberg Blocks
Redux::set_section('docly_opt', array(
    'title'            => esc_html__( 'Gutenberg Blocks', 'docly' ),
    'id'               => 'wc_gutenberg_opt',
    'subsection'       => true,
    'icon'             => '',
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Unload WC Gutenberg Assets', 'docly' ),
            'subtitle'  => esc_html__( "WC gutenberg assets loads globally. If you don't use wooCommerce gutenberg blocks, it's recommended to unload the unnecessary assets.", 'docly' ),
            'id'        => 'is_wc_block',
            'type'      => 'switch',
            'default'   => '',
        ),
    )
));