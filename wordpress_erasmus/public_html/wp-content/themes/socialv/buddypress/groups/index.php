<?php

/**
 * BuddyPress - Groups
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires at the top of the groups directory template file.
 *
 * @since 1.5.0
 */

use function SocialV\Utility\socialv;

$post_section = socialv()->post_style();
?>
<div class="row <?php echo esc_attr($post_section['row_reverse']); ?>">
    <?php socialv()->socialv_the_layout_class(); ?>
    <div class="socialv-groups-main-page socialv-bp-main-primary">
        <?php
        do_action('bp_before_directory_groups_page'); ?>

        <div id="buddypress">

            <?php do_action('bp_before_directory_groups'); ?>

            <?php do_action('bp_before_directory_groups_content'); ?>

            <?php if (has_filter('bp_directory_groups_search_form')) : ?>
                <div class="card-main socialv-search-main">
                    <div class="card-inner">
                        <div id="group-dir-search" class="dir-search" >
                            <?php bp_directory_groups_search_form(); ?>
                        </div><!-- #group-dir-search -->
                    </div>
                </div>


            <?php else : ?>
                <div class="card-main socialv-search-main">
                    <div class="card-inner">
                        <div class="socialv-bp-searchform">
                            <?php bp_get_template_part('common/search/dir-search-form'); ?>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
            <div class="card-main">
                <div class="card-inner pt-0">
                    <form method="post" id="groups-directory-form" class="dir-form">
                        <div class="Members-directory">
                            <div class="row align-items-center">
                                <div class="col-md-7 col-12 item-list-tabs">
                                    <div class="socialv-subtab-lists">
                                        <div class="left" onclick="slide('left',event)">
                                            <i class="iconly-Arrow-Left-2 icli"></i>
                                        </div>
                                        <div class="right" onclick="slide('right',event)">
                                            <i class="iconly-Arrow-Right-2 icli"></i>
                                        </div>
                                        <div class="socialv-subtab-container custom-nav-slider">
                                            <ul class="list-inline m-0">
                                                <li class="selected" id="groups-all">
                                                    <a href="<?php bp_groups_directory_permalink(); ?>">
                                                        <?php
                                                        esc_html_e('All Groups', 'socialv');
                                                        ?>
                                                    </a>
                                                    <span class="count"><?php echo bp_get_total_group_count(); ?></span>
                                                </li>

                                                <?php if (is_user_logged_in() && bp_get_total_group_count_for_user(bp_loggedin_user_id())) : ?>
                                                    <li id="groups-personal">
                                                        <a href="<?php echo bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups/'; ?>">
                                                            <?php
                                                            esc_html_e('My Groups', 'socialv');
                                                            ?>
                                                        </a>
                                                        <span class="count"><?php echo bp_get_total_group_count_for_user(bp_loggedin_user_id()); ?></span>
                                                    </li>
                                                <?php endif; ?>

                                                <?php do_action('bp_groups_directory_group_filter'); ?>

                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .item-list-tabs -->
                                <div class="col-md-5 col-12 item-list-filters" id="subnav" aria-label="<?php esc_attr_e('Groups directory secondary navigation', 'socialv'); ?>" role="navigation">
                                    <ul class="list-inline m-0">
                                        <?php do_action('bp_groups_directory_group_types'); ?>

                                        <li id="groups-order-select" class="last filter socialv-data-filter-by position-relative">

                                            <label for="groups-order-by"><?php esc_html_e('Sort By:', 'socialv'); ?></label>

                                            <select id="groups-order-by">
                                                <option value="active"><?php esc_html_e('Last Active', 'socialv'); ?></option>
                                                <option value="popular"><?php esc_html_e('Most Members', 'socialv'); ?></option>
                                                <option value="newest"><?php esc_html_e('Newly Created', 'socialv'); ?></option>
                                                <option value="alphabetical"><?php esc_html_e('Alphabetical', 'socialv'); ?></option>

                                                <?php

                                                /**
                                                 * Fires inside the groups directory group order options.
                                                 *
                                                 * @since 1.2.0
                                                 */
                                                do_action('bp_groups_directory_order_options'); ?>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <h2 class="bp-screen-reader-text"><?php
                                                            /* translators: accessibility text */
                                                            esc_html_e('Groups directory', 'socialv');
                                                            ?></h2>

                        <div id="groups-dir-list" class="groups dir-list">
                            <?php bp_get_template_part('groups/groups-loop'); ?>
                        </div><!-- #groups-dir-list -->

                        <?php do_action('bp_directory_groups_content'); ?>

                        <?php wp_nonce_field('directory_groups', '_wpnonce-groups-filter'); ?>

                        <?php do_action('bp_after_directory_groups_content'); ?>

                    </form><!-- #groups-directory-form -->

                    <?php do_action('bp_after_directory_groups'); ?>
                </div>
            </div>


        </div><!-- #buddypress -->

        <?php
        do_action('bp_after_directory_groups_page');
        ?>
    </div>
    <?php socialv()->socialv_sidebar(); ?>
</div>