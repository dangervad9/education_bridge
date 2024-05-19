<?php
$thumb_size = is_active_sidebar( 'sidebar_widgets' ) ? 'docly_670x450' : 'full';
$opt = get_option('docly_opt');
$blog_continue_read = !empty($opt['blog_continue_read']) ? $opt['blog_continue_read'] : esc_html__( 'Continue Reading', 'docly' );
$is_post_meta = isset($opt['is_post_meta']) ? $opt['is_post_meta'] : '1';
$is_post_date = isset($opt['is_post_date']) ? $opt['is_post_date'] : '1';
$is_post_reading_time = isset($opt['is_post_reading_time']) ? $opt['is_post_reading_time'] : '1';
$is_post_cat = isset($opt['is_post_cat']) ? $opt['is_post_cat'] : '1';
$is_post_author = isset($opt['is_post_author']) ? $opt['is_post_author'] : '1';
$blog_column = !empty($opt['blog_column']) ? $opt['blog_column'] : '6';
?>

<?php

if ( is_sticky() ) {
    ?>
    <section class="blog_top_post_area sec_pad bg_color">
        <div class="container">
            <div class="row blog_top_post shadow-lg flex-row-reverse">
                <div class="col-lg-7 p_top_img">
                    <?php
                    the_post_thumbnail( $thumb_size, array( 'class' => 'p_img' ) );
                    ?>
                </div>
                <div class="col-lg-5 p-0">
                    <div class="b_top_post_content">
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
                        <a href="<?php the_permalink(); ?>">
                            <h3> <?php the_title() ?> </h3>
                        </a>
                        <?php echo strip_shortcodes( Docly_helper()->excerpt( 'blog_excerpt', false) ); ?>
                        <a href="<?php the_permalink(); ?>" class="learn_btn">
                            <?php echo esc_html($blog_continue_read) ?><i class="<?php docly_arrow_left_right() ?>"></i>
                        </a>
                        <?php
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
                                                <div class="date"><?php the_time(get_option('date_format')); ?></div>
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
        </div>
    </section>
    <?php
}