<?php
Redux::set_section('docly_opt', array(
	'title'     => esc_html__( 'Blog Pages', 'docly' ),
	'id'        => 'blog_page',
	'icon'      => 'dashicons dashicons-admin-post',
));

/**
 * Blog archive settings
 */
Redux::set_section('docly_opt', array(
	'title'     => esc_html__( 'Blog archive', 'docly' ),
	'id'        => 'blog_meta_opt',
	'icon'      => '',
	'subsection' => true,
	'fields'    => array(
        array(
            'title'     => esc_html__( 'Blog page title', 'docly' ),
            'subtitle'  => esc_html__( 'Controls the title text that displays in the page title bar only if your front page displays your latest post in "Settings > Reading".', 'docly' ),
            'id'        => 'blog_title',
            'type'      => 'text',
            'default'   => esc_html__( 'Blog List', 'docly' )
        ),
        array(
            'title'         => esc_html__( 'Title font properties', 'docly' ),
            'id'            => 'blog_titlebar_title_typo',
            'type'          => 'typography',
            'google'        => true,
            'text-align'    => true,
            'output'        => '.blog .breadcrumb_content_two h1',
            'preview'       => array(
                'always_display' => false
            )
        ),
        array(
            'title'     => esc_html__( 'Blog Layout', 'docly' ),
            'subtitle'  => esc_html__( 'The Blog layout will also apply on the blog category and tag pages.', 'docly' ),
            'id'        => 'blog_layout',
            'type'      => 'image_select',
            'options'   => array(
                'list' => array(
                    'alt' => esc_html__( 'List Layout', 'docly' ),
                    'img' => DOCLY_DIR_IMG.'/layouts/list.jpg'
                ),
                'grid' => array(
                    'alt' => esc_html__( 'Grid Layout', 'docly' ),
                    'img' => DOCLY_DIR_IMG.'/layouts/blog_grid.jpg'
                ),
                'blog_category' => array(
                    'alt' => esc_html__( 'Grid Category Tab', 'docly' ),
                    'img' => DOCLY_DIR_IMG.'/layouts/blog_grid_category_tab.jpg'
                ),
            ),
            'default' => 'list'
        ),
        array(
            'title'     => esc_html__( 'Column', 'docly' ),
            'id'        => 'blog_column',
            'type'      => 'select',
            'options'   => [
                '6' => esc_html__( 'Two', 'docly' ),
                '4' => esc_html__( 'Three', 'docly' ),
                '3' => esc_html__( 'Four', 'docly' ),
            ],
            'default'   => '6',
            'required' => array (
                array ( 'blog_layout', '=', array( 'grid', 'blog_category' ) ),
            )
        ),
        array(
            'title'     => esc_html__( 'Post title length', 'docly' ),
            'subtitle'  => esc_html__( 'Blog post title length in character', 'docly' ),
            'id'        => 'post_title_length',
            'type'      => 'slider',
            'default'   => 50,
            "min"       => 1,
            "step"      => 1,
            "max"       => 500,
            'display_value' => 'text',
        ),
        array(
            'title'     => esc_html__( 'Post word excerpt', 'docly' ),
            'subtitle'  => esc_html__( 'If post excerpt empty, the excerpt content will take from the post content. Define here how much word you want to show along with the each posts in the blog page.', 'docly' ),
            'id'        => 'blog_excerpt',
            'type'      => 'slider',
            'default'   => 40,
            "min"       => 1,
            "step"      => 1,
            "max"       => 500,
            'display_value' => 'text'
        ),
        array(
            'title'     => esc_html__( 'Continue Reading Label', 'docly' ),
            'id'        => 'blog_continue_read',
            'type'      => 'text',
            'default'   => esc_html__( 'Continue Reading', 'docly' ),
            'required' => array (
                 array ( 'blog_layout', '=', 'list' ),
                 array ( 'blog_layout', '=', 'blog_category' ),
            ),
        ),
		array(
			'title'     => esc_html__( 'Post meta', 'docly' ),
			'subtitle'  => esc_html__( 'Show/hide post meta on blog archive page', 'docly' ),
			'id'        => 'is_post_meta',
			'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
		),
		array(
			'title'     => esc_html__( 'Post date', 'docly' ),
			'id'        => 'is_post_date',
			'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
            'required' => array( 'is_post_meta', '=', 1 )
		),
		array(
			'title'     => esc_html__( 'Post Reading Time', 'docly' ),
			'id'        => 'is_post_reading_time',
			'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
            'required' => array( 'is_post_meta', '=', 1 )
		),
		array(
			'title'     => esc_html__( 'Post category', 'docly' ),
			'id'        => 'is_post_cat',
			'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
            'required' => array( 'is_post_meta', '=', 1 )
		),
		array(
			'title'     => esc_html__( 'Author', 'docly' ),
			'id'        => 'is_post_author',
			'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
            'required' => array( 'is_post_meta', '=', 1 )
		),
	)
));

