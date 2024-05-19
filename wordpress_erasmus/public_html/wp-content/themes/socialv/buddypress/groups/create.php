<?php

/**
 * BuddyPress - Groups Create
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires at the top of the groups creation template file.
 *
 * @since 1.7.0
 */
do_action('bp_before_create_group_page'); ?>
<div class="<?php echo apply_filters('content_container_class', 'container'); ?>">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div id="buddypress">
				<?php

				/**
				 * Fires before the display of group creation content.
				 *
				 * @since 1.6.0
				 */
				do_action('bp_before_create_group_content_template'); ?>

				<form action="<?php bp_group_creation_form_action(); ?>" method="post" id="create-group-form" class="standard-form1" enctype="multipart/form-data">

					<?php

					/**
					 * Fires before the display of group creation.
					 *
					 * @since 1.2.0
					 */
					do_action('bp_before_create_group'); ?>

					<div class="card-main card-space">
						<div class="card-inner pt-0 pb-0">
							<div class="item-list-tabs no-ajax" id="group-create-tabs">
								<div class="socialv-subtab-lists">
									<div class="left" onclick="slide('left',event)">
										<i class="iconly-Arrow-Left-2 icli"></i>
									</div>
									<div class="right" onclick="slide('right',event)">
										<i class="iconly-Arrow-Right-2 icli"></i>
									</div>
									<div class="socialv-subtab-container custom-nav-slider">
										<ul class="list-inline m-0">
											<?php bp_group_creation_tabs(); ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-main card-space">
						<div class="card-inner">
							<div id="template-notices" role="alert" aria-atomic="true">
								<?php do_action('template_notices'); ?>
							</div>

							<div class="item-body m-0" id="group-create-body">

								<?php if (bp_is_group_creation_step('group-details')) : ?>

									<h2 class="bp-screen-reader-text"><?php
																		esc_html_e('Group Details', 'socialv');
																		?></h2>

									<?php

									/**
									 * Fires before the display of the group details creation step.
									 *
									 * @since 1.1.0
									 */
									do_action('bp_before_group_details_creation_step'); ?>

									<div class="form-floating">
										<input type="text" name="group-name" id="group-name" class="form-control" aria-required="true" value="<?php echo esc_attr(bp_get_new_group_name()); ?>" placeholder="<?php esc_attr_e('Group Name', 'socialv'); ?>" />
										<label for="group-name"><?php esc_html_e('Group Name (required)', 'socialv'); ?></label>
									</div>

									<div class="form-floating">
										<textarea name="group-desc" id="group-desc" class="form-control" aria-required="true" placeholder="<?php esc_attr_e('Group Description', 'socialv'); ?>"><?php bp_new_group_description(); ?></textarea>
										<label for="group-desc"><?php _e('Group Description (required)', 'socialv'); ?></label>
									</div>

									<?php

									/**
									 * Fires after the display of the group details creation step.
									 *
									 * @since 1.1.0
									 */
									do_action('bp_after_group_details_creation_step');
									do_action('groups_custom_group_fields_editable'); // @Deprecated

									wp_nonce_field('groups_create_save_group-details'); ?>

								<?php endif; ?>

								<?php /* Group creation step 2: Group settings */ ?>
								<?php if (bp_is_group_creation_step('group-settings')) : ?>

									<h2 class="bp-screen-reader-text"><?php
																		/* translators: accessibility text */
																		esc_html_e('Group Settings', 'socialv');
																		?></h2>

									<?php

									/**
									 * Fires before the display of the group settings creation step.
									 *
									 * @since 1.1.0
									 */
									do_action('bp_before_group_settings_creation_step'); ?>

									<fieldset class="group-create-privacy">

										<h4 class="socialv-setting-title"><?php esc_html_e('Privacy Options', 'socialv'); ?></h4>

										<div class="radio">
											<div class="radio-data-box">
												<label for="group-status-public"><input type="radio" name="group-status" id="group-status-public" value="public" <?php if ('public' == bp_get_new_group_status() || !bp_get_new_group_status()) { ?> checked="checked" <?php } ?> aria-describedby="public-group-description" /> <?php esc_html_e('This is a public group', 'socialv'); ?></label>

												<ul id="public-group-description" class="socialv-group-data mb-0">
													<li><?php esc_html_e('Any site member can join this group.', 'socialv'); ?></li>
													<li><?php esc_html_e('This group will be listed in the groups directory and in search results.', 'socialv'); ?></li>
													<li><?php esc_html_e('Group content and activity will be visible to any site member.', 'socialv'); ?></li>
												</ul>
											</div>

											<div class="radio-data-box">

												<label for="group-status-private"><input type="radio" name="group-status" id="group-status-private" value="private" <?php if ('private' == bp_get_new_group_status()) { ?> checked="checked" <?php } ?> aria-describedby="private-group-description" /> <?php esc_html_e('This is a private group', 'socialv'); ?></label>

												<ul id="private-group-description" class="socialv-group-data mb-0">
													<li><?php esc_html_e('Only users who request membership and are accepted can join the group.', 'socialv'); ?></li>
													<li><?php esc_html_e('This group will be listed in the groups directory and in search results.', 'socialv'); ?></li>
													<li><?php esc_html_e('Group content and activity will only be visible to members of the group.', 'socialv'); ?></li>
												</ul>
											</div>

											<div class="radio-data-box">

												<label for="group-status-hidden"><input type="radio" name="group-status" id="group-status-hidden" value="hidden" <?php if ('hidden' == bp_get_new_group_status()) { ?> checked="checked" <?php } ?> aria-describedby="hidden-group-description" /> <?php esc_html_e('This is a hidden group', 'socialv'); ?></label>

												<ul id="hidden-group-description" class="socialv-group-data mb-0">
													<li><?php esc_html_e('Only users who are invited can join the group.', 'socialv'); ?></li>
													<li><?php esc_html_e('This group will not be listed in the groups directory or search results.', 'socialv'); ?></li>
													<li><?php esc_html_e('Group content and activity will only be visible to members of the group.', 'socialv'); ?></li>
												</ul>
											</div>

										</div>

									</fieldset>

									<?php // Group type selection 
									?>
									<?php if ($group_types = bp_groups_get_group_types(array('show_in_create_screen' => true), 'objects')) : ?>

										<fieldset class="group-create-types">
											<h4 class="socialv-setting-title"><?php esc_html_e('Group Types', 'socialv'); ?></h4>

											<p><?php esc_html_e('Select the types this group should be a part of.', 'socialv'); ?></p>

											<?php foreach ($group_types as $type) : ?>
												<div class="checkbox">
													<label for="<?php printf('group-type-%s', $type->name); ?>"><input type="checkbox" name="group-types[]" id="<?php printf('group-type-%s', $type->name); ?>" value="<?php echo esc_attr($type->name); ?>" <?php checked(true, !empty($type->create_screen_checked)); ?> /> <?php echo esc_html($type->labels['name']); ?>
														<?php
														if (!empty($type->description)) {
															/* translators: Group type description shown when creating a group. */
															printf(__('&ndash; %s', 'socialv'), '<span class="bp-group-type-desc">' . esc_html($type->description) . '</span>');
														}
														?>
													</label>
												</div>

											<?php endforeach; ?>

										</fieldset>

									<?php endif; ?>

									<?php if (bp_is_active('groups', 'invitations')) : ?>

										<fieldset class="group-create-invitations">

											<h4 class="socialv-setting-title"><?php esc_html_e('Group Invitations', 'socialv'); ?></h4>

											<p><?php esc_html_e('Which members of this group are allowed to invite others?', 'socialv'); ?></p>

											<div class="radio">

												<div class="radio-data-box">
													<label for="group-invite-status-members"><input type="radio" name="group-invite-status" id="group-invite-status-members" value="members" <?php bp_group_show_invite_status_setting('members'); ?> /> <?php esc_html_e('All group members', 'socialv'); ?></label>
												</div>

												<div class="radio-data-box">
													<label for="group-invite-status-mods"><input type="radio" name="group-invite-status" id="group-invite-status-mods" value="mods" <?php bp_group_show_invite_status_setting('mods'); ?> /> <?php esc_html_e('Group admins and mods only', 'socialv'); ?></label>
												</div>

												<div class="radio-data-box">
													<label for="group-invite-status-admins"><input type="radio" name="group-invite-status" id="group-invite-status-admins" value="admins" <?php bp_group_show_invite_status_setting('admins'); ?> /> <?php esc_html_e('Group admins only', 'socialv'); ?></label>
												</div>

											</div>

										</fieldset>

									<?php endif; ?>

									<?php

									/**
									 * Fires after the display of the group settings creation step.
									 *
									 * @since 1.1.0
									 */
									do_action('bp_after_group_settings_creation_step'); ?>

									<?php wp_nonce_field('groups_create_save_group-settings'); ?>

								<?php endif; ?>

								<?php /* Group creation step 3: Avatar Uploads */ ?>
								<?php if (bp_is_group_creation_step('group-avatar')) : ?>

									<h2 class="bp-screen-reader-text"><?php
																		/* translators: accessibility text */
																		esc_html_e('Group Avatar', 'socialv');
																		?></h2>

									<?php

									/**
									 * Fires before the display of the group avatar creation step.
									 *
									 * @since 1.1.0
									 */
									do_action('bp_before_group_avatar_creation_step'); ?>

									<?php if ('upload-image' == bp_get_avatar_admin_step()) : ?>
										<div class="d-flex gap-3">
											<div class="left-menu">

												<?php bp_new_group_avatar(); ?>

											</div><!-- .left-menu -->

											<div class="main-column">
												<p><?php esc_html_e("Upload an image to use as a profile photo for this group. The image will be shown on the main group page, and in search results.", 'socialv'); ?></p>

												<p>
													<label for="file" class="bp-screen-reader-text"><?php
																									/* translators: accessibility text */
																									esc_html_e('Select an image', 'socialv');
																									?></label>
													<input type="file" name="file" id="file" />
													<input type="submit" name="upload" id="upload" value="<?php esc_attr_e('Upload Image', 'socialv'); ?>" />
													<input type="hidden" name="action" id="action" value="bp_avatar_upload" />
												</p>

												<p><?php esc_html_e('To skip the group profile photo upload process, hit the "Next Step" button.', 'socialv'); ?></p>
											</div><!-- .main-column -->
										</div>
										<?php
										/**
										 * Load the Avatar UI templates
										 *
										 * @since 2.3.0
										 */
										bp_avatar_get_templates(); ?>

									<?php endif; ?>

									<?php if ('crop-image' == bp_get_avatar_admin_step()) : ?>

										<h4><?php _e('Crop Group Profile Photo', 'socialv'); ?></h4>

										<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" class="avatar" alt="<?php esc_attr_e('Profile photo to crop', 'socialv'); ?>" loading="lazy" />

										<div id="avatar-crop-pane">
											<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-crop-preview" class="avatar" alt="<?php esc_attr_e('Profile photo preview', 'socialv'); ?>" loading="lazy" />
										</div>

										<input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php esc_attr_e('Crop Image', 'socialv'); ?>" />

										<input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src(); ?>" />
										<input type="hidden" name="upload" id="upload" />
										<input type="hidden" id="x" name="x" />
										<input type="hidden" id="y" name="y" />
										<input type="hidden" id="w" name="w" />
										<input type="hidden" id="h" name="h" />

									<?php endif; ?>

									<?php

									/**
									 * Fires after the display of the group avatar creation step.
									 *
									 * @since 1.1.0
									 */
									do_action('bp_after_group_avatar_creation_step'); ?>

									<?php wp_nonce_field('groups_create_save_group-avatar'); ?>

								<?php endif; ?>

								<?php /* Group creation step 4: Cover image */ ?>
								<?php if (bp_is_group_creation_step('group-cover-image')) : ?>

									<h2 class="bp-screen-reader-text"><?php
																		/* translators: accessibility text */
																		esc_html_e('Cover Image', 'socialv');
																		?></h2>

									<?php

									/**
									 * Fires before the display of the group cover image creation step.
									 *
									 * @since 2.4.0
									 */
									do_action('bp_before_group_cover_image_creation_step'); ?>

									<div id="header-cover-image"></div>

									<p><?php esc_html_e('The Cover Image will be used to customize the header of your group.', 'socialv'); ?></p>

									<?php bp_attachments_get_template_part('cover-images/index'); ?>

									<?php

									/**
									 * Fires after the display of the group cover image creation step.
									 *
									 * @since 2.4.0
									 */
									do_action('bp_after_group_cover_image_creation_step'); ?>

									<?php wp_nonce_field('groups_create_save_group-cover-image'); ?>

								<?php endif; ?>

								<?php /* Group creation step 5: Invite friends to group */ ?>
								<?php if (bp_is_group_creation_step('group-invites')) : ?>

									<h2 class="bp-screen-reader-text"><?php
																		/* translators: accessibility text */
																		esc_html_e('Group Invites', 'socialv');
																		?></h2>

									<?php

									/**
									 * Fires before the display of the group invites creation step.
									 *
									 * @since 1.1.0
									 */
									do_action('bp_before_group_invites_creation_step'); ?>

									<?php if (bp_is_active('friends') && bp_get_total_friend_count(bp_loggedin_user_id())) : ?>
										<div class="row">
											<div class="left-menu col-md-4 col-xl-3">

												<div id="invite-list">
													<ul class="list-inline m-0">
														<?php bp_new_group_invite_friend_list(); ?>
													</ul>

													<?php wp_nonce_field('groups_invite_uninvite_user', '_wpnonce_invite_uninvite_user'); ?>
												</div>

											</div><!-- .left-menu -->

											<div class="main-column col-md-8 col-xl-9">

												<div id="message" class="info">
													<p><?php esc_html_e('Select people to invite from your friends list.', 'socialv'); ?></p>
												</div>

												<?php /* The ID 'friend-list' is important for AJAX support. */ ?>
												<ul id="friend-list" class="item-list border-0">

													<?php if (bp_group_has_invites()) : ?>

														<?php while (bp_group_invites()) : bp_group_the_invite(); ?>

															<li id="<?php bp_group_invite_item_id(); ?>">

																<?php bp_group_invite_user_avatar(); ?>

																<h4><?php bp_group_invite_user_link(); ?></h4>
																<span class="activity"><?php bp_group_invite_user_last_active(); ?></span>

																<div class="action">
																	<a class="remove" href="<?php bp_group_invite_user_remove_invite_url(); ?>" id="<?php bp_group_invite_item_id(); ?>"><?php esc_html_e('Remove Invite', 'socialv'); ?></a>
																</div>
															</li>

														<?php endwhile; ?>

														<?php wp_nonce_field('groups_send_invites', '_wpnonce_send_invites'); ?>

													<?php endif; ?>

												</ul>

											</div><!-- .main-column -->

										<?php else : ?>

											<div id="message" class="info">
												<p><?php esc_html_e('Once you have built up friend connections you will be able to invite others to your group.', 'socialv'); ?></p>
											</div>
										</div>

									<?php endif; ?>

									<?php wp_nonce_field('groups_create_save_group-invites'); ?>

									<?php

									/**
									 * Fires after the display of the group invites creation step.
									 *
									 * @since 1.1.0
									 */
									do_action('bp_after_group_invites_creation_step'); ?>

								<?php endif; ?>

								<?php

								/**
								 * Fires inside the group admin template.
								 *
								 * Allows plugins to add custom group creation steps.
								 *
								 * @since 1.1.0
								 */
								do_action('groups_custom_create_steps'); ?>

								<?php

								/**
								 * Fires before the display of the group creation step buttons.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_before_group_creation_step_buttons'); ?>

								<?php if ('crop-image' != bp_get_avatar_admin_step()) : ?>
									<div class="form-edit-btn">
										<div class="submit" id="previous-next">

											<?php /* Previous Button */ ?>
											<?php if (!bp_is_first_group_creation_step()) : ?>

												<input type="button" value="<?php esc_attr_e('Back to Previous Step', 'socialv'); ?>" id="group-creation-previous" class="btn socialv-btn-primary" name="previous" onclick="location.href='<?php bp_group_creation_previous_link(); ?>'" />

											<?php endif; ?>

											<?php /* Next Button */ ?>
											<?php if (!bp_is_last_group_creation_step() && !bp_is_first_group_creation_step()) : ?>

												<input type="submit" value="<?php esc_attr_e('Next Step', 'socialv'); ?>" id="group-creation-next" class="btn socialv-btn-success" name="save" />

											<?php endif; ?>

											<?php /* Create Button */ ?>
											<?php if (bp_is_first_group_creation_step()) : ?>

												<input type="submit" value="<?php esc_attr_e('Create Group and Continue', 'socialv'); ?>" id="group-creation-create" class="btn socialv-btn-success" name="save" />

											<?php endif; ?>

											<?php /* Finish Button */ ?>
											<?php if (bp_is_last_group_creation_step()) : ?>

												<input type="submit" value="<?php esc_attr_e('Finish', 'socialv'); ?>" id="group-creation-finish" class="btn socialv-btn-success" name="save" />

											<?php endif; ?>
										</div>
									</div>


								<?php endif; ?>

								<?php

								/**
								 * Fires after the display of the group creation step buttons.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_after_group_creation_step_buttons'); ?>

								<?php /* Don't leave out this hidden field */ ?>
								<input type="hidden" name="group_id" id="group_id" value="<?php bp_new_group_id(); ?>" />

								<?php

								/**
								 * Fires and displays the groups directory content.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_directory_groups_content'); ?>

							</div><!-- .item-body -->
						</div>
					</div>

					<?php

					/**
					 * Fires after the display of group creation.
					 *
					 * @since 1.2.0
					 */
					do_action('bp_after_create_group'); ?>

				</form>

				<?php

				/**
				 * Fires after the display of group creation content.
				 *
				 * @since 1.6.0
				 */
				do_action('bp_after_create_group_content_template'); ?>
			</div>

			<?php

			/**
			 * Fires at the bottom of the groups creation template file.
			 *
			 * @since 1.7.0
			 */
			do_action('bp_after_create_group_page'); ?>
		</div>
	</div>
</div>