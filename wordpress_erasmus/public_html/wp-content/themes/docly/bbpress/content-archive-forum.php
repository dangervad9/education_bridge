<?php

/**
 * Archive Forum Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

$opt = get_option('docly_opt');
$is_forum_top_c2a = isset($opt['is_forum_top_c2a']) ? $opt['is_forum_top_c2a'] : '1';
$main_column = is_active_sidebar('forum_archive_sidebar') ? '8' : '12';
?>

<div class="row">
    <div class="col-lg-<?php echo esc_attr($main_column) ?>">
        <?php
        if ( $is_forum_top_c2a == '1' ) {
            get_template_part('template-parts/forum/c2a-top');
        }
        ?>

        <?php bbp_forum_subscription_link(); ?>

        <?php do_action( 'bbp_template_before_forums_index' ); ?>

        <?php if ( bbp_has_forums() ) : ?>

            <?php bbp_get_template_part( 'loop',     'forums'    ); ?>

        <?php else : ?>

            <?php bbp_get_template_part( 'feedback', 'no-forums' ); ?>

        <?php endif; ?>

        <?php do_action( 'bbp_template_after_forums_index' ); ?>
    </div>

    <?php get_sidebar('forum'); ?>

</div>