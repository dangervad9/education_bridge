<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package docly
 */

// Search form
function docly_search_form($is_button=true) {
    ?>
    <div class="docly-search">
        <form class="form-wrapper" action="<?php echo esc_url(home_url( '/')); ?>" _lpchecked="1">
            <input type="text" id="search" placeholder="<?php esc_attr_e( 'Search ...', 'docly' ); ?>" name="s">
            <button type="submit" class="btn"><i class="fa fa-search"></i></button>
        </form>
        <?php if ( $is_button==true) { ?>
        <a href="<?php echo esc_url(home_url( '/')); ?>" class="home_btn"> <?php esc_html_e( 'Back to home Page', 'docly' ); ?> </a>
        <?php } ?>
    </div>
    <?php
}

// Get comment count text
function docly_comment_count( $post_id ) {
    $comments_number = get_comments_number($post_id);
    if ( $comments_number == 0) {
        $comment_text = esc_html__( 'No Comments', 'docly' );
    } elseif( $comments_number == 1) {
        $comment_text = esc_html__( '1 Comment', 'docly' );
    } elseif( $comments_number > 1) {
        $comment_text = $comments_number.esc_html__( ' Comments', 'docly' );
    }
    echo esc_html($comment_text);
}

// Get author role
function docly_get_author_role() {
    global $authordata;
    $author_roles = $authordata->roles;
    $author_role = array_shift($author_roles);
    return esc_html($author_role);
}

// Banner Subtitle
function docly_banner_subtitle() {
    $opt = get_option( 'docly_opt' );
    if (is_home() ) {
        $blog_subtitle = !empty($opt['blog_subtitle']) ? $opt['blog_subtitle'] : get_bloginfo( 'description' );
        echo esc_html($blog_subtitle);
    }
    elseif (is_page() || is_single() ) {
        if (has_excerpt() ) {
            while (have_posts() ) {
                the_post();
                echo nl2br(get_the_excerpt(get_the_ID() ));
            }
        }
    }
    elseif ( is_archive() ) {
        echo '';
    }
}

/**
 * Get a specific html tag from content
 * @return a specific HTML tag from the loaded content
 */
function docly_get_html_tag( $tag = 'blockquote', $content = '' ) {
    $dom = new DOMDocument();
    $dom->loadHTML($content);
    $divs = $dom->getElementsByTagName( $tag );
    $i = 0;
    foreach ( $divs as $div ) {
        if ( $i == 1 ) {
            break;
        }
        echo "<h4 class='c_head'>{$div->nodeValue}</h4>";
        ++$i;
    }
}

// Get the page id by page template
function docly_get_page_template_id( $template = 'page-job-apply-form.php' ) {
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => $template
    ));
    foreach ( $pages as $page ) {
        $page_id = $page->ID;
    }
    return $page_id;
}

// Arrow icon left right position
function docly_arrow_left_right() {
    $arrow_icon = is_rtl() ? 'arrow_left' : 'arrow_right';
    echo esc_attr($arrow_icon);
}

/**
 * Decode Docly du
 */
function docly_decode_du( $str ) {
	$str = str_replace('cZ5^9o#!', 'wordpress-theme.spider-themes.net', $str);
	$str = str_replace('aI7!8B4H', 'resources', $str);
	$str = str_replace('^93|3d@', 'https', $str);
	$str = str_replace('t7Cg*^n0', 'docly', $str);
	$str = str_replace('3O7%jfGc', '.zip', $str);
	return urldecode($str);
}

/**
 * Is titlebar
 */
function docly_is_titlebar() {
    $header_type = function_exists('get_field' ) ? get_field('header_type' ) : '';
    $is_titlebar = is_404() || is_search() || (!isset($header_type) && is_page()) || ( is_archive() && !in_array('bbpress', get_body_class()) );
    return $is_titlebar;
}


function docly_get_breadcrumb_item($label, $permalink, $position = 1)
{
    return '<li class="breadcrumb-item ex-class" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <a itemprop="item" href="' . esc_attr($permalink) . '">
        <span itemprop="name">' . esc_html($label) . '</span></a>
        <meta itemprop="position" content="' . $position . '" />
    </li>';
}


/**
 * Banner breadcrumbs
 */
function docly_post_breadcrumbs() {
    $opt = get_option('docly_opt');
    if ( is_home() ) {
        $title = $opt['blog_title'] ?? esc_html__('Blog', 'docly');
    } else {
        $title = get_the_title();
    }
    if ( in_array('bbpress', get_body_class()) ) {
        bbp_breadcrumb(array(
            'before' => '<ol class="breadcrumb"> <li class="breadcrumb-item">',
            'sep_before' => '',
            'sep' => '</li><li class="breadcrumb-item">',
            'sep_after' => '',
            'current_before' => '',
            'current_after' => '',
            'after' => '</li></ol>',
            'home_text' => esc_html__('Home', 'docly')
        ));
    } elseif ( is_singular('docs') || in_array('docs', get_post_class()) ) {
        eazydocs_breadcrumbs();
    } elseif ( in_array('type-topic', get_post_class()) ) {
        bbp_breadcrumb();
    } else {
        ?>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo esc_url(home_url('/')) ?>"> <?php esc_html_e( 'Home', 'docly' ); ?> </a>
            </li>
            <?php if ( !is_archive() && !is_home() ) : ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo get_post_type_archive_link(get_post_type(get_the_ID())) ?>">
                        <?php
                        if ( !empty($opt['doc_slug']) && is_singular('docs') ) {
                            echo ucwords(esc_html($opt['doc_slug']));
                        } else {
                            echo ucwords( get_post_type( get_the_ID() ) );
                        }
                        ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( is_archive() && !is_home() ) : ?>
                <li class="breadcrumb-item active">
                    <?php echo ucwords(get_post_type()); ?>
                </li>
            <?php endif; ?>
            <?php if ( is_home() ) : ?>
                <li class="breadcrumb-item active">
                    <?php esc_html_e('Blog', 'docly'); ?>
                </li>
            <?php endif; ?>
            <?php if ( is_single() ) : ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php echo esc_html($title) ?>
                </li>
            <?php endif; ?>
        </ol>
        <?php
    }
}

function docly_topic_badges() {
    if( bbp_is_topic_sticky(get_the_ID()) ) { ?>
        <span class="badge badge-success">
            <?php esc_html_e( 'Sticky', 'docly' ); ?>
        </span>
    <?php }
    if ( bbp_is_topic_closed(get_the_ID()) ) { ?>
        <span class="badge badge-danger">
            <?php esc_html_e( 'Closed', 'docly' ); ?>
        </span>
    <?php }
}

add_filter('bbp_theme_after_topic_title', 'docly_topic_badges' );