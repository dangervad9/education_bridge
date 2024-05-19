<?php

/**
 * Replies Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_replies_loop' );
$is_count = bbp_get_topic_reply_count(bbp_get_topic_id());
?>


    <div id="topic-<?php bbp_topic_id(); ?>-replies" class="all-answers">
        <h3 class="title"> <?php esc_html_e('All Replies', 'docly'); ?> </h3>

        <?php if ( bbp_thread_replies() ) : ?>

            <?php bbp_list_replies(); ?>

        <?php else : ?>

            <div class="topic_comments">
                <?php while ( bbp_replies() ) : bbp_the_reply(); ?>
                    <?php bbp_get_template_part( 'loop', 'single-reply' ); ?>
                <?php endwhile; ?>
            </div>

        <?php endif; ?>

        <?php bbp_get_template_part( 'pagination', 'replies' ); ?>

    </div>

<?php do_action( 'bbp_template_after_replies_loop' );
