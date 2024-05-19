<?php

/**
 * BuddyPress - Members Register
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use function SocialV\Utility\socialv;
?>

<div id="buddypress">
	<div class="text-center">
		<?php

		/**
		 * Fires at the top of the BuddyPress member registration page template.
		 *
		 * @since 1.1.0
		 */

		do_action('bp_before_register_page'); ?>
	</div>
	<div class="card-main socialv-bp-login">
		<div class="card-inner">
			<div class="socialv-login-form">
				<?php socialv()->get_shortcode_content("register"); ?>
				<div class="page" id="register-page">

					<form action="<?php echo (bp_is_register_page() ? '' : bp_get_signup_page()); ?>" name="signup_form" id="signup_form" class="standard-form1" method="post" enctype="multipart/form-data">

						<?php if ('registration-disabled' == bp_get_current_signup_step()) : ?>

							<div id="template-notices" role="alert" aria-atomic="true">
								<?php do_action('template_notices'); ?>
							</div>

							<?php

							/**
							 * Fires before the display of the registration disabled message.
							 *
							 * @since 1.5.0
							 */
							do_action('bp_before_registration_disabled'); ?>

							<p class="register-message"><?php esc_html_e('User registration is currently not allowed.', 'socialv'); ?></p>

						<?php

							/**
							 * Fires after the display of the registration disabled message.
							 *
							 * @since 1.5.0
							 */
							do_action('bp_after_registration_disabled');
						endif; // registration-disabled signup step 	
						?>

						<?php if ('request-details' == bp_get_current_signup_step()) : ?>

							<div id="template-notices" role="alert" aria-atomic="true">
								<?php do_action('template_notices'); ?>

							</div>
							<?php

							/**
							 * Fires before the display of member registration account details fields.
							 *
							 * @since 1.1.0
							 */
							do_action('bp_before_account_details_fields'); ?>

							<div class="register-section" id="basic-details-section">

								<?php /***** Basic Account Details ******/ ?>

								<h4 class="mb-3"><?php esc_html_e('Account Details', 'socialv'); ?></h4>

								<label for="signup_username"><?php esc_html_e('Username', 'socialv'); ?> <?php esc_html_e('(required)', 'socialv'); ?></label>
								<?php

								/**
								 * Fires and displays any member registration username errors.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_signup_username_errors'); ?>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="iconly-Add-User icli"></i></span>
									<input type="text" name="signup_username" id="signup_username" class="form-control" placeholder="<?php esc_attr_e('Username', 'socialv'); ?>" value="<?php bp_signup_username_value(); ?>" <?php bp_form_field_attributes('username'); ?> />
								</div>

								<label for="signup_email"><?php esc_html_e('Email Address', 'socialv'); ?> <?php esc_html_e('(required)', 'socialv'); ?></label>
								<?php

								/**
								 * Fires and displays any member registration email errors.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_signup_email_errors'); ?>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="iconly-Message icli"></i></span>
									<input type="email" name="signup_email" id="signup_email" class="form-control" placeholder="<?php esc_attr_e('Email Address', 'socialv'); ?>" value="<?php bp_signup_email_value(); ?>" <?php bp_form_field_attributes('email'); ?> />
								</div>

								<label for="signup_password"><?php esc_html_e('Choose a Password', 'socialv'); ?> <?php esc_html_e('(required)', 'socialv'); ?></label>
								<?php

								/**
								 * Fires and displays any member registration password errors.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_signup_password_errors'); ?>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="iconly-Lock icli"></i></span>
									<input type="password" name="signup_password" id="signup_password" value="" class="password-entry form-control" placeholder="<?php esc_attr_e('Choose a Password', 'socialv'); ?>" <?php bp_form_field_attributes('password'); ?> />
								</div>
								<div id="pass-strength-result"></div>

								<label for="signup_password_confirm"><?php esc_html_e('Confirm Password', 'socialv'); ?> <?php esc_html_e('(required)', 'socialv'); ?></label>
								<?php

								/**
								 * Fires and displays any member registration password confirmation errors.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_signup_password_confirm_errors'); ?>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="iconly-Lock icli"></i></span>
									<input type="password" name="signup_password_confirm" id="signup_password_confirm" class="form-control" placeholder="<?php esc_attr_e('Confirm Password', 'socialv'); ?>" value="" class="password-entry-confirm" <?php bp_form_field_attributes('password'); ?> />
								</div>

								<?php

								/**
								 * Fires and displays any extra member registration details fields.
								 *
								 * @since 1.9.0
								 */
								do_action('bp_account_details_fields'); ?>

							</div><!-- #basic-details-section -->

							<?php

							/**
							 * Fires after the display of member registration account details fields.
							 *
							 * @since 1.1.0
							 */
							do_action('bp_after_account_details_fields');
							/***** Extra Profile Details ******/
							if (bp_is_active('xprofile')) :

								/**
								 * Fires before the display of member registration xprofile fields.
								 *
								 * @since 1.2.4
								 */
								do_action('bp_before_signup_profile_fields'); ?>

								<div class="register-section" id="profile-details-section">

									<h4 class="mb-3"><?php esc_html_e('Profile Details', 'socialv'); ?></h4>

									<?php /* Use the profile field loop to render input fields for the 'base' profile field group */
									if (bp_is_active('xprofile')) :

										if (bp_has_profile(bp_xprofile_signup_args())) : while (bp_profile_groups()) : bp_the_profile_group(); ?>
												<?php while (bp_profile_fields()) : bp_the_profile_field(); ?>
													<div<?php echo bp_get_field_css_class('editfield ' . 'col-12'); ?>>
														<?php
														$current_type = array('number', 'telephone', 'textbox', 'textarea', 'wp-biography', 'selectbox', 'radio', 'checkbox', 'datebox', 'url');
														if (in_array(bp_get_the_profile_field_type(), $current_type)) {
														?>
															<label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if (bp_get_the_profile_field_is_required()) : ?><?php esc_html_e('(required)', 'socialv'); ?><?php endif; ?></label>
															<div class="input-group mb-0">
																<?php
																do_action('bp_custom_profile_edit_fields_pre_visibility');
																if ('number' == bp_get_the_profile_field_type()) : ?>
																	<span class="input-group-text"><i class="iconly-Call icli"></i></span>
																	<input type="number" class="form-control" name="<?php bp_the_profile_field_input_name(); ?>" placeholder="<?php bp_the_profile_field_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" class="form-control" value="<?php bp_the_profile_field_edit_value(); ?>" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" <?php endif; ?> />
																<?php endif;
																if ('telephone' == bp_get_the_profile_field_type()) : ?>
																	<span class="input-group-text"><i class="iconly-Call icli"></i></span>
																	<input type="tel" class="form-control" name="<?php bp_the_profile_field_input_name(); ?>" placeholder="<?php bp_the_profile_field_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" class="form-control" value="<?php bp_the_profile_field_edit_value(); ?>" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" <?php endif; ?> />
																<?php endif;
																if ('textbox' == bp_get_the_profile_field_type()) : ?>
																	<span class="input-group-text"><i class="iconly-Edit-Square icli"></i></span>
																	<input type="text" class="form-control" name="<?php bp_the_profile_field_input_name(); ?>" placeholder="<?php bp_the_profile_field_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" class="form-control" value="<?php bp_the_profile_field_edit_value(); ?>" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" <?php endif; ?> />
																<?php endif;
																if ('textarea' == bp_get_the_profile_field_type() || 'wp-biography' == bp_get_the_profile_field_type()) : ?>
																	<label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if (bp_get_the_profile_field_is_required()) : ?><?php esc_html_e('(required)', 'socialv'); ?><?php endif; ?></label>
																	<?php
																	$content = "";
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

																	<select class="form-select" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" <?php endif; ?>>
																		<?php bp_the_profile_field_options(); ?>
																	</select>

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

																	<!-- <div class="datebox row"> -->

																	<div class="col-4 px-3">
																		<label for="<?php bp_the_profile_field_input_name(); ?>"><?php esc_html_e('Day', 'socialv'); ?></label>
																		<select class="form-select" name="<?php bp_the_profile_field_input_name(); ?>_day" id="<?php bp_the_profile_field_input_name(); ?>_day" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" <?php endif; ?>>
																			<?php bp_the_profile_field_options('type=day'); ?>
																		</select>
																	</div>

																	<div class="col-4 px-3">
																		<label for="<?php bp_the_profile_field_input_name(); ?>"><?php esc_html_e('Month', 'socialv'); ?></label>
																		<select class="form-select" name="<?php bp_the_profile_field_input_name(); ?>_month" id="<?php bp_the_profile_field_input_name(); ?>_month" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" <?php endif; ?>>
																			<?php bp_the_profile_field_options('type=month'); ?>
																		</select>
																	</div>

																	<div class="col-4 px-3">
																		<label for="<?php bp_the_profile_field_input_name(); ?>"><?php esc_html_e('Year', 'socialv'); ?></label>
																		<select class="form-select" name="<?php bp_the_profile_field_input_name(); ?>_year" id="<?php bp_the_profile_field_input_name(); ?>_year" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" <?php endif; ?>>
																			<?php bp_the_profile_field_options('type=year'); ?>
																		</select>
																	</div>

																	<!-- </div> -->

																<?php endif;
																if ('url' == bp_get_the_profile_field_type()) : ?>
																	<span class="input-group-text"><i class="icon-web"></i></span>
																	<input type="text" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" class="form-control" placeholder="<?php bp_the_profile_field_name(); ?>" value="<?php bp_the_profile_field_edit_value(); ?>" <?php if (bp_get_the_profile_field_is_required()) : ?>aria-required="true" <?php endif; ?> />

																<?php endif;


																/**
																 * Fires after the visibility options for a field.
																 *
																 * @since 1.1.0
																 */
																do_action('bp_custom_profile_edit_fields'); ?>

															</div>
														<?php
														} else {
															$field_type = bp_xprofile_create_field_type(bp_get_the_profile_field_type());
															$field_type->edit_field_html();
														}
														bp_the_profile_field_description();
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
														<?php endif ?>
								</div>
							<?php endwhile; ?>
							<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

				<?php endwhile;
										endif;
									endif;
									/**
									 * Fires and displays any extra member registration xprofile fields.
									 *
									 * @since 1.9.0
									 */
									do_action('bp_signup_profile_fields'); ?>

				</div><!-- #profile-details-section -->

			<?php do_action('bp_after_signup_profile_fields');
							endif;
							if (bp_get_blog_signup_allowed()) :

								/**
								 * Fires before the display of member registration blog details fields.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_before_blog_details_fields');
								/***** Blog Creation Details ******/ ?>

				<div class="register-section" id="blog-details-section">

					<h2><?php esc_html_e('Blog Details', 'socialv'); ?></h2>

					<p><label for="signup_with_blog"><input type="checkbox" name="signup_with_blog" id="signup_with_blog" value="1" <?php if ((int) bp_get_signup_with_blog_value()) : ?> checked="checked" <?php endif; ?> /> <?php esc_html_e('Yes, I\'d like to create a new site', 'socialv'); ?></label></p>

					<div id="blog-details" <?php if ((int) bp_get_signup_with_blog_value()) : ?>class="show" <?php endif; ?>>

						<label for="signup_blog_url"><?php esc_html_e('Blog URL', 'socialv'); ?> <?php esc_html_e('(required)', 'socialv'); ?></label>
						<?php

								/**
								 * Fires and displays any member registration blog URL errors.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_signup_blog_url_errors'); ?>

						<?php if (is_subdomain_install()) : ?>
							http:// <input type="text" name="signup_blog_url" id="signup_blog_url" value="<?php bp_signup_blog_url_value(); ?>" /> .<?php bp_signup_subdomain_base(); ?>
						<?php else : ?>
							<?php echo esc_url(home_url('/')); ?> <input type="text" name="signup_blog_url" id="signup_blog_url" value="<?php bp_signup_blog_url_value(); ?>" />
						<?php endif; ?>

						<label for="signup_blog_title"><?php esc_html_e('Site Title', 'socialv'); ?> <?php esc_html_e('(required)', 'socialv'); ?></label>
						<?php

								/**
								 * Fires and displays any member registration blog title errors.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_signup_blog_title_errors'); ?>
						<input type="text" name="signup_blog_title" id="signup_blog_title" value="<?php bp_signup_blog_title_value(); ?>" />

						<fieldset class="register-site">
							<legend class="label"><?php esc_html_e('Privacy: I would like my site to appear in search engines, and in public listings around this network.', 'socialv'); ?></legend>
							<?php

								/**
								 * Fires and displays any member registration blog privacy errors.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_signup_blog_privacy_errors'); ?>

							<label for="signup_blog_privacy_public"><input type="radio" name="signup_blog_privacy" id="signup_blog_privacy_public" value="public" <?php if ('public' == bp_get_signup_blog_privacy_value() || !bp_get_signup_blog_privacy_value()) : ?> checked="checked" <?php endif; ?> /> <?php esc_html_e('Yes', 'socialv'); ?></label>
							<label for="signup_blog_privacy_private"><input type="radio" name="signup_blog_privacy" id="signup_blog_privacy_private" value="private" <?php if ('private' == bp_get_signup_blog_privacy_value()) : ?> checked="checked" <?php endif; ?> /> <?php esc_html_e('No', 'socialv'); ?></label>
						</fieldset>

						<?php

								/**
								 * Fires and displays any extra member registration blog details fields.
								 *
								 * @since 1.9.0
								 */
								do_action('bp_blog_details_fields'); ?>

					</div>

				</div><!-- #blog-details-section -->

			<?php

								/**
								 * Fires after the display of member registration blog details fields.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_after_blog_details_fields');
							endif;
							/**
							 * Fires before the display of the registration submit buttons.
							 *
							 * @since 1.1.0
							 */
							do_action('bp_before_registration_submit_buttons');

							if (bp_get_membership_requests_required()) {
								$button_text = esc_html__('Submit Request', 'socialv');
							} else {
								$button_text = esc_html__('Complete Sign Up', 'socialv');
							}
			?>

			<div class="submit col-md-12 socialv-auth-button">
				<input type="submit" name="signup_submit" id="signup_submit" class="btn socialv-btn-primary" value="<?php echo esc_attr($button_text); ?>" />
			</div>


		<?php

							/**
							 * Fires after the display of the registration submit buttons.
							 *
							 * @since 1.1.0
							 */
							do_action('bp_after_registration_submit_buttons');
							wp_nonce_field('bp_new_signup');
						endif; // request-details signup step 
						if ('completed-confirmation' == bp_get_current_signup_step()) : ?>

			<div id="template-notices" role="alert" aria-atomic="true">
				<?php

							do_action('template_notices'); ?>

			</div>

			<?php

							/**
							 * Fires before the display of the registration confirmed messages.
							 *
							 * @since 1.5.0
							 */
							do_action('bp_before_registration_confirmed'); ?>

			<div id="template-notices" role="alert" aria-atomic="true">
				<?php if (bp_get_membership_requests_required()) : ?>
					<p><?php esc_html_e('You have successfully submitted your membership request! Our site moderators will review your submission and send you an activation email if your request is approved.', 'socialv'); ?></p>
				<?php elseif (bp_registration_needs_activation()) : ?>
					<p><?php esc_html_e('You have successfully created your account! To begin using this site you will need to activate your account via the email we have just sent to your address.', 'socialv'); ?></p>
				<?php else : ?>
					<p><?php esc_html_e('You have successfully created your account! Please log in using the username and password you have just created.', 'socialv'); ?></p>
				<?php endif; ?>
			</div>

		<?php

							/**
							 * Fires after the display of the registration confirmed messages.
							 *
							 * @since 1.5.0
							 */
							do_action('bp_after_registration_confirmed');
						endif; // completed-confirmation signup step 

						/**
						 * Fires and displays any custom signup steps.
						 *
						 * @since 1.1.0
						 */
						do_action('bp_custom_signup_steps'); ?>

		</form>
		<?php
		do_action('get_socialv_social_after');
		socialv()->get_shortcode_links('login');
		?>
			</div>
		</div>
	</div>
</div>

<?php

/**
 * Fires at the bottom of the BuddyPress member registration page template.
 *
 * @since 1.1.0
 */
do_action('bp_after_register_page'); ?>

</div><!-- #buddypress -->