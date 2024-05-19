<?php

/**
 * BuddyPress Activity templates
 *
 * @since 2.3.0
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use function SocialV\Utility\socialv;

/**
 * Fires before the activity directory listing.
 *
 * @since 1.5.0
 */
$post_section = socialv()->post_style();

do_action('bp_before_directory_activity');

// <!-- stories -->
if (class_exists('Wpstory_Premium')) : ?>
	<?php do_action('socialv_user_stories'); ?>
<?php endif; ?>
<div class="row <?php echo esc_attr($post_section['row_reverse']); ?>">
	<?php socialv()->socialv_the_layout_class(); ?>
	<div id="buddypress">

		<?php

		/**
		 * Fires before the activity directory display content.
		 *
		 * @since 1.2.0
		 */
		do_action('bp_before_directory_activity_content'); ?>

		<?php if (is_user_logged_in()) : ?>
			<div class="card-main card-space-bottom activity-post-upload">
				<div class="card-inner post-inner-block">
					<?php bp_get_template_part('activity/post-form'); ?>
				</div>
			</div>
		<?php endif; ?>

		<div id="template-notices" role="alert" aria-atomic="true">
			<?php

			/**
			 * Fires towards the top of template pages for notice display.
			 *
			 * @since 1.0.0
			 */
			do_action('template_notices'); ?>

		</div>

		<?php

		/**
		 * Fires before the display of the activity list.
		 *
		 * @since 1.5.0
		 */
		do_action('bp_before_directory_activity_list'); ?>

		<div class="activity" aria-live="polite" aria-atomic="true" aria-relevant="all">

			<?php bp_get_template_part('activity/activity-loop'); ?>

		</div><!-- .activity -->

		<?php

		/**
		 * Fires after the display of the activity list.
		 *
		 * @since 1.5.0
		 */
		do_action('bp_after_directory_activity_list'); ?>

		<?php

		/**
		 * Fires inside and displays the activity directory display content.
		 */
		do_action('bp_directory_activity_content'); ?>

		<?php

		/**
		 * Fires after the activity directory display content.
		 *
		 * @since 1.2.0
		 */
		do_action('bp_after_directory_activity_content'); ?>

		<?php

		/**
		 * Fires after the activity directory listing.
		 *
		 * @since 1.5.0
		 */
		do_action('bp_after_directory_activity'); ?>

	</div>
	<?php
	socialv()->socialv_sidebar();
	?>
</div>