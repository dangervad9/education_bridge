<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<div id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class('', array('community-post', 'style-two', 'forum-item') ); ?>>

    <?php do_action( 'bbp_theme_before_forum_title' ); ?>

    <div class="col-md-6 post-content">
        <?php if ( has_post_thumbnail(get_the_ID()) ) : ?>
            <div class="author-avatar forum-icon">
                <?php the_post_thumbnail('full'); ?>
            </div>
        <?php endif; ?>
        <div class="entry-content">
            <a href="<?php bbp_forum_permalink(); ?>">
                <h3 class="post-title"> <?php bbp_forum_title(); ?> </h3>
                <?php do_action( 'bbp_theme_after_topic_title' ); ?>
            </a>
            <p> <?php bbp_forum_content(); ?> </p>
        </div>
    </div>

    <div class="col-md-6 post-meta-wrapper">
        <ul class="forum-titles">
            <li class="forum-topic-count"> <?php bbp_forum_topic_count(); ?> </li>
            <li class="forum-reply-count"> <?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?> </li>
            <li class="forum-freshness">
                <div class="freshness-box">
                    <div class="freshness-top">
                        <div class="freshness-link">
                            <?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>
                            <?php bbp_forum_freshness_link(); ?>
                            <?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>
                        </div>
                    </div>
                    <div class="freshness-btm">
                        <?php do_action( 'bbp_theme_before_topic_author' ); ?>
                        <?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'type' => 'name' ) ); ?>
                        <?php do_action( 'bbp_theme_after_topic_author' ); ?>
                        <?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'size' => 45, 'type' => 'avatar' ) ); ?>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>