/**
 * Post single
 */
Redux::set_section('docly_opt', array(
	'title'     => esc_html__( 'Blog single', 'docly' ),
	'id'        => 'blog_single_opt',
	'icon'      => '',
	'subsection' => true,
	'fields'    => array(
        array(
            'title'     => esc_html__( 'Background Color', 'docly' ),
            'id'        => 'blog_single_banner_bg_color',
            'output'    => '.breadcrumb_area_two',
            'type'      => 'color',
            'mode'      => 'background'
        ),
        array(
            'title'     => esc_html__( 'Title Color', 'docly' ),
            'id'        => 'blog_single_banner_title_color',
            'output'    => '.breadcrumb_content h1',
            'type'      => 'color',
            'mode'      => 'color'
        ),
		array(
			'title'     => esc_html__( 'Social Share', 'docly' ),
			'id'        => 'is_social_share',
			'type'      => 'switch',
            'on'        => esc_html__( 'Enabled', 'docly' ),
            'off'       => esc_html__( 'Disabled', 'docly' ),
            'default'   => '1'
		),
		array(
			'title'     => esc_html__( 'Social Share', 'docly' ),
			'id'        => 'share_title',
			'type'      => 'text',
            'default'   => esc_html__( 'Share This Article', 'docly' ),
            'required'  => array('is_social_share', '=', '1')
		),
		array(
			'title'     => esc_html__( 'Post Tag', 'docly' ),
			'id'        => 'is_post_tag',
			'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1'
		),
        array(
            'title'     => esc_html__( 'Post meta', 'docly' ),
            'subtitle'  => esc_html__( 'Show/hide post meta on blog single page', 'docly' ),
            'id'        => 'is_single_post_meta',
            'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
        ),
        array(
            'title'     => esc_html__( 'Categories', 'docly' ),
            'id'        => 'is_single_cats',
            'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
            'required' => array( 'is_single_post_meta', '=', 1 )
        ),
        array(
            'title'     => esc_html__( 'Post Author Name', 'docly' ),
            'id'        => 'is_single_post_author',
            'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
            'required' => array( 'is_single_post_meta', '=', 1 )
        ),
        array(
            'title'     => esc_html__( 'Comment Count Text', 'docly' ),
            'id'        => 'is_single_comment_meta',
            'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
            'required' => array( 'is_single_post_meta', '=', 1 )
        ),
        array(
            'title'     => esc_html__( 'Post Date', 'docly' ),
            'id'        => 'is_single_post_date',
            'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
            'default'   => '1',
            'required' => array( 'is_single_post_meta', '=', 1 )
        ),
        array(
            'title'     => esc_html__( 'Related posts ', 'docly' ),
            'id'        => 'is_related_posts',
            'type'      => 'switch',
            'on'        => esc_html__( 'Show', 'docly' ),
            'off'       => esc_html__( 'Hide', 'docly' ),
        ),
        array(
            'title'     => esc_html__( 'Posts section title', 'docly' ),
            'id'        => 'related_posts_title',
            'type'      => 'text',
            'default'   => esc_html__( 'Related Post', 'docly' ),
            'required'  => array('is_related_posts', '=', '1' )
        ),
        array(
            'title'     => esc_html__( 'Related posts count', 'docly' ),
            'id'        => 'related_posts_count',
            'type'      => 'slider',
            'default'       => 3,
            'min'           => 3,
            'step'          => 1,
            'max'           => 50,
            'display_value' => 'label',
            'required'  => array('is_related_posts', '=', '1' )
        ),
	)
));
