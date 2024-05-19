<?php
/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_forums_loop' ); ?>

<div class="post-header forums-header">
    <div class="col-md-6 col-sm-6 support-info">
        <span> <?php esc_html_e( 'Forum', 'docly' ); ?> </span>
    </div>
    <!-- /.support-info -->
    <div class="col-md-6 col-sm-6 support-category-menus">
        <ul class="forum-titles">
            <li class="forum-topic-count"> <?php esc_html_e( 'Topics', 'docly' ); ?> </li>
            <li class="forum-reply-count"> <?php bbp_show_lead_topic() ? esc_html_e( 'Replies', 'docly' ) : esc_html_e( 'Posts',   'docly' ); ?> </li>
            <li class="forum-freshness"> <?php esc_html_e( 'Last Post', 'docly' ); ?> </li>
        </ul>
    </div>
    <!-- /.support-category-menus -->
</div>

<div class="community-posts-wrapper bb-radius">
    <?php while ( bbp_forums() ) : bbp_the_forum(); ?>
        <?php bbp_get_template_part( 'loop', 'single-forum' ); ?>
    <?php endwhile; ?>
</div>

<?php do_action( 'bbp_template_after_forums_loop' );
