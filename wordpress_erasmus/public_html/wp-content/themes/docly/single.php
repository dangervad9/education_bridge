<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package docly
 */

get_header();

$opt = get_option('docly_opt' );
$is_related = !empty($opt['is_related_posts']) ? $opt['is_related_posts'] : '';
$blog_column = is_active_sidebar( 'sidebar_widgets' ) ? '8' : '12';
$elementor_library = $_GET['elementor_library'] ?? '';
$is_single_post_date = $opt['is_single_post_date'] ?? '1';
?>

<section class="blog_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-<?php echo esc_attr($blog_column) ?>">
                <div class="blog_single_info">
                    <div class="blog_single_item">
                        <?php
                        while ( have_posts() ) : the_post();
                            $user_desc = get_the_author_meta( 'description' );
                            the_content();
                            wp_link_pages( array(
                                'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'docly' ) . '</span>',
                                'after'       => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                                'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'docly' ) . ' </span>%',
                                'separator'   => '<span class="screen-reader-text">, </span>',
                            ));
                        endwhile;
                        ?>
                    </div>

                    <?php if ( has_tag() ) : ?>
                        <div class="single_post_tags post-tags">
                            <?php the_tags(esc_html__( 'Tags : ', 'docly' ), ' ' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    // Post share
                    if ( class_exists('Docly_core') ) {
                        doclycore_social_share();
                    }

                    if ( !empty($user_desc) ) :
                        ?>
                        <div class="blog_post_author media">
                            <div class="author_img">
                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>">
                                    <?php Docly_helper()->post_author_avatar(70); ?>
                                </a>
                            </div>
                            <div class="media-body">
                                <h5>
                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>">
                                        <?php echo get_the_author_meta('display_name') ?>
                                    </a>
                                </h5>
                                <?php echo wp_kses_post(wpautop($user_desc)) ?>
                            </div>
                        </div>
                        <?php
                    endif;

                    // Related posts
                    if ( is_singular('post') ) {
	                    get_template_part( 'template-parts/single-post/related-posts' );
                    }

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                    ?>
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>

<?php
get_footer();