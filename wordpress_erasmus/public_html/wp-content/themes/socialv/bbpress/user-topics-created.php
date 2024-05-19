<?php

/**
 * User Topics Created
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

do_action('bbp_template_before_user_topics_created'); ?>

<div id="bbp-user-topics-started" class="bbp-user-topics-started">

	<?php bbp_get_template_part('form', 'topic-search'); ?>

	<div class="bbp-user-section">

		<?php if (bbp_get_user_topics_started()) : ?>

			<?php bbp_get_template_part('pagination', 'topics'); ?>
			<?php bbp_get_template_part('loop',       'topics'); ?>

		<?php else : ?>
			<div class="card-main card-space">
				<div class="card-inner">
					<?php bbp_get_template_part('feedback', 'no-topics'); ?>
				</div>
			</div>
		<?php endif; ?>

	</div>
</div><!-- #bbp-user-topics-started -->

<?php do_action('bbp_template_after_user_topics_created');
