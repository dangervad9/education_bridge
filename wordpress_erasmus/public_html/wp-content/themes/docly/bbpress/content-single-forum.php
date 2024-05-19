<?php

/**
 * Single Forum Content Part
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
        if ( !bbp_is_forum_category() ) {
            get_template_part('template-parts/forum/forums-grid');
        }
        ?>

        <?php
        if ( $is_forum_top_c2a == '1' ) {
            get_template_part('template-parts/forum/c2a-top');
        }
        ?>

        <?php do_action( 'bbp_template_before_single_forum' ); ?>

        <?php if ( post_password_required() ) : ?>

            <?php bbp_get_template_part( 'form', 'protected' ); ?>

        <?php else : ?>

            <?php bbp_single_forum_description(); ?>

            <?php if ( bbp_has_forums() ) : ?>

                <?php bbp_get_template_part( 'loop', 'forums' ); ?>

            <?php endif; ?>

            <?php if ( ! bbp_is_forum_category() && bbp_has_topics() ) : ?>

                <?php bbp_get_template_part( 'loop',       'topics'    ); ?>

                <?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

                <?php bbp_get_template_part( 'form',       'topic'     ); ?>

            <?php elseif ( ! bbp_is_forum_category() ) : ?>

                <?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>

                <?php bbp_get_template_part( 'form',       'topic'     ); ?>

            <?php endif; ?>

        <?php endif; ?>

        <?php do_action( 'bbp_template_after_single_forum' ); ?>
    </div>

    <?php get_sidebar('forum'); ?>

</div>
