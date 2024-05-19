<?php

/**
 * Pagination for pages of replies (when viewing a topic)
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_pagination_loop' ); ?>

<div class="pagination-wrapper">
    <div class="view-post-of">
        <p><?php bbp_topic_pagination_count(); ?></p>
    </div>
    <div class="bbp-pagination">
        <?php bbp_topic_pagination_links(); ?>
    </div>
</div>

<?php do_action( 'bbp_template_after_pagination_loop' );
