<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package docly
 */

get_header();
$opt = get_option('docly_opt' );
$blog_column = is_active_sidebar( 'sidebar_widgets' ) ? '8' : '12';
$blog_layout_opt = !empty($opt['blog_layout']) ? $opt['blog_layout'] : 'list';
$blog_layout = !empty($_GET['blog_layout']) ? $_GET['blog_layout'] : $blog_layout_opt;


if ( $blog_layout == 'list' ) {
    $sec_class  = 'doc_blog_classic_area sec_pad';
    $is_row = '';
}
elseif ( $blog_layout == 'grid' ) {
    $sec_class  = 'doc_blog_grid_area sec_pad';
    $is_row = '';
}
elseif ( $blog_layout == 'blog_category' ) {
    $sec_class  = 'doc_blog_grid_area';
    $is_row = ' blog_grid_tab';
}
else {
    $sec_class  = 'doc_blog_classic_area sec_pad';
    $is_row = '';
}
?>

<?php
// Is Sticky
if ( $blog_layout == 'blog_category' ) {
    while (have_posts()) : the_post();
        get_template_part( 'template-parts/contents/content-sticky' );
    endwhile;
}
?>

<section class="<?php echo esc_attr($sec_class) ?>">
    <?php
    if ( $blog_layout == 'blog_category' ) {
        get_template_part( 'template-parts/contents/blog-cats' );
    }
    ?>
    <div class="container">
        <div class="row <?php echo esc_attr( $is_row ) ?>">
            <?php
            if ( $blog_layout == 'list' ) {
                ?>
                <div class="col-lg-<?php echo esc_attr($blog_column) ?>">
                    <?php
                    while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/contents/content', get_post_format() );
                    endwhile;
                    Docly_helper()->pagination();
                    ?>
                </div>
                <?php
                get_sidebar();
            }
            elseif ( $blog_layout == 'grid' ) {
                ?>
                <div class="col-lg-<?php echo esc_attr($blog_column) ?>">
                    <div class="row">
                        <?php
                        while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/contents/content-grid', get_post_format());
                        endwhile;
                        ?>
                    </div>
                    <?php Docly_helper()->pagination(); ?>
                </div>
                <?php
                get_sidebar();
            }
            elseif ( $blog_layout == 'blog_category' ) {
                if ( !empty( $_GET['category'] ) ) {
                    $cat_posts = new WP_Query(
                        array(
                            'post_type' => 'post',
                            'posts_per_page' => -1,
                            'category_name' => $_GET['category'],
                            'ignore_sticky_posts' => 1
                        )
                    );
                } else {
                    $cat_posts = new WP_Query(
                        array(
                            'post_type' => 'post',
                            'posts_per_page' => -1,
                            'ignore_sticky_posts' => 1,
                            'post__not_in' => get_option("sticky_posts"),
                        )
                    );
                }
                while ( $cat_posts->have_posts() ) : $cat_posts->the_post();
                    get_template_part( 'template-parts/contents/content-grid', get_post_format());
                endwhile;
                echo '<div class="col-lg-12">';
                    Docly_helper()->pagination();
                echo '</div>';
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>
</section>

<?php
get_footer();