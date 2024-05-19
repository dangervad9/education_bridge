<?php
$opt = get_option('docly_opt' );
$post_author_id = get_post_field( 'post_author', get_the_ID() );
?>
<section class="breadcrumb_area_two">
    <div class="container">
        <div class="breadcrumb_content">
            <?php the_title('<h1>', '</h1>') ?>
            <div class="single_post_author">
                <?php Docly_helper()->post_author_avatar(34); ?>
                <div class="text">
                    <a href="<?php echo get_author_posts_url($post_author_id); ?>">
                        <h4><?php echo get_the_author_meta('display_name', $post_author_id) ?></h4>
                    </a>
                    <div class="post_tag">
                        <a href="<?php Docly_helper()->day_link(); ?>">
                            <?php the_time(get_option('date_format')); ?>
                        </a>
                        <a href="#"> <?php Docly_helper()->reading_time(); ?> </a>
                        <div class="cats">
                            <?php the_category(','); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>