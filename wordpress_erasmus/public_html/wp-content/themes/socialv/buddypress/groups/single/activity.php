<?php

/**
 * BuddyPress - Groups Activity
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */
$socialv_options = get_option('socialv-options');
$show_rss_field = (class_exists('ReduxFramework') && $socialv_options['show_rss_group_field'] == '1') ? true : false;
?>
<div class="card-main socialv-search-main">
	<div class="card-inner pt-0 pb-0">
		<div id="subnav">
			<div class="row align-items-center">
				<div class="col-xl-7 col-md-7 item-list-tabs no-ajax">
					<div class="socialv-subtab-lists">
						<div class="left" onclick="slide('left',event)">
							<i class="iconly-Arrow-Left-2 icli"></i>
						</div>
						<div class="right" onclick="slide('right',event)">
							<i class="iconly-Arrow-Right-2 icli"></i>
						</div>
						<div class="socialv-subtab-container custom-nav-slider">
							<ul class="list-inline m-0">
								<?php if (bp_activity_is_feed_enable('group') && $show_rss_field == true) : ?>
									<li class="feed socialv-rss">
										<a href="<?php bp_group_activity_feed_link(); ?>" data-bp-tooltip="<?php esc_attr_e('RSS Feed', 'socialv'); ?>" aria-label="<?php esc_attr_e('RSS Feed', 'socialv'); ?>">
											<i class="icon-rss"></i><?php esc_html_e('RSS', 'socialv'); ?>
										</a>
									</li>
								<?php endif;
								do_action('bp_group_activity_syndication_options'); ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-xl-5 col-md-5 socialv-product-view-buttons">
					<div class="socialv-group-filter">
						<div class="position-relative">
							<div id="activity-filter-select" class="last filter socialv-data-filter-by">
								<label for="activity-filter-by"><?php esc_html_e('Show:', 'socialv'); ?></label>
								<select id="activity-filter-by">
									<option value="-1"><?php esc_html_e('&mdash; Everything &mdash;', 'socialv'); ?></option>

									<?php bp_activity_show_filters('group'); ?>

									<?php

									/**
									 * Fires inside the select input for group activity filter options.
									 *
									 * @since 1.2.0
									 */
									do_action('bp_group_activity_filter_options'); ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div><!-- .item-list-tabs -->
	</div>
</div>
<?php

/**
 * Fires before the display of the group activity post form.
 *
 * @since 1.2.0
 */
do_action('bp_before_group_activity_post_form'); ?>

<?php if (is_user_logged_in() && bp_group_is_member()) : ?>
	<div class="card-main card-space card-space-bottom activity-post-upload">
		<div class="card-inner">
			<?php bp_get_template_part('activity/post-form'); ?>
		</div>
	</div>
<?php endif; ?>

<?php

/**
 * Fires after the display of the group activity post form.
 *
 * @since 1.2.0
 */
do_action('bp_after_group_activity_post_form'); ?>
<?php

/**
 * Fires before the display of the group activities list.
 *
 * @since 1.2.0
 */
do_action('bp_before_group_activity_content'); ?>

<div class="activity single-group card-space-bottom" aria-live="polite" aria-atomic="true" aria-relevant="all">

	<?php bp_get_template_part('activity/activity-loop'); ?>

</div><!-- .activity.single-group -->

<?php

/**
 * Fires after the display of the group activities list.
 *
 * @since 1.2.0
 */
do_action('bp_after_group_activity_content');
