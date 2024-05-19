<?php

/**
 * BuddyPress - Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use function SocialV\Utility\socialv;

$post_section = socialv()->post_style(); ?>

<div class="row <?php echo esc_attr($post_section['row_reverse']); ?>">
    <?php socialv()->socialv_the_layout_class(); ?>
    <div class="socialv-members-main-page socialv-bp-main-primary">
        <?php
        do_action('bp_before_directory_members_page'); ?>

        <div id="buddypress">

            <?php do_action('bp_before_directory_members'); ?>

            <?php do_action('bp_before_directory_members_content'); ?>

            <?php if (has_filter('bp_directory_members_search_form')) : ?>

                <div class="card-main socialv-search-main">
                    <div class="card-inner">
                        <div id="members-dir-search" class="dir-search">
                            <?php bp_directory_members_search_form(); ?>
                        </div>
                    </div>
                </div><!-- #members-dir-search -->

            <?php else : ?>

                <div class="card-main socialv-search-main">
                    <div class="card-inner">
                        <div class="socialv-bp-searchform">
                            <?php bp_get_template_part('common/search/dir-search-form'); ?>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

            <?php do_action('bp_before_directory_members_tabs'); ?>
            <div class="card-main card-space">
                <div class="card-inner pt-0">

                    <form method="post" id="members-directory-form" class="dir-form">
                        <div class="Members-directory">
                            <div class="row align-items-center">
                                <div class="col-md-7 col-12 item-list-tabs" >
                                    <div class="socialv-subtab-lists">
                                        <div class="left" onclick="slide('left',event)">
                                            <i class="iconly-Arrow-Left-2 icli"></i>
                                        </div>
                                        <div class="right" onclick="slide('right',event)">
                                            <i class="iconly-Arrow-Right-2 icli"></i>
                                        </div>
                                        <div class="socialv-subtab-container custom-nav-slider">
                                            <ul class="list-inline m-0">
                                                <li class="selected" id="members-all"><a href="<?php bp_members_directory_permalink(); ?>"><?php esc_html_e('All Members', 'socialv'); ?></a><span class="count"><?php echo bp_core_get_active_member_count(); ?></span></li>

                                                <?php if (is_user_logged_in() && bp_is_active('friends') && bp_get_total_friend_count(bp_loggedin_user_id())) : ?>
                                                    <li id="members-personal"><a href="<?php echo esc_url(bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/'); ?>"><?php esc_html_e('My Friends', 'socialv'); ?></a><span class="count"><?php echo bp_get_total_friend_count(bp_loggedin_user_id()); ?></span></li>
                                                <?php endif; ?>

                                                <?php

                                                /**
                                                 * Fires inside the members directory member types.
                                                 *
                                                 * @since 1.2.0
                                                 */
                                                do_action('bp_members_directory_member_types'); ?>

                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .item-list-tabs -->

                                <div class="col-md-5 col-12 item-list-filters" id="subnav" >
                                    <ul class="list-inline m-0">
                                        <?php

                                        /**
                                         * Fires inside the members directory member sub-types.
                                         *
                                         * @since 1.5.0
                                         */
                                        do_action('bp_members_directory_member_sub_types'); ?>

                                        <li id="members-order-select" class="last filter  socialv-data-filter-by position-relative border-start-0">
                                            <label class="me-2" for="members-order-by"><?php esc_html_e('Show By:', 'socialv'); ?></label>
                                            <select id="members-order-by">
                                                <option value="active"><?php esc_html_e('Last Active', 'socialv'); ?></option>
                                                <option value="newest"><?php esc_html_e('Newest Registered', 'socialv'); ?></option>

                                                <?php if (bp_is_active('xprofile')) : ?>
                                                    <option value="alphabetical"><?php esc_html_e('Alphabetical', 'socialv'); ?></option>
                                                <?php endif; ?>

                                                <?php

                                                /**
                                                 * Fires inside the members directory member order options.
                                                 *
                                                 * @since 1.2.0
                                                 */
                                                do_action('bp_members_directory_order_options'); ?>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <h2 class="bp-screen-reader-text"><?php
                                                            /* translators: accessibility text */
                                                            esc_html_e('Members directory', 'socialv');
                                                            ?></h2>

                        <div id="members-dir-list" class="members dir-list  clearfix">
                            <?php bp_get_template_part('members/members-loop'); ?>
                        </div><!-- #members-dir-list -->

                        <?php do_action('bp_directory_members_content'); ?>

                        <?php wp_nonce_field('directory_members', '_wpnonce-member-filter'); ?>

                        <?php do_action('bp_after_directory_members_content'); ?>

                    </form>
                </div>
            </div>
            <!-- #members-directory-form -->

            <?php do_action('bp_after_directory_members'); ?>

        </div><!-- #buddypress -->

        <?php do_action('bp_after_directory_members_page'); ?>
    </div>
    <?php socialv()->socialv_sidebar(); ?>
</div>