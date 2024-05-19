<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package docly
 */

get_header();
$blog_column = is_active_sidebar( 'sidebar_widgets' ) ? '8' : '12';
$blog_layout = !empty($opt['blog_layout']) ? $opt['blog_layout'] : 'list';
?>
<section class="doc_blog_classic_area sec_pad">
    <div class="container">
        <div class="row">
            <div class="col-lg-<?php echo esc_attr($blog_column) ?>">
                <?php
                if ( have_posts() ) {
                    while (have_posts()) : the_post();
                        get_template_part('template-parts/contents/content', get_post_format());
                    endwhile;
                }
                else {
                    get_template_part( 'template-parts/contents/content', 'none' );
                }
                Docly_helper()->pagination();
                ?>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>

<?php
get_footer();