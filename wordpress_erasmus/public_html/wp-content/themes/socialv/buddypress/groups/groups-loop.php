<?php

/**
 * BuddyPress - Groups Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter().
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use function SocialV\Utility\socialv;

/**
 * Fires before the display of groups from the groups loop.
 *
 * @since 1.2.0
 */
do_action('bp_before_groups_loop');

$socialv_options = get_option('socialv-options'); ?>
<?php if (bp_is_user()) : ?>
    <div class="card-head card-header-border ">
        <div class="row align-items-center justify-content-between">
            <div class="col-6">
                <div class="head-title">
                    <h5 class="card-title"><?php echo ((bp_get_total_group_count_for_user(bp_displayed_user_id()) == 1) ? esc_html__('Group', 'socialv') : esc_html__('Groups', 'socialv')); ?> <?php echo '(' . esc_html((bp_get_total_group_count_for_user(false) < 10) ? ('0' . bp_get_total_group_count_for_user(bp_displayed_user_id())) : bp_get_total_group_count_for_user(bp_displayed_user_id())) . ')';  ?></h5>
                </div>
            </div>
            <div class="col-6">
                <div class="socialv-groups-filter">
                    <ul class="list-grid-btn-switcher list-inline m-0 p-0 justify-content-end">
                        <li class="active">
                            <a class="user-view-trigger" href="javascript:void(0)" data-type="grid">
                                <i class="iconly-Category icli"></i>
                            </a>
                        </li>
                        <li>
                            <a class="user-view-trigger" href="javascript:void(0)" data-type="list">
                                <i class="iconly-Filter icli"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (bp_get_current_group_directory_type()) : ?>
    <p class="current-group-type"><?php bp_current_group_directory_type_message() ?></p>
<?php endif; ?>

<?php
$per_page = isset($socialv_options['default_post_per_page']) ? $socialv_options['default_post_per_page'] : 10;

if (bp_has_groups(bp_ajax_querystring('groups') . '&per_page=' . ($per_page))) : ?>
    <?php

    /**
     * Fires before the listing of the groups list.
     *
     * @since 1.1.0
     */
    do_action('bp_before_directory_groups_list'); ?>

    <div id="groups-list" class="socialv-groups-lists socialv-bp-main-box row">

        <?php while (bp_groups()) : bp_the_group(); ?>
            <div <?php bp_group_class(array('item-entry col-md-6 d-flex flex-column')); ?>>
                <div class="socialv-card socialv-group-info h-100">
                    <div class="top-bg-image">
                        <?php echo socialv()->socialv_group_banner_img(bp_get_group_id(), 'groups'); ?>
                        <?php if (bp_get_group_status() == 'private') {
                            echo '<div class="status"><i class="iconly-Lock icli"></i></div>';
                        } ?>
                    </div>
                    <div class="text-center">
                        <div class="group-header">
                            <?php if (!bp_disable_group_avatar_uploads()) : ?>
                                <div class="group-icon">
                                    <a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar('width=90&height=90&class=rounded'); ?></a>
                                </div>
                            <?php endif; ?>
                            <div class="group-name">
                                <h5 class="title"><?php bp_group_link(); ?></h5>
                            </div>
                        </div>
                        <div class="socialv-group-details d-inline-block">
                            <ul class="list-inline">
                                <li class="d-inline-block">
                                    <a href="<?php bp_group_permalink(); ?>"><span class="post-icon"><i class="iconly-Paper icli"></i></span><span class="item-number"><?php echo socialv()->socialv_group_posts_count(bp_get_group_id()); ?></span><span class="item-text"><?php echo ((socialv()->socialv_group_posts_count(bp_get_group_id()) == 1) ? esc_html__('Post', 'socialv') : esc_html__('Posts', 'socialv')); ?></span></a>
                                </li>
                                <li class="d-inline-block">
                                    <a href="<?php bp_group_permalink(); ?>">
                                        <span class="member-icon"><i class="iconly-User2 icli"></i></span>
                                        <span class="item-text">
                                            <?php
                                            echo ((bp_get_group_total_members(false) == 1) ? esc_html__('Member', 'socialv') : esc_html__('Members', 'socialv'));
                                            ?>
                                        </span>

                                        <span class="item-number"><?php echo bp_get_group_total_members(false); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <ul class="group-member member-thumb list-inline list-img-group">
                            <?php
                            $total_members = BP_Groups_Group::get_total_member_count(bp_get_group_id());
                            if ($total_members == 1) {
                                echo '<li><span>' . esc_html_e('No Members', 'socialv') . '</span></li>';
                            } else {
                                if (bp_group_has_members('group_id=' . bp_get_group_id() . '&per_page=4&exclude_admins_mods=false')) : ?>
                                    <?php while (bp_group_members()) : bp_group_the_member(); ?>
                                        <li><a href="<?php bp_member_permalink(); ?>"><?php bp_group_member_avatar_thumb(); ?></a></li>
                                    <?php endwhile; ?>
                                    <li><a href="<?php bp_group_permalink(); ?>"><i class="icon-add"></i></a></li>
                            <?php endif;
                            } ?>
                        </ul>
                        <?php
                        do_action('bp_directory_groups_item');
                        if (groups_is_user_admin(get_current_user_id(), bp_get_group_id())) {
                            echo ((count(groups_get_group_admins(bp_get_group_id())) > 1) ? '<div class="group-admin-main-button">' : '');
                        }
                        do_action('bp_directory_groups_actions');
                        if (groups_is_user_admin(get_current_user_id(), bp_get_group_id())) {
                            echo ((count(groups_get_group_admins(bp_get_group_id())) > 1) ? '</div>' : '');
                        }
                        ?>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>

    </div>

    <?php

    /**
     * Fires after the listing of the groups list.
     *
     * @since 1.1.0
     */
    do_action('bp_after_directory_groups_list'); ?>
    <?php
    $total_groups = bp_get_total_group_count();
    if ($total_groups > $per_page) { ?>
        <div id="pag-bottom" class="socialv-bp-pagination">
            <div class="pagination-links" id="group-dir-pag-bottom">
                <?php bp_groups_pagination_links(); ?>
            </div>
        </div>
    <?php } ?>
<?php else : ?>

    <div id="message" class="info">
        <p><?php esc_html_e('There were no groups found.', 'socialv'); ?></p>
    </div>

<?php endif; ?>

<?php

/**
 * Fires after the display of groups from the groups loop.
 *
 * @since 1.2.0
 */
do_action('bp_after_groups_loop');
