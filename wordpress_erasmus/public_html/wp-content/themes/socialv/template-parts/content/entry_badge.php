<?php

/**
 * Achievement template
 *
 * This template can be overridden by copying it to yourtheme/gamipress/achievement.php
 * To override a specific achievement type just copy it as yourtheme/gamipress/achievement-{achievement-type}.php
 */

?>
<div id="gamipress-achievement-<?php the_ID(); ?>" class="socialv-gamipress-achievement col-md-4 socialv-blog-box">

    <div class="badge-box text-center">

        <?php if (has_post_thumbnail()) : ?>
            <div class="gamipress-achievement-image badge-icon">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('thumbnail', array('class' => 'avatar-65')); ?></a>
            </div>
        <?php endif; ?>
        <div class="gamipress-achievement-description badge-details">

            <h5 class="badge-title">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </h5>

            <div class="badge-desc">
                <?php
                $excerpt = has_excerpt() ? gamipress_get_post_field('post_excerpt', get_the_ID()) : gamipress_get_post_field('post_content', get_the_ID());
                echo wpautop(do_blocks(apply_filters('get_the_excerpt', $excerpt, get_post())));
                ?>
            </div>
        </div>

    </div>
</div><!-- .gamipress-achievement -->