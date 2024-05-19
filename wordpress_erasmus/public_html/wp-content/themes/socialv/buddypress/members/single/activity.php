<?php

/**
 * BuddyPress - Users Activity
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use function SocialV\Utility\socialv;

$post_section = socialv()->post_style();
?>
<div class="card-main card-space card-space-bottom">
	<div class="card-inner pt-0 pb-0">
		<div class="row align-items-center" id="subnav" >
			<div class="col-md-7 col-xl-7 item-list-tabs no-ajax ">
				<div class="socialv-subtab-lists">
					<div class="left" onclick="slide('left',event)">
						<i class="iconly-Arrow-Left-2 icli"></i>
					</div>
					<div class="right" onclick="slide('right',event)">
						<i class="iconly-Arrow-Right-2 icli"></i>
					</div>
					<div class="socialv-subtab-container custom-nav-slider">
						<ul class="list-inline m-0">
							<?php bp_get_options_nav(); ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-5 col-xl-5">
				<div class="position-relative">
					<div id="activity-filter-select" class="last socialv-data-filter-by">
						<label for="activity-filter-by"><?php esc_html_e('Show:', 'socialv'); ?></label>
						<select id="activity-filter-by">
							<option value="-1"><?php esc_html_e('&mdash; Everything &mdash;', 'socialv'); ?></option>

							<?php bp_activity_show_filters(); ?>

							<?php

							/**
							 * Fires inside the select input for member activity filter options.
							 *
							 * @since 1.2.0
							 */
							do_action('bp_member_activity_filter_options'); ?>

						</select>
					</div>
				</div>
			</div>
		</div><!-- .item-list-tabs -->
	</div>
</div>

<div class="row <?php echo esc_attr($post_section['row_reverse']); ?>">
	<?php socialv()->socialv_the_layout_class(); ?>
	<?php

	/**
	 * Fires before the display of the member activity post form.
	 *
	 * @since 1.2.0
	 */
	do_action('bp_before_member_activity_post_form'); ?>

	<?php if (is_user_logged_in() && bp_is_my_profile() && (!bp_current_action() || bp_is_current_action('just-me'))) : ?>
		<div class="card-main  card-space-bottom activity-post-upload">
			<div class="card-inner">
				<?php

				bp_get_template_part('activity/post-form');

				/**
				 * Fires after the display of the member activity post form.
				 *
				 * @since 1.2.0
				 */
				do_action('bp_after_member_activity_post_form');

				/**
				 * Fires before the display of the member activities list.
				 *
				 * @since 1.2.0
				 */
				do_action('bp_before_member_activity_content'); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="activity" aria-live="polite" aria-atomic="true" aria-relevant="all">

		<?php bp_get_template_part('activity/activity-loop') ?>

	</div><!-- .activity -->

	<?php

	/**
	 * Fires after the display of the member activities list.
	 *
	 * @since 1.2.0
	 */
	do_action('bp_after_member_activity_content');
	?>

	<?php socialv()->socialv_sidebar(); ?>
</div>
