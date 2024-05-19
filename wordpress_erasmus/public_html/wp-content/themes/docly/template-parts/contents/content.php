<?php
$thumb_size = is_active_sidebar( 'sidebar_widgets' ) ? 'docly_770x400' : 'full';
$opt = get_option('docly_opt');
$blog_continue_read = !empty($opt['blog_continue_read']) ? $opt['blog_continue_read'] : esc_html__( 'Continue Reading', 'docly' );
$post_title_length = isset($opt['post_title_length']) ? $opt['post_title_length'] : '';
$is_post_meta = isset($opt['is_post_meta']) ? $opt['is_post_meta'] : '1';
$is_post_date = isset($opt['is_post_date']) ? $opt['is_post_date'] : '1';
$is_post_reading_time = isset($opt['is_post_reading_time']) ? $opt['is_post_reading_time'] : '1';
$is_post_cat = isset($opt['is_post_cat']) ? $opt['is_post_cat'] : '1';
$is_post_author = isset($opt['is_post_author']) ? $opt['is_post_author'] : '1';
$post_author_id = get_post_field( 'post_author', get_the_ID() );
?>
<div <?php post_class('blog_top_post blog_classic_item bs-sm h:bs-lg'); ?>>
    <?php
    if ( !is_search() ) {
        the_post_thumbnail($thumb_size);
    }
    ?>
    <div class="b_top_post_content">
        <?php
        if ( is_sticky() ) {
            echo '<p class="sticky-label">'.esc_html__( 'Featured', 'docly' ).'</p>';
        }
        ?>
        <div class="post_tag">
            <?php
            if ( $is_post_date == '1' ) {
                if ( $is_post_meta == '1' ) { ?>
                    <a href="<?php Docly_helper()->day_link(); ?>"><?php the_time(get_option('date_format')); ?></a>
                    <?php
                }
            }
            if ( $is_post_reading_time == '1' ) {
                if ( $is_post_meta == '1' ) { ?>
                    <a href="#"> <?php Docly_helper()->reading_time(); ?> </a>
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
            <h3><?php the_title() ?></h3>
        </a>
        <?php echo strip_shortcodes(Docly_helper()->excerpt( 'blog_excerpt', false)); ?>
        <div class="d-flex justify-content-between p_bottom">
            <a href="<?php the_permalink(); ?>" class="learn_btn">
                <?php echo esc_html($blog_continue_read) ?>
                <i class="<?php docly_arrow_left_right() ?>"></i>
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
                            <a href="<?php echo get_author_posts_url($post_author_id) ?>">
                                <h4><?php echo get_the_author_meta('display_name') ?></h4>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>