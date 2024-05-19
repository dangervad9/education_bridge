<?php

use function SocialV\Utility\socialv;

/**
 * BuddyPress - Home
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */
if (bp_activity_has_directory()) : ?>
	<div class="socialv-activity-site-main">
		<div class="<?php echo apply_filters('content_container_class', 'container'); ?>">
			<div class="row">
			<?php endif; ?>
			<div id="buddypress">

				<div id="template-notices" role="alert" aria-atomic="true">
					<?php

					do_action('template_notices'); ?>

				</div>

				<div class="activity no-ajax">
					<?php if (bp_has_activities('display_comments=threaded&show_hidden=true&include=' . bp_current_action())) : ?>

						<ul id="activity-stream" class="activity-list item-list socialv-list-post">
							<?php while (bp_activities()) : bp_the_activity(); ?>

								<?php bp_get_template_part('activity/entry'); ?>

							<?php endwhile; ?>
						</ul>

					<?php endif; ?>
				</div>
			</div>
			<?php if (bp_activity_has_directory()) : ?>
			</div>
		</div>
	</div>
<?php endif;
