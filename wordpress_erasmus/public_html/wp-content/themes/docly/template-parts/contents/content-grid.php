<?php
$thumb_size = is_active_sidebar( 'sidebar_widgets' ) ? 'docly_370x220' : 'full';
$opt = get_option('docly_opt');
$post_title_length = isset($opt['post_title_length']) ? $opt['post_title_length'] : '';
$is_post_meta = isset($opt['is_post_meta']) ? $opt['is_post_meta'] : '1';
$is_post_date = isset($opt['is_post_date']) ? $opt['is_post_date'] : '1';
$is_post_reading_time = isset($opt['is_post_reading_time']) ? $opt['is_post_reading_time'] : '1';
$is_post_cat = isset($opt['is_post_cat']) ? $opt['is_post_cat'] : '1';
$is_post_author = isset($opt['is_post_author']) ? $opt['is_post_author'] : '1';
$post_author_id = get_post_field( 'post_author', get_the_ID() );
$blog_column = !empty($opt['blog_column']) ? $opt['blog_column'] : '6';

if ( !empty($_GET['blog_layout']) && $_GET['blog_layout'] == 'blog_category' ) {
    $blog_column = '4';
}

?>

<div class="col-lg-<?php echo esc_attr( $blog_column ) ?> col-sm-6">
    <div class="blog_grid_post wow fadeInUp bs-sm">
        <?php
        if ( !is_search() ) {
            the_post_thumbnail($thumb_size);
        }
        ?>
        <div class="grid_post_content">
            <div class="post_tag">
                <?php
                if ( $is_post_reading_time == '1' ) {
                    if ( $is_post_meta == '1' ) { ?>
                        <a href="#"><?php Docly_helper()->reading_time(); ?></a>
                        <?php
                    }
                }
                if ( $is_post_cat == '1' ) {
                    if ( $is_post_meta == '1' && has_category() ) { ?>
                        <a class="c_blue" href="<?php Docly_helper()->first_category_link(); ?>">
                            <?php Docly_helper()->first_category(); ?>
                        </a>
                        <?php
                    }
                }
                ?>
            </div>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>">
                <h4 class="b_title"> <?php Docly_helper()->limit_latter(get_the_title(), $post_title_length, ''); ?> </h4>
            </a>
            <?php
            echo strip_shortcodes( Docly_helper()->excerpt( 'blog_excerpt', false ) );
            if ( $is_post_author == '1' ) {
                if ( $is_post_meta == '1' ) {
                    ?>
                    <div class="media post_author">
                        <div class="round_img">
                            <?php Docly_helper()->post_author_avatar(); ?>
                        </div>
                        <div class="media-body author_text">
                            <h4><?php echo get_the_author_meta('display_name') ?></h4>
                            <?php
                            if ( $is_post_date == '1' ) {
                                if ( $is_post_meta == '1' ) { ?>
                                    <div class="date"> <?php the_time(get_option('date_format')); ?> </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

