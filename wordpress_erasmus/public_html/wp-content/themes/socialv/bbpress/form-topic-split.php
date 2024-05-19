<?php

/**
 * Split Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

?>
<div class="card-main clear-both  socialv-forum-topic-card">
	<div class="card-inner">
		<div id="bbpress-forums" class="bbpress-wrapper mb-0">

			<?php if (is_user_logged_in() && current_user_can('edit_topic', bbp_get_topic_id())) : ?>

				<div id="split-topic-<?php bbp_topic_id(); ?>" class="bbp-topic-split">

					<form id="split_topic" name="split_topic" method="post">

						<div class="bbp-form">

							<h4><?php printf(esc_html__('Split topic "%s"', 'socialv'), bbp_get_topic_title()); ?></h4>

							<div>

								<div class="bbp-template-notice info">
									<ul class="list-inline m-0">
										<li><?php esc_html_e('When you split a topic, you are slicing it in half starting with the reply you just selected. Choose to use that reply as a new topic with a new title, or merge those replies into an existing topic.', 'socialv'); ?></li>
									</ul>
								</div>

								<div class="bbp-template-notice">
									<ul class="list-inline m-0">
										<li><?php esc_html_e('If you use the existing topic option, replies within both topics will be merged chronologically. The order of the merged replies is based on the time and date they were posted.', 'socialv'); ?></li>
									</ul>
								</div>

								<div class="bbp-form">
									<h4 class="mb-2 mt-4"><?php esc_html_e('Split Method', 'socialv'); ?></h4>

									<div class="mb-2">
										<input name="bbp_topic_split_option" id="bbp_topic_split_option_reply" type="radio" checked="checked" value="reply" />
										<label for="bbp_topic_split_option_reply"><?php printf(esc_html__('New topic in %s titled:', 'socialv'), bbp_get_forum_title(bbp_get_topic_forum_id(bbp_get_topic_id()))); ?></label>
									</div>
									<div class="form-floating mb-3">
										<input type="text" class="form-control" id="bbp_topic_split_destination_title" value="<?php printf(esc_html__('Split: %s', 'socialv'), bbp_get_topic_title()); ?>" size="35" name="bbp_topic_split_destination_title" />
									</div>
									<?php if (bbp_has_topics(array('show_stickies' => false, 'post_parent' => bbp_get_topic_forum_id(bbp_get_topic_id()), 'post__not_in' => array(bbp_get_topic_id())))) : ?>

										<div class="mb-3 pb-3">
											<div class="mb-2">
												<input name="bbp_topic_split_option" id="bbp_topic_split_option_existing" type="radio" value="existing" />
												<label for="bbp_topic_split_option_existing"><?php esc_html_e('Use an existing topic in this forum:', 'socialv'); ?></label>
											</div>


											<?php
											bbp_dropdown(array(
												'post_type'   => bbp_get_topic_post_type(),
												'post_parent' => bbp_get_topic_forum_id(bbp_get_topic_id()),
												'post_status' => bbp_get_public_topic_statuses(),
												'selected'    => -1,
												'exclude'     => bbp_get_topic_id(),
												'select_id'   => 'bbp_destination_topic'
											));
											?>

										</div>

									<?php endif; ?>

								</div>

								<div class="bbp-form mb-3">
									<h4 class="mb-3"><?php esc_html_e('Topic Extras', 'socialv'); ?></h4>

									<div>

										<?php if (bbp_is_subscriptions_active()) : ?>
											<div class="socialv-check">
												<label for="bbp_topic_subscribers">
													<input name="bbp_topic_subscribers" id="bbp_topic_subscribers" type="checkbox" value="1" checked="checked" /><span class="ms-0"><?php esc_html_e('Copy subscribers to the new topic', 'socialv'); ?></span>
												</label>
											</div>


										<?php endif; ?>
										<div class="socialv-check">
											<label for="bbp_topic_favoriters">
												<input name="bbp_topic_favoriters" id="bbp_topic_favoriters" type="checkbox" value="1" checked="checked" /><span class="ms-0"><?php esc_html_e('Copy favoriters to the new topic', 'socialv'); ?></span>
											</label>
										</div>


										<?php if (bbp_allow_topic_tags()) : ?>

											<div class="socialv-check">
												<label for="bbp_topic_tags">
													<input name="bbp_topic_tags" id="bbp_topic_tags" type="checkbox" value="1" checked="checked" /><span class="ms-0"><?php esc_html_e('Copy topic tags to the new topic', 'socialv'); ?></span>
												</label>
											</div>

										<?php endif; ?>

									</div>
								</div>

								<div class="bbp-template-notice error mb-3" role="alert" tabindex="-1">
									<ul class="list-inline m-0">
										<li><?php esc_html_e('This process cannot be undone.', 'socialv'); ?></li>
									</ul>
								</div>

								<div class="bbp-submit-wrapper-sv mt-3 pt-3">
									<button type="submit" id="bbp_merge_topic_submit" name="bbp_merge_topic_submit" class="socialv-btn-success button submit"><?php esc_html_e('Submit', 'socialv'); ?></button>
								</div>
							</div>

							<?php bbp_split_topic_form_fields(); ?>

						</div>
					</form>
				</div>

			<?php else : ?>

				<div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
					<div class="entry-content"><?php is_user_logged_in()
													? esc_html_e('You do not have permission to edit this topic.', 'socialv')
													: esc_html_e('You cannot edit this topic.',                    'socialv');
												?></div>
				</div>

			<?php endif; ?>

		</div>
	</div>
</div>