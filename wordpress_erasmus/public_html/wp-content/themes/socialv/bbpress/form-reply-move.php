<?php

/**
 * Move Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

?>
<div class="card-main clear-both  socialv-forum-topic-card">
	<div class="card-inner">
		<div id="bbpress-forums" class="bbpress-wrapper">

			<?php if (is_user_logged_in() && current_user_can('edit_topic', bbp_get_topic_id())) : ?>

				<div id="move-reply-<?php bbp_topic_id(); ?>" class="bbp-reply-move">

					<form id="move_reply" name="move_reply" method="post">

						<div class="bbp-form">

							<h4 class="mb-1"><?php printf(esc_html__('Move reply "%s"', 'socialv'), bbp_get_reply_title()); ?></h4>

							<div>

								<div class="bbp-template-notice info m-0">
									<ul class="list-inline m-0">
										<li><?php esc_html_e('You can either make this reply a new topic with a new title, or merge it into an existing topic.', 'socialv'); ?></li>
									</ul>
								</div>

								<div class="bbp-template-notice">
									<ul class="list-inline m-0">
										<li><?php esc_html_e('If you choose an existing topic, replies will be ordered by the time and date they were created.', 'socialv'); ?></li>
									</ul>
								</div>

								<div class="bbp-form mb-4 mt-4">
									<h4 class="mb-3"><?php esc_html_e('Move Method', 'socialv'); ?></h4>

									<div class="mb-2">
										<input name="bbp_reply_move_option" id="bbp_reply_move_option_reply" type="radio" checked="checked" value="topic" />
										<label for="bbp_reply_move_option_reply"><?php printf(esc_html__('New topic in %s titled:', 'socialv'), bbp_get_forum_title(bbp_get_reply_forum_id(bbp_get_reply_id()))); ?></label>

									</div>
									<div class="form-floating mb-3">
										<input type="text" class="form-control" id="bbp_reply_move_destination_title" placeholder="<?php esc_attr_e('moved', 'socialv'); ?>" value="<?php printf(esc_html__('Moved: %s', 'socialv'), bbp_get_reply_title()); ?>" size="35" name="bbp_reply_move_destination_title" />
									</div>
									<?php if (bbp_has_topics(array('show_stickies' => false, 'post_parent' => bbp_get_reply_forum_id(bbp_get_reply_id()), 'post__not_in' => array(bbp_get_reply_topic_id(bbp_get_reply_id()))))) : ?>

										<div class="mb-2">
										<div class="mb-2">
											<input name="bbp_reply_move_option" id="bbp_reply_move_option_existing" type="radio" value="existing" />
											<label for="bbp_reply_move_option_existing"><?php esc_html_e('Use an existing topic in this forum:', 'socialv'); ?></label>
										</div>
											<?php
											bbp_dropdown(array(
												'post_type'   => bbp_get_topic_post_type(),
												'post_parent' => bbp_get_reply_forum_id(bbp_get_reply_id()),
												'selected'    => -1,
												'exclude'     => bbp_get_reply_topic_id(bbp_get_reply_id()),
												'select_id'   => 'bbp_destination_topic'
											));
											?>

										</div>

									<?php endif; ?>

								</div>

								<div class="bbp-template-notice error" role="alert" tabindex="-1">
									<ul class="list-inline m-0">
										<li><?php esc_html_e('This process cannot be undone.', 'socialv'); ?></li>
									</ul>
								</div>

								<div class="bbp-submit-wrapper-sv mt-3 pt-3">
									<button type="submit" id="bbp_move_reply_submit" name="bbp_move_reply_submit" class="socialv-btn-success button submit"><?php esc_html_e('Submit', 'socialv'); ?></button>
								</div>
							</div>

							<?php bbp_move_reply_form_fields(); ?>

						</div>
					</form>
				</div>

			<?php else : ?>

				<div id="no-reply-<?php bbp_reply_id(); ?>" class="bbp-no-reply">
					<div class="entry-content"><?php is_user_logged_in()
													? esc_html_e('You do not have permission to edit this reply.', 'socialv')
													: esc_html_e('You cannot edit this reply.',                    'socialv');
												?></div>
				</div>

			<?php endif; ?>

		</div>
	</div>
</div>