<?php

/**
 * User Subscriptions
 *
 * @package bbPress
 * @subpackage Theme
 */
// Exit if accessed directly
defined('ABSPATH') || exit;

do_action('bbp_template_before_user_subscriptions'); ?>

<?php if (bbp_is_subscriptions_active()) : ?>

	<?php if (bbp_is_user_home() || current_user_can('edit_user', bbp_get_displayed_user_id())) : ?>

		<div id="bbp-user-subscriptions" class="bbp-user-subscriptions">

			<?php bbp_get_template_part('form', 'topic-search'); ?>

			<div class="bbp-user-section">

				<?php if (bbp_get_user_forum_subscriptions()) : ?>

					<?php bbp_get_template_part('loop', 'forums'); ?>
					

				<?php else : ?>
					<div class="card-main card-space">
						<div class="card-inner">
							<?php bbp_get_template_part('feedback', 'no-forums'); ?>
						</div>
					</div>
				<?php endif; ?>

			</div>

			<div class="bbp-user-section">

				<?php if (bbp_get_user_topic_subscriptions()) : ?>

					<?php bbp_get_template_part('pagination', 'topics'); ?>

					<?php bbp_get_template_part('loop',       'topics'); ?>

				<?php else : ?>

					<?php bbp_get_template_part('feedback', 'no-topics'); ?>

				<?php endif; ?>

			</div>
		</div><!-- #bbp-user-subscriptions -->

	<?php endif; ?>

<?php endif; ?>

<?php do_action('bbp_template_after_user_subscriptions');
