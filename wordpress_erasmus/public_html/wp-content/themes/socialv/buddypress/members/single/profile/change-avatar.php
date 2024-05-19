<?php

/**
 * BuddyPress - Members Profile Change Avatar
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

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
								<ul class="list-inline m-0" >
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

			<div class="card-head card-header-border d-flex align-items-center justify-content-between">
				<div class="head-title">
					<h4 class="card-title"><?php esc_html_e('Change Avatar Photo', 'socialv'); ?></h4>
				</div>
			</div>

			<div class="card-inner">
				<div class="row">
					<?php do_action('bp_before_profile_avatar_upload_content'); ?>
					<?php if (!(int)bp_get_option('bp-disable-avatar-uploads')) : ?>
						<form action="" method="post" id="avatar-upload-form" class="standard-form" enctype="multipart/form-data">
							<?php if ('upload-image' == bp_get_avatar_admin_step()) : ?>

								<?php wp_nonce_field('bp_avatar_upload'); ?>
								<p><?php esc_html_e('Click below to select a JPG, GIF or PNG format photo from your computer and then click \'Upload Image\' to proceed.', 'socialv'); ?></p>

								<p id="avatar-upload">
									<label for="file" class="bp-screen-reader-text"><?php
																					/* translators: accessibility text */
																					esc_html_e('Select an image', 'socialv');
																					?></label>
									<input type="file" name="file" id="file" />
									<input type="submit" name="upload" id="upload" value="<?php esc_attr_e('Upload Image', 'socialv'); ?>" />
									<input type="hidden" name="action" id="action" value="bp_avatar_upload" />
								</p>

								<?php if (bp_get_user_has_avatar()) : ?>
									<p><?php esc_html_e("If you'd like to delete your current profile photo but not upload a new one, please use the delete profile photo button.", 'socialv'); ?></p>
									<p><a class="button edit" href="<?php bp_avatar_delete_link(); ?>"><?php esc_html_e('Delete My Profile Photo', 'socialv'); ?></a></p>
								<?php endif; ?>

							<?php endif; ?>

							<?php if ('crop-image' == bp_get_avatar_admin_step()) : ?>

								<h5><?php esc_html_e('Crop Your New Profile Photo', 'socialv'); ?></h5>

								<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" class="avatar" alt="<?php esc_attr_e('Profile photo to crop', 'socialv'); ?>" loading="lazy" />

								<div id="avatar-crop-pane">
									<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-crop-preview" class="avatar" alt="<?php esc_attr_e('Profile photo preview', 'socialv'); ?>" loading="lazy" />
								</div>

								<input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php esc_attr_e('Crop Image', 'socialv'); ?>" />

								<input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src(); ?>" />
								<input type="hidden" id="x" name="x" />
								<input type="hidden" id="y" name="y" />
								<input type="hidden" id="w" name="w" />
								<input type="hidden" id="h" name="h" />

								<?php wp_nonce_field('bp_avatar_cropstore'); ?>

							<?php endif; ?>
						</form>

						<?php bp_avatar_get_templates(); ?>

					<?php else : ?>

						<p><?php echo esc_html__('Your profile photo will be used on your profile and throughout the site. To change your profile photo, please create an account with using the same email address as you used to register with this site.', 'socialv'); ?></p>

					<?php endif; ?>

					<?php do_action('bp_after_profile_avatar_upload_content'); ?>

				</div>
			</div>
		</div>
	</div>
</div>