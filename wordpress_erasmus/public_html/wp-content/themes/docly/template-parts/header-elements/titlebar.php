<?php
// Theme settings options
$opt = get_option('docly_opt' );

$left_ornament = function_exists('get_field') ? get_field('left_ornament') : '1';
$is_banner = function_exists('get_field') ? get_field('is_banner') : '1';
$titlebar_align = !empty($opt['titlebar_align']) ? $opt['titlebar_align'] : '';
$is_banner_ornaments = $opt['is_banner_ornaments'] ?? '1';

if ( is_singular(array('docs','post', 'forum')) || is_404() || is_home() || is_post_type_archive( array('forum', 'topic') ) || is_singular('topic') ) {
    $is_banner = '';
}

if ( !isset($is_banner) || is_search() || is_page_template('page-onepage.php') ) {
	$is_banner = '1';
}

if ( class_exists('bbPress') ) {
	if ( bbp_is_search_results() ) {
		$is_banner = '';
	}
}

if ( class_exists('wooCommerce') ) {
    if ( is_shop() || is_singular('product') ) {
        $is_banner = '';
    }
}

if ( $is_banner == '1' ) :
    ?>
    <div class="breadcrumb_area_three">
        <?php
        if ( $is_banner_ornaments == '1' ) {
            Docly_helper()->image_from_settings('banner_left_ornament', 'p_absolute one', 'leaf left');
            Docly_helper()->image_from_settings('banner_right_ornament', 'p_absolute four', 'leaf right');
        }
        ?>
        <div class="container">
            <div class="breadcrumb_text text-<?php echo esc_attr($titlebar_align) ?>">
                <h2 class="text-<?php echo esc_attr($titlebar_align) ?>">
                    <?php Docly_helper()->banner_title() ?>
                </h2>
	            <?php Docly_helper()->banner_subtitle() ?>
            </div>
        </div>
    </div>
    <?php
endif;