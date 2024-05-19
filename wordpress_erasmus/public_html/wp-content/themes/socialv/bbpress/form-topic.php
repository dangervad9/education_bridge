<?php

/**
 * New/Edit Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined('ABSPATH') || exit;
?>
<div class="card-main card-space clear-both socialv-forum-topic-card">
	<div class="card-inner">
		<?php
		if (!bbp_is_single_forum()) : ?>
			<div id="bbpress-forums" class="bbpress-wrapper mb-0">

			<?php endif; ?>

			<?php if (bbp_is_topic_edit()) : ?>

				<?php bbp_topic_tag_list(bbp_get_topic_id()); ?>

				<?php bbp_single_topic_description(array('topic_id' => bbp_get_topic_id())); ?>

				<?php bbp_get_template_part('alert', 'topic-lock'); ?>

			<?php endif; ?>

			<?php if (bbp_current_user_can_access_create_topic_form()) : ?>

				<div id="new-topic-<?php bbp_topic_id(); ?>" class="bbp-topic-form">

					<form id="new-post" name="new-post" method="post">

						<?php do_action('bbp_theme_before_topic_form'); ?>

						<div class="bbp-forms-sv">
							<h4 class="mb-3">

								<?php
								if (bbp_is_topic_edit()) :
									printf(esc_html__('Now Editing &ldquo;%s&rdquo;', 'socialv'), bbp_get_topic_title());
								else : (bbp_is_single_forum() && bbp_get_forum_title())
										? printf(esc_html__('Create New Topic in &ldquo;%s&rdquo;', 'socialv'), bbp_get_forum_title())
										: esc_html_e('Create New Topic', 'socialv');
								endif;
								?>

							</h4>

							<?php do_action('bbp_theme_before_topic_form_notices'); ?>

							<?php if (!bbp_is_topic_edit() && bbp_is_forum_closed()) : ?>

								<div class="bbp-template-notice mb-4">
									<ul>
										<li><?php esc_html_e('This forum is marked as closed to new topics, however your posting capabilities still allow you to create a topic.', 'socialv'); ?></li>
									</ul>
								</div>

							<?php endif; ?>

							<?php if (current_user_can('unfiltered_html')) : ?>

								<div class="bbp-template-notice mb-4">
									<ul>
										<li><?php esc_html_e('Your account has the ability to post unrestricted HTML content.', 'socialv'); ?></li>
									</ul>
								</div>

							<?php endif; ?>

							<?php do_action('bbp_template_notices'); ?>

							<div>

								<?php bbp_get_template_part('form', 'anonymous'); ?>

								<?php do_action('bbp_theme_before_topic_form_title'); ?>

								<div class="form-floating">
									<input class="form-control" placeholder="<?php printf(esc_attr__('Topic Title (Maximum Length: %d):', 'socialv'), bbp_get_title_max_length()); ?>" type="text" id="bbp_topic_title" value="<?php bbp_form_topic_title(); ?>" size="40" name="bbp_topic_title" maxlength="<?php bbp_title_max_length(); ?>" />
									<label for="bbp_topic_title"><?php printf(esc_html__('Topic Title (Maximum Length: %d):', 'socialv'), bbp_get_title_max_length()); ?></label>
								</div>

								<?php do_action('bbp_theme_after_topic_form_title'); ?>

								<?php do_action('bbp_theme_before_topic_form_content'); ?>

								<?php bbp_the_content(array('context' => 'topic')); ?>

								<?php do_action('bbp_theme_after_topic_form_content'); ?>

								<?php if (!(bbp_use_wp_editor() || current_user_can('unfiltered_html'))) : ?>

									<div class="form-allowed-tags">
										<label><?php printf(esc_html__('You may use these %s tags and attributes:', 'socialv'), '<abbr title="HyperText Markup Language">HTML</abbr>'); ?></label><br />
										<code><?php bbp_allowed_tags(); ?></code>
									</div>

								<?php endif; ?>

								<?php if (bbp_allow_topic_tags() && current_user_can('assign_topic_tags', bbp_get_topic_id())) : ?>

									<?php do_action('bbp_theme_before_topic_form_tags'); ?>

									<div class=" form-floating">
										<input class="form-control" placeholder="<?php esc_attr_e('Topic Tags:', 'socialv'); ?>" type="text" value="<?php bbp_form_topic_tags(); ?>" size="40" name="bbp_topic_tags" id="bbp_topic_tags" <?php disabled(bbp_is_topic_spam()); ?> />
										<label for="bbp_topic_tags"><?php esc_html_e('Topic Tags:', 'socialv'); ?></label>
									</div>

									<?php do_action('bbp_theme_after_topic_form_tags'); ?>

								<?php endif; ?>

								<?php if (!bbp_is_single_forum()) : ?>

									<?php do_action('bbp_theme_before_topic_form_forum'); ?>

									<div class="form-floating ">
										<?php
										bbp_dropdown(array(
											'select_class' => 'form-select',
											'show_none' => esc_html__('&mdash; No forum &mdash;', 'socialv'),
											'selected'  => bbp_get_form_topic_forum()
										));
										?>
										<label for="bbp_forum_id"><?php esc_html_e('Forum:', 'socialv'); ?></label>

									</div>

									<?php do_action('bbp_theme_after_topic_form_forum'); ?>

								<?php endif; ?>

								<?php if (current_user_can('moderate', bbp_get_topic_id())) : ?>

									<?php do_action('bbp_theme_before_topic_form_type'); ?>




									<div class="position-relative border-start-0 form-floating width-two-column one">
										<?php bbp_form_topic_type_dropdown(array('select_class' => 'form-select')); ?>
										<label for="bbp_stick_topic"><?php esc_html_e('Topic Type:', 'socialv'); ?></label>
									</div>


									<?php do_action('bbp_theme_after_topic_form_type'); ?>

									<?php do_action('bbp_theme_before_topic_form_status'); ?>



									<div class="form-floating width-two-column two">
										<?php bbp_form_topic_status_dropdown(array('select_class' => 'form-select')); ?>
										<label for="bbp_topic_status"><?php esc_html_e('Topic Status:', 'socialv'); ?></label><br />
									</div>


									<?php do_action('bbp_theme_after_topic_form_status'); ?>

								<?php endif; ?>

								<?php if (bbp_is_subscriptions_active() && !bbp_is_anonymous() && (!bbp_is_topic_edit() || (bbp_is_topic_edit() && !bbp_is_topic_anonymous()))) : ?>

									<?php do_action('bbp_theme_before_topic_form_subscriptions'); ?>

									<div class="socialv-check mb-2">
										<label for="bbp_topic_subscription">
											<input name="bbp_topic_subscription" id="bbp_topic_subscription" type="checkbox" value="bbp_subscribe" <?php bbp_form_topic_subscribed(); ?> />

											<?php if (bbp_is_topic_edit() && (bbp_get_topic_author_id() !== bbp_get_current_user_id())) : ?>

												<span class="ms-0"><?php esc_html_e('Notify the author of follow-up replies via email', 'socialv'); ?></span>

											<?php else : ?>

												<span class="ms-0"><?php esc_html_e('Notify me of follow-up replies via email', 'socialv'); ?></span>

											<?php endif; ?>
										</label>
									</div>

									<?php do_action('bbp_theme_after_topic_form_subscriptions'); ?>

								<?php endif; ?>

								<?php if (bbp_allow_revisions() && bbp_is_topic_edit()) : ?>

									<?php do_action('bbp_theme_before_topic_form_revisions'); ?>

									<div class="bbp-form">
										<div class="socialv-check mb-2">
											<label for="bbp_log_topic_edit"><input name="bbp_log_topic_edit" id="bbp_log_topic_edit" type="checkbox" value="1" <?php bbp_form_topic_log_edit(); ?> /><span class="ms-0"><?php esc_html_e('Keep a log of this edit:', 'socialv'); ?></span></label>
										</div>
										<div class="form-floating mt-3">
											<input type="text" class="form-control" value="<?php bbp_form_topic_edit_reason(); ?>" size="40" placeholder="<?php printf(esc_attr__('Optional reason for editing:', 'socialv'), bbp_get_current_user_name()); ?>" name="bbp_topic_edit_reason" id="bbp_topic_edit_reason" />
											<label for="bbp_topic_edit_reason"><?php printf(esc_html__('Optional reason for editing:', 'socialv'), bbp_get_current_user_name()); ?></label>
										</div>
									</div>

									<?php do_action('bbp_theme_after_topic_form_revisions'); ?>

								<?php endif; ?>

								<?php do_action('bbp_theme_before_topic_form_submit_wrapper'); ?>

								<div class="bbp-submit-wrapper-sv mt-3 pt-3">

									<?php do_action('bbp_theme_before_topic_form_submit_button'); ?>

									<button type="submit" id="bbp_topic_submit" name="bbp_topic_submit" class="button submit socialv-btn-success"><?php esc_html_e('Submit', 'socialv'); ?></button>

									<?php do_action('bbp_theme_after_topic_form_submit_button'); ?>

								</div>

								<?php do_action('bbp_theme_after_topic_form_submit_wrapper'); ?>

							</div>

							<?php bbp_topic_form_fields(); ?>

						</div>

						<?php do_action('bbp_theme_after_topic_form'); ?>

					</form>
				</div>

			<?php elseif (bbp_is_forum_closed()) : ?>

				<div id="forum-closed-<?php bbp_forum_id(); ?>" class="bbp-forum-closed">
					<div class="bbp-template-notice">
						<ul>
							<li><?php printf(esc_html__('The forum &#8216;%s&#8217; is closed to new topics and replies.', 'socialv'), bbp_get_forum_title()); ?></li>
						</ul>
					</div>
				</div>

			<?php else : ?>

				<div id="no-topic-<?php bbp_forum_id(); ?>" class="bbp-no-topic">
					<div class="bbp-template-notice">
						<ul>
							<li><?php is_user_logged_in()
									? esc_html_e('You cannot create new topics.',               'socialv')
									: esc_html_e('You must be logged in to create new topics.', 'socialv');
								?></li>
						</ul>
					</div>

					<?php if (!is_user_logged_in()) : ?>

						<?php bbp_get_template_part('form', 'user-login'); ?>

					<?php endif; ?>

				</div>

			<?php endif; ?>

			<?php if (!bbp_is_single_forum()) : ?>

			</div>
		<?php endif;
		?>
	</div>
</div>