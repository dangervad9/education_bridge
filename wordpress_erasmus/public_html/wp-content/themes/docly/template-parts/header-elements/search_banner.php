<?php
$opt = get_option('docly_opt');

// EazyDocs settings
$ezd_opt = get_option( 'eazydocs_settings' );
$doc_width = $ezd_opt['docs_page_width'] ?? '';
if ( is_singular('docs') ) {
    $doc_container = $doc_width == 'full-width' ? 'container-fluid px-lg-5' : 'container custom_container';
} else {
    $doc_container = 'container custom_container';
}

if ( is_home() ) {
    $title = !empty($opt['blog_title']) ? $opt['blog_title'] : esc_html__('Blog', 'docly');
} else {
    $title = get_the_title();
}

/**
 * Doc Mobile Menu
 */
if ( is_singular('docs') ) {
    get_template_part('template-parts/header-elements/doc-mobile-menu');
}

$breadcrumb_container = is_singular('docs') || is_post_type_archive('docs') ? 'custom_container' : '';
$is_breadcrumb = $opt['is_breadcrumb'] ?? '1';
$placeholder = !empty($opt['banner_search_placeholder']) ? $opt['banner_search_placeholder'] : '';
$is_focus_search = $opt['is_focus_search'] ?? '';
$is_focus_search = $is_focus_search == '1' ? 'focused-form' : '';

if ( class_exists('bbPress') ) {
	if ( is_singular( 'topic' ) || bbp_is_forum_archive() ) {
		$search_name = 'bbp_search';
	} else {
		$search_name = 's';
	}
} else {
	$search_name = 's';
}
?>

<section class="breadcrumb_area">
    <?php
    Docly_helper()->image_from_settings('sbanner_left_image', 'p_absolute bl_left', 'leaf');
    Docly_helper()->image_from_settings('sbanner_right_image', 'p_absolute bl_right', 'leaf');
    Docly_helper()->image_from_settings('sbanner_bg_image', 'p_absolute star', 'leaf');
    Docly_helper()->image_from_settings('sbanner_man_image', 'p_absolute one wow fadeInRight', 'Man illustration');
    Docly_helper()->image_from_settings('sbanner_flower_image', 'p_absolute two wow fadeInUp', 'Flower illustration');
    ?>
    <div class="container custom_container">
        <form action="<?php echo esc_url(home_url('/')) ?>" role="search" method="get" class="banner_search_form banner_search_form_two <?php echo esc_attr($is_focus_search) ?>">
            <div class="input-group">

                <?php if ( class_exists('bbpress') ) : ?>
                    <?php if ( bbp_is_search_results() ) : ?>
                        <input type="hidden" name="action" value="bbp-search-request" />
                        <?php endif; ?>
                <?php endif; ?>

                <input type="search" id="searchInput" class="form-control" name="<?php echo esc_attr($search_name) ?>" placeholder="<?php echo esc_attr($placeholder) ?>" autocomplete="off">

                <?php
                if ( is_singular('docs') || is_post_type_archive('docs') ) :
                    ?>
                    <input type="hidden" name="post_type" value="docs" />
                    <?php
                    $is_search_doc_dropdown = isset($opt['is_search_doc_dropdown']) ? $opt['is_search_doc_dropdown'] : '1';
                    if ( $is_search_doc_dropdown == '1' ) :
                        ?>
                        <div class="input-group-append">
                            <?php
                            $dropdown_args = array(
                                'post_type'         => 'docs',
                                'echo'              => 0,
                                'depth'             => 1,
                                'show_option_none'  => esc_html__( 'All Docs', 'docly' ),
                                'option_none_value' => 'all',
                                'name'              => 'search_in_doc',
                                'class'             => 'custom-select',
                                'id'                => 'inlineFormCustomSelect',
                            );
                            if ( isset( $_GET['search_in_doc'] ) && 'all' != $_GET['search_in_doc'] ) {
                                $dropdown_args['selected'] = (int) $_GET['search_in_doc'];
                            }
                            echo wp_dropdown_pages( $dropdown_args );
                            ?>
                        </div>
                        <?php
                    endif;
                endif;
                ?>
                <button type="submit"><i class="icon_search"></i></button>
            </div>

            <?php if ( is_singular('docs') || is_post_type_archive('docs') ) : ?>
                <div id="docly-search-result" data-noresult="<?php esc_attr_e('No Results Found', 'docly'); ?>"></div>
            <?php endif; ?>

	        <?php
            $is_keywords = isset($opt['is_keywords']) ? $opt['is_keywords'] : '';
            if ( $is_keywords == '1' ) :
            if ( is_singular('docs') || is_post_type_archive('docs') ) :
                ?>
                <div class="header_search_keyword">
			        <?php if ( !empty($opt['keywords_label']) ) : ?>
                        <span class="header-search-form__keywords-label"> <?php echo esc_html($opt['keywords_label']) ?> </span>
			        <?php endif; ?>
			        <?php if ( !empty($opt['doc_keywords']) ) : ?>
                        <ul class="list-unstyled">
					        <?php
					        foreach ( $opt['doc_keywords'] as $keyword ) :
						        ?>
                                <li class="wow fadeInUp" data-wow-delay="0.2s">
                                    <a href="#"> <?php echo esc_html($keyword); ?> </a>
                                </li>
					        <?php endforeach; ?>
                        </ul>
			        <?php endif; ?>
                </div>
	        <?php endif; ?>
	        <?php endif; ?>
        </form>
    </div>
</section>

<?php
if ( $is_breadcrumb == '1' ) :
    if ( is_singular('docs') ) {
        $docs_home = function_exists('ezd_get_opt') ? ezd_get_opt( 'docs_home', 'eazydocs_settings' ) : '';
        $archive_url = get_permalink( $docs_home );
    } else {
        $archive_url = get_post_type_archive_link(get_post_type(get_the_ID()));
    }
    ?>

    <section class="page_breadcrumb">
        <div class="<?php echo esc_attr($doc_container) ?>">
            <div class="row">
                <div class="col-sm-8 col-md-9">
                    <nav aria-label="breadcrumb">
                        <?php docly_post_breadcrumbs(); ?>
                    </nav>
                </div>
                <div class="col-sm-4 col-md-3">
                    <?php
                    $breadcrumb_date = !empty($opt['breadcrumb_date']) ? $opt['breadcrumb_date'] : '';
                    ?>
                    <span class="date">
                            <i class="<?php echo is_rtl() ? 'icon_quotations' : 'icon_clock_alt'; ?>"></i>
                        <?php if ( $breadcrumb_date == 'modified' ) : ?>
                            <?php esc_html_e( 'Updated on', 'docly' ); ?>
                            <?php
                            $modified_date = '';
                            $recent_posts = wp_get_recent_posts(array(
                                'numberposts' => 1, // Number of recent posts thumbnails to display
                                'post_status' => 'publish' // Show only the published posts
                            ));
                            foreach ( $recent_posts as $recent_post ) {
                                $modified_date = get_the_time(get_option('date_format'), $recent_post['ID']);
                            }
                            if ( is_home() ) {
                                echo esc_html($modified_date);
                            } else {
                                the_modified_date( get_option('date_format') );
                            }
                            ?>
                        <?php
                        else :
                            esc_html_e( 'Posted on ', 'docly');
                            the_time(get_option('date_format'));
                        endif;
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </section>
    <?php
endif;