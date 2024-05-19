<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;
$favoriters = bbp_get_topic_favoriters();
$favorite_count = !empty($favoriters) ? $favoriters[0] : '0';
?>

<div id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class( '', array('community-posts-wrapper', 'bb-radius') ); ?>>
    <div class="community-post style-two">
        <div class="post-content">
            <div class="author-avatar">
                <?php echo get_avatar( get_the_author_meta('ID'), 40 ) ?>
            </div>
            <div class="entry-content">
                <h3 class="post-title">
                    <a href="<?php bbp_topic_permalink(); ?>"> <?php bbp_topic_title(); ?> </a>
                </h3>
                <?php do_action( 'bbp_theme_after_topic_title' ); ?>
                <ul class="meta">
                    <li>
                        <?php echo get_the_post_thumbnail(bbp_get_topic_forum_id(), 'docly_18x18'); ?>
                        <a href="<?php bbp_forum_permalink(bbp_get_topic_forum_id()); ?>">
                            <?php bbp_forum_title(bbp_get_topic_forum_id()); ?>
                        </a>
                    </li>
                    <li>
                        <i class="icon_calendar"></i>
                        <?php echo bbp_get_forum_last_active_time(bbp_get_topic_forum_id()) ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="post-meta-wrapper">
            <ul class="post-meta-info">
                <li>
                    <a href="<?php bbp_topic_permalink(); ?>">
                        <i class="icon_chat_alt"></i>
                        <?php bbp_show_lead_topic() ? bbp_topic_reply_count(get_the_ID()) : bbp_topic_post_count(get_the_ID()); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php bbp_topic_permalink(); ?>">
                        <i class="icon_star_alt"></i> <?php echo esc_html($favorite_count) ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>