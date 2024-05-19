<?php
// Theme settings options
$opt = get_option('docly_opt' );

$is_forums_in_topics = isset($opt['is_forums_in_topics']) ? $opt['is_forums_in_topics'] : '';

if ( $is_forums_in_topics == '1' ) :
	$forums = new WP_Query( array(
		'post_type' => 'forum',
		'posts_per_page' => !empty($opt['forums_ppp_in_topics']) ? $opt['forums_ppp_in_topics'] : 4,
	));
    ?>
    <div class="communities-boxes">
        <?php
        while($forums->have_posts()) : $forums->the_post();
            ?>
            <div class="docly-com-box">
                <div class="icon-container">
                    <?php the_post_thumbnail('full'); ?>
                </div>
                <div class="docly-com-box-content">
                    <h3 class="title">
                        <a href="<?php the_permalink(); ?>"> <?php the_title() ?> </a>
                    </h3>
                    <p class="total-post"><?php bbp_forum_topic_count(get_the_ID()); ?> <?php esc_html_e('Posts', 'docly') ?></p>
                </div>
                <!-- /.docly-com-box-content -->
            </div>
            <!-- /.docly-com-box -->
            <?php
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
    <?php
endif;