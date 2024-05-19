<?php

/**
 * BuddyPress - Members Single Profile Edit
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires after the display of member profile edit content.
 *
 * @since 1.1.0
 */
do_action('bp_before_profile_edit_content');
?>

<div class="row card-space">
	<div class="col-md-4">
		<div class="accordion">
			<div class="socialv-profile-edit-dropdown" id="accordionProfile">
				<div class="accordion-item">
					<h6 class="accordion-header" id="headingOne">
						<div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							<i class="iconly-Profile icli"></i> <?php esc_html_e('Profile Setting', 'socialv'); ?>
						</div>
					</h6>
					<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionProfile">

						<?php if (bp_profile_has_multiple_groups()) : ?>
							<div class="accordion-body">
								<ul class="list-inline m-0">
									<?php bp_profile_group_tabs(); ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="accordion-item">
					<h6 class="accordion-header" id="headingTwo">
						<div class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							<i class="iconly-Setting icli"></i> <?php esc_html_e('Account Settings', 'socialv'); ?>
						</div>
					</h6>
					<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionProfile">
						<div class="accordion-body">
							<?php do_action('socialv_settings_menus'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<?php do_action('socialv_account_menu_header_buttons'); ?>
		<div class="card-main card-space">
			<div class="card-inner">
				<div id="template-notices" role="alert" aria-atomic="true">
					<?php
					do_action('template_notices'); ?>

				</div>
				<?php
				if (bp_has_profile('profile_group_id=' . bp_get_current_profile_group_id())) :
					while (bp_profile_groups()) : bp_the_profile_group(); ?>

						<form action="<?php bp_the_profile_group_edit_form_action(); ?>" method="post" id="profile-edit-form" class="standard-form1 <?php bp_the_profile_group_slug(); ?>">
							<div class="card-head card-header-border d-flex align-items-center justify-content-between">
								<div class="head-title">
									<h4 class="card-title"><?php echo bp_get_the_profile_group_name(); ?></h4>
								</div>
							</div>
							<div class="row">
								<?php while (bp_profile_fields()) : bp_the_profile_field(); ?>
									<div <?php echo bp_get_field_css_class('editfield ' . 'col-12'); ?>>
										<div class="<?php echo esc_attr(('textarea' == bp_get_the_profile_field_type() || 'wp-biography' == bp_get_the_profile_field_type()) ? 'form-editor-box' : 'form-floating'); ?>">
											<?php $current_type = array('number', 'telephone', 'textbox', 'textarea','wp-biography', 'selectbox', 'radio', 'checkbox','datebox', 'url');
											if (in_array(bp_get_the_profile_field_type(), $current_type)) {
												if ('number' == bp_get_the_profile_field_type()) : ?>

													<input type="number" class="form-control" name="<?php bp_the_profile_field_input_name(); ?>" placeholder="<?php bp_the_profile_field_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" class="form-control" value="<?php bp_the_profile_field_edit_value(); ?>" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" required<?php endif; ?> />
													<label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if (bp_get_the_profile_field_is_required()) : ?><?php esc_html_e('(required)', 'socialv'); ?><?php endif; ?></label>

												<?php endif;
												if ('telephone' == bp_get_the_profile_field_type()) : ?>

													<input type="tel" class="form-control" name="<?php bp_the_profile_field_input_name(); ?>" placeholder="<?php bp_the_profile_field_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" class="form-control" value="<?php bp_the_profile_field_edit_value(); ?>" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" required<?php endif; ?> />
													<label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if (bp_get_the_profile_field_is_required()) : ?><?php esc_html_e('(required)', 'socialv'); ?><?php endif; ?></label>

												<?php endif;
												if ('textbox' == bp_get_the_profile_field_type()) : ?>

													<input type="text" class="form-control" name="<?php bp_the_profile_field_input_name(); ?>" placeholder="<?php bp_the_profile_field_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" class="form-control" value="<?php bp_the_profile_field_edit_value(); ?>" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" required<?php endif; ?> />
													<label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if (bp_get_the_profile_field_is_required()) : ?><?php esc_html_e('(required)', 'socialv'); ?><?php endif; ?></label>

												<?php endif;
												if ('textarea' == bp_get_the_profile_field_type() || 'wp-biography' == bp_get_the_profile_field_type()) : ?>
													<label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if (bp_get_the_profile_field_is_required()) : ?><?php esc_html_e('(required)', 'socialv'); ?><?php endif; ?></label>
													<?php

													$content = !empty(bp_get_the_profile_field_value()) ? bp_get_the_profile_field_value() : "";
													$custom_editor_id = bp_get_the_profile_field_input_name();
													$custom_editor_nm = bp_get_the_profile_field_input_name();
													$args = array(
														'media_buttons' => false,
														'textarea_name' => $custom_editor_nm,
														'textarea_rows' => 10,
														'quicktags' => true
													);
													wp_editor($content, $custom_editor_id, $args);
													?>
												<?php endif;
												if ('selectbox' == bp_get_the_profile_field_type()) : ?>

													<select class="form-select" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" required <?php endif; ?>>
														<?php bp_the_profile_field_options(); ?>
													</select>
													<label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if (bp_get_the_profile_field_is_required()) : ?><?php esc_html_e('(required)', 'socialv'); ?><?php endif; ?></label>

												<?php endif;
												if ('radio' == bp_get_the_profile_field_type()) : ?>

													<div class="radio">
														<span class="label"><?php bp_the_profile_field_name(); ?> <?php if (bp_get_the_profile_field_is_required()) : ?><?php esc_html_e('(required)', 'socialv'); ?><?php endif; ?></span>

														<?php bp_the_profile_field_options(); ?>

														<?php if (!bp_get_the_profile_field_is_required()) : ?>

															<a class="clear-value" href="javascript:clear( '<?php bp_the_profile_field_input_name(); ?>' );"><?php esc_html_e('Clear', 'socialv'); ?></a>

														<?php endif; ?>
													</div>

												<?php endif;
												if ('checkbox' == bp_get_the_profile_field_type()) : ?>

													<div class="checkbox">
														<span class="label"><?php bp_the_profile_field_name(); ?> <?php if (bp_get_the_profile_field_is_required()) : ?><?php esc_html_e('(required)', 'socialv'); ?><?php endif; ?></span>

														<?php bp_the_profile_field_options(); ?>
													</div>

												<?php endif;
												if ('datebox' == bp_get_the_profile_field_type()) : ?>

													<div class="datebox">

														<div class="form-floating">
															<select class="form-select" name="<?php bp_the_profile_field_input_name(); ?>_day" id="<?php bp_the_profile_field_input_name(); ?>_day" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" required <?php endif; ?>>
																<?php bp_the_profile_field_options('type=day'); ?>
															</select>
															<label for="<?php bp_the_profile_field_input_name(); ?>"> <?php esc_html_e('Day', 'socialv'); ?> </label>
														</div>

														<div class="form-floating">
															<select class="form-select" name="<?php bp_the_profile_field_input_name(); ?>_month" id="<?php bp_the_profile_field_input_name(); ?>_month" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" required <?php endif; ?>>
																<?php bp_the_profile_field_options('type=month'); ?>
															</select>
															<label for="<?php bp_the_profile_field_input_name(); ?>"> <?php esc_html_e('Month', 'socialv'); ?> </label>
														</div>

														<div class="form-floating">
															<select class="form-select" name="<?php bp_the_profile_field_input_name(); ?>_year" id="<?php bp_the_profile_field_input_name(); ?>_year" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" required <?php endif; ?>>
																<?php bp_the_profile_field_options('type=year'); ?>
															</select>
															<label for="<?php bp_the_profile_field_input_name(); ?>"> <?php esc_html_e('Year','socialv'); ?> </label>
														</div>

													</div>

												<?php endif;
												if ('url' == bp_get_the_profile_field_type()) : ?>

													<input type="text" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" class="form-control" placeholder="<?php bp_the_profile_field_name(); ?>" value="<?php bp_the_profile_field_edit_value(); ?>" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" required <?php endif; ?> />
													<label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if (bp_get_the_profile_field_is_required()) : ?><?php esc_html_e('(required)', 'socialv'); ?><?php endif; ?></label>

												<?php endif;
											} else {
												$field_type = bp_xprofile_create_field_type(bp_get_the_profile_field_type());
												$field_type->edit_field_html();
											}
											bp_the_profile_field_description();

											do_action('bp_custom_profile_edit_fields_pre_visibility');

											if (bp_current_user_can('bp_xprofile_change_field_visibility')) : ?>
												<p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>"><span id="<?php bp_the_profile_field_input_name(); ?>-2">
														<?php
														printf(
															__('This field can be seen by: %s', 'socialv'),
															'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
														);
														?>
													</span>
													<button type="button" class="visibility-toggle-link btn-sm btn socialv-btn-orange" aria-describedby="<?php bp_the_profile_field_input_name(); ?>-2" aria-expanded="false"><?php echo esc_html_x('Change', 'Change profile field visibility level', 'socialv'); ?></button>
												</p>

												<div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">
													<fieldset>
														<label><?php esc_html_e('Who can see this field?', 'socialv') ?></label>

														<?php bp_profile_visibility_radio_buttons() ?>

													</fieldset>
													<button type="button" class="field-visibility-settings-close btn-sm btn socialv-btn-orange"><?php esc_html_e('Close', 'socialv') ?></button>
												</div>
											<?php else : ?>
												<div class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
													<?php
													printf(
														__('This field can be seen by: %s', 'socialv'),
														'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
													);
													?>
												</div>
											<?php endif;

											/**
											 * Fires after the visibility options for a field.
											 *
											 * @since 1.1.0
											 */
											do_action('bp_custom_profile_edit_fields'); ?>

										</div>
									</div>
								<?php endwhile;
								do_action('bp_after_profile_field_content'); ?>
								<div class="form-edit-btn">
									<div class="submit">
										<input type="submit" name="profile-group-edit-submit" id="profile-group-edit-submit" class="btn socialv-btn-success" value="<?php esc_attr_e('Save Changes', 'socialv'); ?> " />
									</div>
								</div>
								<input type="hidden" name="field_ids" id="field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

								<?php wp_nonce_field('bp_xprofile_edit'); ?>
							</div>
						</form>

				<?php endwhile;
				endif; ?>
			</div>
		</div>
	</div>
</div>
<?php

do_action('bp_after_profile_edit_content');
