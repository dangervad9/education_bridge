<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package docly
 */

/**
 * Theme Options
 */
$opt = get_option('docly_opt' );
$is_back_to_top_btn_switcher = $opt['is_back_to_top_btn_switcher'] ?? '1';

/**
 * Page Options
 */
$footer_visibility = function_exists('get_field') ? get_field('footer_visibility') : '1';
if ( !isset($footer_visibility) ) {
    $footer_visibility = '1';
}

    if ( $footer_visibility == '1' ) {
        if ( is_singular('docs') ) {
            $footer_style = !empty($opt['doc_footer']) ? $opt['doc_footer'] : 'simple';
        } else {
            $footer_style = !empty($opt['footer_style']) ? $opt['footer_style'] : 'normal';
        }
        $copyright_text = !empty($opt['copyright_txt']) ? $opt['copyright_txt'] : esc_html__('©2021 CreativeGigs. All rights reserved', 'docly');
        $footer_visibility = function_exists('get_field') ? get_field('footer_visibility') : '1';
        $footer_visibility = $footer_visibility ?? '1';

        get_template_part('template-parts/footers/footer', $footer_style);

        /**
         * Tooltips
         */
        $is_tooltips = function_exists('get_field') ? get_field('is_tooltips') : '';
        if ( $is_tooltips == '1' ) {
            get_template_part('template-parts/tooltips');
        }
    }
    ?>
    <div class="popup__post">
    </div>

<?php if ( !is_singular('docs') ) : ?>
    </div> <!-- Body Wrapper -->
<?php endif; ?>

    <div class="tooltip_templates d-none">
        <div id="popup_view" class="tip_content">
        </div>
    </div>
    
<?php if ( $is_back_to_top_btn_switcher == '1' ) : ?>
    <a id="back-to-top" title="Back to Top"></a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>