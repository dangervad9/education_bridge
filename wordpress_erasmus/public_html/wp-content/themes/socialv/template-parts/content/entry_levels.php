<?php

/**
 * Achievement template
 *
 * This template can be overridden by copying it to yourtheme/gamipress/achievement.php
 * To override a specific achievement type just copy it as yourtheme/gamipress/achievement-{achievement-type}.php
 */

?>
<div class="col-md-6">
    <div class="socialv-level-box badge-box text-center">
        <?php
        if (gamipress_bp_get_option('members_ranks_top_thumbnail', false) == 'on' && has_post_thumbnail()) : ?>
            <div class="gamipress-rank-image badge-icon">
                <?php the_post_thumbnail('thumbnail', array('class' => 'avatar-100')); ?>
            </div>
        <?php endif; ?>
        <div class="gamipress-rank-description badge-details">
            <?php if (gamipress_bp_get_option('members_ranks_top_title', false) == 'on') { ?>
                <h5 class="title">
                    <?php the_title(); ?>
                </h5>
            <?php }
            if (!empty(get_the_content())) {
                echo '<p class="content">' . get_the_content() . '</p>';
            } ?>
            <div class="socialv-level-requirements">
                <?php // Include output for our requirements
                echo gamipress_get_rank_requirements_list(get_the_ID()); ?>
            </div>
            <?php // Rank unlock with points
            echo gamipress_rank_unlock_with_points_markup(get_the_ID());


            // Earned Ranks
            if (!empty(gamipress_get_rank_earners(get_the_ID(), array()))) {
                echo '<div class="badge-member-info">';
                $rank_id = get_the_ID();
                $args = apply_filters('gamipress_get_rank_earners_list_args', array('limit' => 6), $rank_id);
                // Grab our users
                $earners = gamipress_get_rank_earners($rank_id, $args);
                // Only generate output if we have earners
                if (!empty($earners)) {
                    $heading_text = apply_filters('gamipress_rank_earners_heading', __('People who have this rank:', 'socialv'), $rank_id, $args);
                    $output = '<ul class="list-img-group list-inline m-0">';
                    foreach ($earners as $user) {
                        $user_url = get_author_posts_url($user->ID);
                        $user_url = apply_filters('gamipress_rank_earner_user_url', $user_url, $user->ID, $rank_id, $args);
                        $user_display = apply_filters('gamipress_rank_earner_user_display', $user->display_name, $user->ID, $rank_id, $args);
                        $user_content = '<li>'
                            . '<a href="' . $user_url . '">'
                            . get_avatar($user->ID)
                            . '</a>'
                            . '</li>';
                        $output .= $user_content;
                    }
                    $output .= '</ul>';
                    // Loop through each user and build our output
                    $output .= '<p class="socialv-achievement-earn-user mb-0">' . $heading_text . '</p>';
                    echo wp_kses_post($output);
                }

                do_action('gamipress_after_rank_earners', get_the_ID());
                echo '</div>';
            }
            ?>
        </div>

    </div>
</div>